<?php

namespace App\Controllers\Admin;

use App\Models\BioModel;

class Bio extends BaseController
{
    /**
     * List all bio versions and show the form to add a new one.
     */
    public function index(): string
    {
        $model = new BioModel();

        $data['bios']   = $model->getAll();
        $data['active'] = $model->getActive();
        $data['js']     = ['admin/bio'];
        $data['title']  = 'Bio';

        return view('admin/bio/index', $data);
    }

    /**
     * Store a new bio and set it as active.
     */
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $bio = trim((string) $this->request->getPost('bio'));

        if ($bio === '') {
            return redirect()->back()->withInput()->with('error', 'Bio cannot be empty.');
        }

        $model = new BioModel();
        $id    = $model->insert(['bio' => $bio, 'is_active' => 0]);
        $model->activate((int) $id);

        return redirect()->to('/admin/bio')->with('success', 'Bio updated successfully.');
    }

    /**
     * Set an existing bio record as the active bio.
     */
    public function activate(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $model = new BioModel();

        if ($model->find($id) === null) {
            return redirect()->to('/admin/bio')->with('error', 'Bio not found.');
        }

        $model->activate($id);

        return redirect()->to('/admin/bio')->with('success', 'Bio activated successfully.');
    }
}
