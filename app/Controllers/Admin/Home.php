<?php

namespace App\Controllers\Admin;

use App\Models\BioModel;
use App\Models\TaglineModel;
use App\Models\GitHubActivityModel;

class Home extends BaseController
{
    /**
     * Display the Admin Dashboard page.
     */
    public function index(): string
    {
        $taglineModel  = new TaglineModel();
        $bioModel      = new BioModel();
        $activityModel = new GitHubActivityModel();

        // Tagline stats
        $taglines              = $taglineModel->findAll();
        $data['taglineTotal']  = count($taglines);
        $data['taglineActive'] = count(array_filter($taglines, static fn ($t) => (bool) $t['is_active']));

        // Bio stats
        $data['bioCount']  = $bioModel->countAllResults();
        $data['activeBio'] = $bioModel->getActive();

        // GitHub Activity stats
        $data['activityTotal']   = $activityModel->countAllResults();
        $data['recentActivity']  = $activityModel->getLatest(6);

        // Cache file count
        $cacheConfig = config('Cache');
        $storePath   = $cacheConfig->file['storePath'] ?? (WRITEPATH . 'cache');
        $cachePath   = rtrim((string) $storePath, '\\/') . '/';
        $glob        = glob($cachePath . '*') ?: [];
        $data['cacheCount'] = count(array_filter($glob, static fn ($f) => is_file($f) && basename($f) !== 'index.html'));

        $data['js']    = ['admin/home'];
        $data['css']   = ['admin/home'];
        $data['title'] = 'Admin Dashboard';

        return view('admin/home', $data);
    }

}
