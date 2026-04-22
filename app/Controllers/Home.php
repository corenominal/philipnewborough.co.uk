<?php

namespace App\Controllers;

use DateTime;
use App\Models\BioModel;
use App\Models\GitHubActivityModel;
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
        $data['github_events'] = (new GitHubActivityModel())->getLatest();
        $data['blog_posts']    = $this->fetchBlogPosts();
        $data['statuses']      = $this->fetchStatuses();
        $data['bookmarks']     = $this->fetchBookmarks();

        return view('home', $data);
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
        ], 'blog');

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
        ], 'status');

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
        ], 'bookmarks');

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

            $bookmark['domain']            = '';
            $bookmark['youtube_video_id']  = '';

            if (! empty($bookmark['url'])) {
                $parsed = parse_url($bookmark['url']);

                if (isset($parsed['host'])) {
                    $bookmark['domain'] = preg_replace('/^www\./', '', $parsed['host']);
                }

                $host = $parsed['host'] ?? '';

                if (in_array($host, ['www.youtube.com', 'youtube.com'], true)) {
                    parse_str($parsed['query'] ?? '', $qs);
                    $bookmark['youtube_video_id'] = $qs['v'] ?? '';
                } elseif ($host === 'youtu.be') {
                    $bookmark['youtube_video_id'] = ltrim($parsed['path'] ?? '', '/');
                }
            }

            return $bookmark;
        }, $data['items']);
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

    private function apiGet(string $url, array $headers = [], string $label = 'apiget'): ?array
    {
        // Cache key derived from label + URL + headers so different requests don't collide
        $cache = \Config\Services::cache();
        $cacheKey = 'apiget_' . $label . '_' . md5($url . '|' . json_encode($headers));

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
