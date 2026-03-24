<?php

namespace App\Controllers;

use DateTime;
use App\Models\BioModel;
use App\Models\TaglineModel;

class Home extends BaseController
{
    public function index(): string
    {
        $data['js']            = ['home'];
        $data['css']           = ['home'];
        $data['title']         = 'Home';
        $data['taglines']      = (new TaglineModel())->getActive();
        $data['bio']           = (new BioModel())->getActive()['bio'] ?? '';
        $data['github_events'] = $this->fetchGitHubActivity();
        $data['blog_posts']    = $this->fetchBlogPosts();
        $data['statuses']      = $this->fetchStatuses();
        $data['bookmarks']     = $this->fetchBookmarks();

        return view('home', $data);
    }

    private function fetchGitHubActivity(): array
    {
        $username = (string) config('GitHub')->username;

        if (empty($username)) {
            return [];
        }

        $events = $this->apiGet(
            'https://api.github.com/users/' . rawurlencode($username) . '/events/public',
            [
                'User-Agent: ' . (config('App')->siteName ?: 'PhilipNewborough'),
                'Accept: application/vnd.github.v3+json',
            ]
        );

        if ($events === null) {
            return [];
        }

        return array_slice($this->formatGitHubEvents($events), 0, 8);
    }

    private function fetchBlogPosts(): array
    {
        $baseUrl = rtrim((string) config('Urls')->blog, '/');

        if (empty($baseUrl)) {
            return [];
        }

        $data = $this->apiGet($baseUrl . '/api/posts/latest', [
            'ApiKey: ' . config('ApiKeys')->masterKey,
            'Accept: application/json',
        ]);

        if (! isset($data['data']) || ! is_array($data['data'])) {
            return [];
        }

        return array_map(function (array $post): array {
            try {
                $post['published_at_formatted'] = isset($post['published_at'])
                    ? (new DateTime($post['published_at']))->format('d M Y')
                    : '';
            } catch (\Exception $e) {
                $post['published_at_formatted'] = '';
            }

            return $post;
        }, $data['data']);
    }

    private function fetchStatuses(): array
    {
        $baseUrl = rtrim((string) config('Urls')->status, '/');

        if (empty($baseUrl)) {
            return [];
        }

        $data = $this->apiGet($baseUrl . '/api/statuses/latest', [
            'ApiKey: ' . config('ApiKeys')->masterKey,
            'Accept: application/json',
        ]);

        if (! isset($data['data']) || ! is_array($data['data'])) {
            return [];
        }

        return array_map(function (array $status): array {
            $status['created_at_formatted'] = $this->timeAgo($status['created_at'] ?? '');

            return $status;
        }, $data['data']);
    }

    private function fetchBookmarks(): array
    {
        $baseUrl = rtrim((string) config('Urls')->bookmarks, '/');

        if (empty($baseUrl)) {
            return [];
        }

        $data = $this->apiGet($baseUrl . '/api/bookmarks/latest', [
            'ApiKey: ' . config('ApiKeys')->masterKey,
            'Accept: application/json',
        ]);

        if (! isset($data['items']) || ! is_array($data['items'])) {
            return [];
        }

        return array_map(function (array $bookmark): array {
            try {
                $bookmark['created_at_formatted'] = isset($bookmark['created_at'])
                    ? (new DateTime($bookmark['created_at']))->format('d M Y')
                    : '';
            } catch (\Exception $e) {
                $bookmark['created_at_formatted'] = '';
            }

            $bookmark['domain'] = '';

            if (! empty($bookmark['url'])) {
                $parsed = parse_url($bookmark['url']);

                if (isset($parsed['host'])) {
                    $bookmark['domain'] = preg_replace('/^www\./', '', $parsed['host']);
                }
            }

            return $bookmark;
        }, $data['items']);
    }

