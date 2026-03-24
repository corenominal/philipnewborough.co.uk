<?php

namespace App\Controllers\Admin;

class Cache extends BaseController
{
    /**
     * Display all cache files with metadata.
     */
    public function index(): string
    {
        $files = $this->getCacheFiles();

        $totalSize    = array_sum(array_column($files, 'size'));
        $expiredCount = count(array_filter($files, static fn ($f) => $f['status'] === 'expired'));
        $activeCount  = count(array_filter($files, static fn ($f) => $f['status'] === 'active'));

        $data['files']        = $files;
        $data['totalSize']    = $totalSize;
        $data['expiredCount'] = $expiredCount;
        $data['activeCount']  = $activeCount;
        $data['js']           = ['admin/cache'];
        $data['title']        = 'Cache';

        return view('admin/cache/index', $data);
    }

    /**
     * Delete all cache files (excluding index.html).
     */
    public function clear(): \CodeIgniter\HTTP\RedirectResponse
    {
        $cachePath = $this->getCachePath();
        $deleted   = 0;

        $glob = glob($cachePath . '*');

        if ($glob !== false) {
            foreach ($glob as $filePath) {
                if (is_file($filePath) && basename($filePath) !== 'index.html') {
                    if (@unlink($filePath)) {
                        $deleted++;
                    }
                }
            }
        }

        return redirect()->to('/admin/cache')->with('success', "Cache cleared. {$deleted} file(s) deleted.");
    }

    /**
     * Delete a single cache file by filename.
     */
    public function delete(): \CodeIgniter\HTTP\RedirectResponse
    {
        $filename = $this->request->getPost('filename');

        if (! is_string($filename) || $filename === '') {
            return redirect()->to('/admin/cache')->with('error', 'Invalid cache filename.');
        }

        // Prevent path traversal: only allow alphanumeric chars, underscores, and hyphens
        if (! preg_match('/^[a-zA-Z0-9_\-]+$/', $filename)) {
            return redirect()->to('/admin/cache')->with('error', 'Invalid cache filename format.');
        }

        $filePath = $this->getCachePath() . $filename;

        if (! is_file($filePath)) {
            return redirect()->to('/admin/cache')->with('error', 'Cache file not found.');
        }

        if (@unlink($filePath)) {
            return redirect()->to('/admin/cache')->with('success', "Cache file '{$filename}' deleted.");
        }

        return redirect()->to('/admin/cache')->with('error', 'Failed to delete cache file.');
    }

    /**
     * Returns the normalised cache directory path (with trailing slash).
     */
    private function getCachePath(): string
    {
        $cacheConfig = config('Cache');
        $storePath   = $cacheConfig->file['storePath'] ?? (WRITEPATH . 'cache');

        return rtrim((string) $storePath, '\\/') . '/';
    }

    /**
     * Reads all cache files and returns an array of metadata for each.
     *
     * @return array<int, array<string, mixed>>
     */
    private function getCacheFiles(): array
    {
        $cachePath = $this->getCachePath();
        $now       = time();
        $files     = [];
        $glob      = glob($cachePath . '*');

        if ($glob === false) {
            return $files;
        }

        foreach ($glob as $filePath) {
            if (! is_file($filePath)) {
                continue;
            }

            $filename = basename($filePath);

            if ($filename === 'index.html') {
                continue;
            }

            $size  = (int) filesize($filePath);
            $mtime = (int) filemtime($filePath);

            $saveTime    = null;
            $ttl         = null;
            $expire      = null;
            $status      = 'unreadable';
            $dataPreview = null;
            $dataType    = null;

            $content = @file_get_contents($filePath);

            if ($content !== false) {
                try {
                    $parsed = @unserialize($content);

                    if (is_array($parsed) && isset($parsed['time'], $parsed['ttl'])) {
                        $saveTime = (int) $parsed['time'];
                        $ttl      = (int) $parsed['ttl'];
                        $expire   = $ttl > 0 ? $saveTime + $ttl : null;

                        if ($ttl === 0) {
                            $status = 'persistent';
                        } elseif ($now > $expire) {
                            $status = 'expired';
                        } else {
                            $status = 'active';
                        }

                        $value    = $parsed['data'] ?? null;
                        $dataType = gettype($value);

                        if (is_string($value)) {
                            $dataPreview = mb_strlen($value) > 300
                                ? mb_substr($value, 0, 300) . '…'
                                : $value;
                        } elseif (is_array($value) || is_object($value)) {
                            $json = json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                            if ($json !== false) {
                                $dataPreview = mb_strlen($json) > 600
                                    ? mb_substr($json, 0, 600) . '…'
                                    : $json;
                            } else {
                                $dataPreview = '[unencodable data]';
                            }
                        } elseif ($value !== null) {
                            $dataPreview = var_export($value, true);
                        }
                    }
                } catch (\Throwable $e) {
                    $status = 'unreadable';
                }
            }

            $files[] = [
                'filename'    => $filename,
                'size'        => $size,
                'mtime'       => $mtime,
                'saveTime'    => $saveTime,
                'ttl'         => $ttl,
                'expire'      => $expire,
                'status'      => $status,
                'dataType'    => $dataType,
                'dataPreview' => $dataPreview,
            ];
        }

        // Sort by save time descending (newest first), unreadable files last
        usort($files, static fn ($a, $b) => ($b['saveTime'] ?? -1) <=> ($a['saveTime'] ?? -1));

        return $files;
    }
}
