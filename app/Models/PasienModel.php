<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table      = 'pasien';
    protected $useTimestamps = true;

    public function search($keyword)
    {
        // $builder = $this->tabel('antrian');
        // $builder->like('nama_pasien', $keyword);
        // return $builder;

        return $this->table('antrian')->like('nama_pasien', $keyword);
    }


    // protected $allowedFields = ['', 'slug', 'penulis', 'penerbit', 'sampul'];

    // public function getKomik($slug = false)
    // {
    //     if ($slug == false) {
    //         return $this->findAll();
    //     }
    //     return $this->where(['slug' => $slug])->first();
    // }
}