    private function formatGitHubEvents(array $events): array
    {
        $formatted = [];

        foreach ($events as $event) {
            $type        = $event['type'] ?? '';
            $repo        = $event['repo']['name'] ?? '';
            $createdAt   = $event['created_at'] ?? '';
            $link        = 'https://github.com/' . $repo;
            $icon        = 'bi-code-square';
            $description = '';
            $label       = '';
            $labelClass  = 'secondary';

            switch ($type) {
                case 'PushEvent':
                    $commits     = $event['payload']['commits'] ?? null;
                    $count       = isset($event['payload']['size'])
                        ? (int) $event['payload']['size']
                        : (is_array($commits) ? count($commits) : 0);

                    // If the payload doesn't include commits or size, try the compare API
                    if ($count === 0 && isset($event['payload']['before'], $event['payload']['head']) && is_string($repo) && $repo !== '') {
                        $before = $event['payload']['before'];
                        $head   = $event['payload']['head'];

                        $headers = [
                            'User-Agent: ' . (config('App')->siteName ?: 'PhilipNewborough'),
                            'Accept: application/vnd.github.v3+json',
                        ];

                        $token = (string) config('GitHub')->token;
                        if (! empty($token)) {
                            $headers[] = 'Authorization: token ' . $token;
                        }

                        $compareUrl = 'https://api.github.com/repos/' . $repo . '/compare/' . rawurlencode($before) . '...' . rawurlencode($head);
                        $compare    = $this->apiGet($compareUrl, $headers);

                        if (is_array($compare) && isset($compare['total_commits'])) {
                            $count = (int) $compare['total_commits'];
                        }
                    }

                    $branch      = ltrim(str_replace('refs/heads/', '', $event['payload']['ref'] ?? 'main'), '/');
                    $icon        = 'bi-git';
                    $label       = 'push';
                    $labelClass  = 'primary';
                    $description = sprintf(
                        'Pushed %d commit%s to <code>%s</code> on <strong>%s</strong>',
                        $count,
                        $count !== 1 ? 's' : '',
                        esc($branch),
                        esc($repo)
                    );
                    break;

                case 'CreateEvent':
                    $refType     = $event['payload']['ref_type'] ?? 'repository';
                    $ref         = $event['payload']['ref'] ?? '';
                    $icon        = 'bi-plus-circle-fill';
                    $label       = 'create';
                    $labelClass  = 'success';
                    $description = $ref
                        ? sprintf('Created %s <code>%s</code> on <strong>%s</strong>', esc($refType), esc($ref), esc($repo))
                        : sprintf('Created repository <strong>%s</strong>', esc($repo));
                    break;

                case 'DeleteEvent':
                    $refType     = $event['payload']['ref_type'] ?? 'branch';
                    $ref         = $event['payload']['ref'] ?? '';
                    $icon        = 'bi-dash-circle';
                    $label       = 'delete';
                    $labelClass  = 'danger';
                    $description = sprintf('Deleted %s <code>%s</code> on <strong>%s</strong>', esc($refType), esc($ref), esc($repo));
                    break;

                case 'WatchEvent':
                    $icon        = 'bi-star-fill';
                    $label       = 'star';
                    $labelClass  = 'warning';
                    $description = sprintf('Starred <strong>%s</strong>', esc($repo));
                    break;

                case 'ForkEvent':
                    $icon        = 'bi-diagram-2-fill';
                    $label       = 'fork';
                    $labelClass  = 'info';
                    $description = sprintf('Forked <strong>%s</strong>', esc($repo));
                    break;

                case 'IssuesEvent':
                    $action      = $event['payload']['action'] ?? 'updated';
                    $issueTitle  = $event['payload']['issue']['title'] ?? '';
                    $link        = $event['payload']['issue']['html_url'] ?? $link;
                    $icon        = 'bi-exclamation-circle-fill';
                    $label       = strtolower($action) . ' issue';
                    $labelClass  = 'secondary';
                    $description = sprintf('%s issue <em>"%s"</em> on <strong>%s</strong>', ucfirst((string) esc($action)), esc($issueTitle), esc($repo));
                    break;

                case 'PullRequestEvent':
                    $action      = $event['payload']['action'] ?? 'updated';
                    $prTitle     = $event['payload']['pull_request']['title'] ?? '';
                    $link        = $event['payload']['pull_request']['html_url'] ?? $link;
                    $icon        = 'bi-arrow-left-right';
                    $label       = strtolower($action) . ' PR';
                    $labelClass  = 'primary';
                    $description = sprintf('%s PR <em>"%s"</em> on <strong>%s</strong>', ucfirst((string) esc($action)), esc($prTitle), esc($repo));
                    break;

                case 'IssueCommentEvent':
                    $issueTitle  = $event['payload']['issue']['title'] ?? '';
                    $link        = $event['payload']['comment']['html_url'] ?? $link;
                    $icon        = 'bi-chat-fill';
                    $label       = 'comment';
                    $labelClass  = 'secondary';
                    $description = sprintf('Commented on <em>"%s"</em> in <strong>%s</strong>', esc($issueTitle), esc($repo));
                    break;

                case 'ReleaseEvent':
                    $tagName     = $event['payload']['release']['tag_name'] ?? '';
                    $link        = $event['payload']['release']['html_url'] ?? $link;
                    $icon        = 'bi-tag-fill';
                    $label       = 'release';
                    $labelClass  = 'success';
                    $description = sprintf('Released <code>%s</code> on <strong>%s</strong>', esc($tagName), esc($repo));
                    break;

                case 'PullRequestReviewEvent':
                    $prTitle     = $event['payload']['pull_request']['title'] ?? '';
                    $link        = $event['payload']['pull_request']['html_url'] ?? $link;
                    $icon        = 'bi-eye-fill';
                    $label       = 'review';
                    $labelClass  = 'info';
                    $description = sprintf('Reviewed PR <em>"%s"</em> on <strong>%s</strong>', esc($prTitle), esc($repo));
                    break;

                case 'CommitCommentEvent':
                    $link        = $event['payload']['comment']['html_url'] ?? $link;
                    $icon        = 'bi-chat-square-dots-fill';
                    $label       = 'commit comment';
                    $labelClass  = 'secondary';
                    $description = sprintf('Commented on a commit in <strong>%s</strong>', esc($repo));
                    break;

                default:
                    $icon        = 'bi-activity';
                    $description = sprintf('Activity on <strong>%s</strong>', esc($repo));
                    break;
            }

            if (! empty($description)) {
                $formatted[] = [
                    'icon'        => $icon,
                    'description' => $description,
                    'link'        => $link,
                    'repo'        => $repo,
                    'created_at'  => $createdAt,
                    'time_ago'    => $this->timeAgo($createdAt),
                    'type'        => $type,
                    'label'       => $label,
                    'label_class' => $labelClass,
                ];
            }
        }

        return $formatted;
    }

