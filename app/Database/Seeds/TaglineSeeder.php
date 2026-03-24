<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TaglineSeeder extends Seeder
{
    public function run()
    {
        $taglines = [
            'Web Developer',
            'PHP Enthusiast',
            'Tech Explorer',
            '40K Lore Keeper',
            'Warhammer Fan',
            'Cyclist',
            'Open Source Fan',
        ];

        $now  = date('Y-m-d H:i:s');
        $rows = [];

        foreach ($taglines as $index => $text) {
            $rows[] = [
                'tagline'    => $text,
                'sort_order' => ($index + 1) * 10,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $this->db->table('taglines')->insertBatch($rows);
    }
}
