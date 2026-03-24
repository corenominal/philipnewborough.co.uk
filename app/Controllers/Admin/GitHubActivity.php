<?php

namespace App\Controllers\Admin;

use Hermawan\DataTables\DataTable;
use App\Models\GitHubActivityModel;

class GitHubActivity extends BaseController
{
    /**
     * Display the GitHub Activity admin page.
     *
     * @return string Rendered admin view output.
     */
    public function index()
    {
        $data['datatables'] = true;
        $data['js']         = ['admin/github_activity'];
        $data['title']      = 'GitHub Activity';

        return view('admin/github_activity/index', $data);
    }

    /**
     * Server-side DataTables endpoint for the GitHub activity table.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface JSON response for DataTables.
     */
    public function datatable()
    {
        $model   = new GitHubActivityModel();
        $builder = $model->builder();

        return DataTable::of($builder)
            ->edit('label', function ($row) {
                return '<span class="badge text-bg-' . esc($row->label_class) . '">' . esc($row->label) . '</span>';
            })
            ->edit('repo', function ($row) {
                if (!empty($row->link)) {
                    return '<a href="' . esc($row->link) . '" target="_blank" rel="noopener noreferrer">' . esc($row->repo) . '</a>';
                }

                return esc($row->repo);
            })
            ->toJson(true);
    }

    /**
     * Delete selected GitHub activity records.
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete()
    {
        $json = $this->request->getJSON(true);
        $ids  = $json['ids'] ?? [];

        // Sanitise: keep only positive integers
        $ids = array_values(array_filter(array_map('intval', $ids), fn($id) => $id > 0));

        if (empty($ids)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'No valid IDs provided.',
            ]);
        }

        $model = new GitHubActivityModel();
        $model->whereIn('id', $ids)->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'deleted' => count($ids),
        ]);
    }
}