    private function timeAgo(string $dateString): string
    {
        if (empty($dateString)) {
            return '';
        }

        try {
            $then = new DateTime($dateString);
            $now  = new DateTime();
            $diff = $now->diff($then);

            if ($diff->days > 7) {
                return $then->format('d M Y');
            }

            if ($diff->days >= 1) {
                return $diff->days . 'd ago';
            }

            if ($diff->h >= 1) {
                return $diff->h . 'h ago';
            }

            if ($diff->i >= 1) {
                return $diff->i . 'm ago';
            }

            return 'just now';
        } catch (\Exception $e) {
            return '';
        }
    }

    private function apiGet(string $url, array $headers = []): ?array
    {
        // Cache key derived from URL + headers so different requests don't collide
        $cache = \Config\Services::cache();
        $cacheKey = 'apiget_' . md5($url . '|' . json_encode($headers));

        // Return cached response when available
        $cached = $cache->get($cacheKey);
        if ($cached !== null) {
            return $cached;
        }

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_HTTPHEADER     => $headers,
        ]);

        $body       = curl_exec($ch);
        $statusCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error      = curl_error($ch);
        curl_close($ch);

        if ($body === false || $error !== '') {
            log_message('error', 'Home::apiGet failed [' . $url . ']: ' . $error);

            return null;
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            log_message('error', 'Home::apiGet non-2xx [' . $url . ']: HTTP ' . $statusCode);

            return null;
        }

        $decoded = json_decode($body, true);

        // Only cache successful decoded array responses for 10 minutes
        if (is_array($decoded)) {
            try {
                $cache->save($cacheKey, $decoded, 600);
            } catch (\Exception $e) {
                // Ignore cache save failures — allow API to continue working
            }
        }

        return is_array($decoded) ? $decoded : null;
    }
}
