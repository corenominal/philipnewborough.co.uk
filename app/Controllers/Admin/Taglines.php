<?php

namespace App\Controllers\Admin;

use App\Models\TaglineModel;

class Taglines extends BaseController
{
    /**
     * List all taglines ordered by sort_order.
     */
    public function index(): string
    {
        $model = new TaglineModel();

        $data['taglines'] = $model->getOrdered();
        $data['js']       = ['admin/taglines'];
        $data['css']      = ['admin/taglines'];
        $data['title']    = 'Taglines';

        return view('admin/taglines/index', $data);
    }

    /**
     * Show the create form.
     */
    public function create(): string
    {
        $data['tagline'] = null;
        $data['js']      = ['admin/taglines'];
        $data['css']     = ['admin/taglines'];
        $data['title']   = 'Add Tagline';

        return view('admin/taglines/form', $data);
    }

    /**
     * Store a new tagline.
     */
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $tagline = trim((string) $this->request->getPost('tagline'));

        if ($tagline === '') {
            return redirect()->back()->withInput()->with('error', 'Tagline cannot be empty.');
        }

        $model    = new TaglineModel();
        $maxOrder = (int) ($model->selectMax('sort_order')->first()['sort_order'] ?? 0);

        $model->insert([
            'tagline'    => $tagline,
            'sort_order' => $maxOrder + 10,
            'is_active'  => 1,
        ]);

        return redirect()->to('/admin/taglines')->with('success', 'Tagline added successfully.');
    }

    /**
     * Show the edit form for an existing tagline.
     */
    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $model   = new TaglineModel();
        $tagline = $model->find($id);

        if ($tagline === null) {
            return redirect()->to('/admin/taglines')->with('error', 'Tagline not found.');
        }

        $data['tagline'] = $tagline;
        $data['js']      = ['admin/taglines'];
        $data['css']     = ['admin/taglines'];
        $data['title']   = 'Edit Tagline';

        return view('admin/taglines/form', $data);
    }

    /**
     * Update an existing tagline.
     */
    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model   = new TaglineModel();
        $tagline = $model->find($id);

        if ($tagline === null) {
            return redirect()->to('/admin/taglines')->with('error', 'Tagline not found.');
        }

        $newText = trim((string) $this->request->getPost('tagline'));

        if ($newText === '') {
            return redirect()->back()->withInput()->with('error', 'Tagline cannot be empty.');
        }

        $model->update($id, ['tagline' => $newText]);

        return redirect()->to('/admin/taglines')->with('success', 'Tagline updated successfully.');
    }

    /**
     * Delete one or more taglines (AJAX).
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function delete()
    {
        $json = $this->request->getJSON(true);
        $ids  = $json['ids'] ?? [];

        $ids = array_values(array_filter(array_map('intval', $ids), fn($id) => $id > 0));

        if (empty($ids)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'No valid IDs provided.',
            ]);
        }

        $model = new TaglineModel();
        $model->whereIn('id', $ids)->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => count($ids) . ' tagline(s) deleted.',
        ]);
    }

    /**
     * Move a tagline one position up (AJAX).
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function moveUp(int $id)
    {
        $model   = new TaglineModel();
        $current = $model->find($id);

        if ($current === null) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Not found.']);
        }

        $previous = $model
            ->where('sort_order <', $current['sort_order'])
            ->orderBy('sort_order', 'DESC')
            ->first();

        if ($previous === null) {
            return $this->response->setJSON(['status' => 'ok', 'message' => 'Already at top.']);
        }

        $model->update($current['id'], ['sort_order' => $previous['sort_order']]);
        $model->update($previous['id'], ['sort_order' => $current['sort_order']]);

        return $this->response->setJSON(['status' => 'success']);
    }

    /**
     * Move a tagline one position down (AJAX).
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function moveDown(int $id)
    {
        $model   = new TaglineModel();
        $current = $model->find($id);

        if ($current === null) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Not found.']);
        }

        $next = $model
            ->where('sort_order >', $current['sort_order'])
            ->orderBy('sort_order', 'ASC')
            ->first();

        if ($next === null) {
            return $this->response->setJSON(['status' => 'ok', 'message' => 'Already at bottom.']);
        }

        $model->update($current['id'], ['sort_order' => $next['sort_order']]);
        $model->update($next['id'], ['sort_order' => $current['sort_order']]);

        return $this->response->setJSON(['status' => 'success']);
    }

    /**
     * Toggle the active state of a tagline (AJAX).
     *
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function toggle(int $id)
    {
        $model   = new TaglineModel();
        $tagline = $model->find($id);

        if ($tagline === null) {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Not found.']);
        }

        $newState = $tagline['is_active'] ? 0 : 1;
        $model->update($id, ['is_active' => $newState]);

        return $this->response->setJSON(['status' => 'success', 'is_active' => $newState]);
    }
}
