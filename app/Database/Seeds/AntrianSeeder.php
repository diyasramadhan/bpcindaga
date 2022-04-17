<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AntrianSeeder extends Seeder
{
    public function run()
    {
        // use the factory to create a Faker\Generator instance
        $faker = \Faker\Factory::create('id_ID');
        for ($i = 0; $i < 50; $i++) {
            $data = [
                'no_rekmed'    => $faker->ean13,
                'nama_pasien'       => $faker->name,
                'status'            => 'Sedang Menunggu Panggilan Dokter',
                'created_at'        => Time::now(),
                'updated_at'        => Time::now()
            ];
            $this->db->table('antrian')->insert($data);
        }

        // Simple Queries
        // $this->db->query("INSERT INTO users (username, email) VALUES(:username:, :email:)", $data);

        // Using Query Builder
    }
}
