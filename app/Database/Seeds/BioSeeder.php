<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BioSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $this->db->table('bios')->insert([
            'bio'        => "Web developer and tech enthusiast. When I'm not sat in front of my computer, I can be found reading Warhammer 40,000 fiction or riding my bike.",
            'is_active'  => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
