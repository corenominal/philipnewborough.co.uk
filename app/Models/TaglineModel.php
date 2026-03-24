<?php

namespace App\Models;

use CodeIgniter\Model;

class TaglineModel extends Model
{
    protected $table            = 'taglines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'tagline',
        'sort_order',
        'is_active',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Returns all taglines ordered by sort_order ascending.
     */
    public function getOrdered(): array
    {
        return $this->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * Returns only active taglines ordered by sort_order ascending.
     */
    public function getActive(): array
    {
        return $this->where('is_active', 1)->orderBy('sort_order', 'ASC')->findAll();
    }
}
