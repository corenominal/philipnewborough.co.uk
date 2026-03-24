<?php

namespace App\Models;

use CodeIgniter\Model;

class BioModel extends Model
{
    protected $table            = 'bios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'bio',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Returns the currently active bio, or null if none exists.
     */
    public function getActive(): ?array
    {
        return $this->where('is_active', 1)->first();
    }

    /**
     * Returns all bios ordered by newest first.
     */
    public function getAll(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Sets the given bio as active and deactivates all others.
     */
    public function activate(int $id): void
    {
        $this->db->table($this->table)->update(['is_active' => 0]);
        $this->update($id, ['is_active' => 1]);
    }
}
