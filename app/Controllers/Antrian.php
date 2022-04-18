<?php

namespace App\Controllers;

use App\Models\AntrianModel;

class Antrian extends BaseController
{
    protected $antrianmodel;
    public function __construct()
    {
        $this->antrianmodel = new AntrianModel();
    }

    public function index()
    {

        $curentPage = $this->request->getVar('page_antrian') ? $this->request->getVar('page_antrian') : 1;

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $antrian = $this->antrianmodel->search($keyword);
        } else {
            $antrian = $this->antrianmodel;
        }

        $data = [
            'title' => 'Pendaftaran | BP Cindaga ',
            // 'antrian' => $this->antrianmodel->findAll()
            'antrian' => $this->antrianmodel->paginate(5, 'antrian'),
            'pager' => $this->antrianmodel->pager,
            'curentPage' => $curentPage,
            'waktu_layanan' => '',
        ];

        return view('registration/klinik/antrian', $data);
    }

    public function antrian_create()
    {
        //session();
        $data = [
            'title' => 'From Pendaftaran Klinik | BP Cindaga',
            'validation' => \config\Services::validation()
        ];
        return view('registration/create_antrian', $data);
    }


    public function save()
    {
        //Validasi Input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} Komik Harus di isi',
                    'is_unique' => '{field} Komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran file terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ])) {
            // $validation = \config\Services::validation();
            // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('/komik/create')->withInput();
        }

        //Ambil gambar
        $fileSampul = $this->request->getFile('sampul');
        //cek apakah ada gambar
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            //nama file sampul randaom
            $namaSampul = $fileSampul->getRandomName();
            //Pindan fiel ke folder
            $fileSampul->move('img', $namaSampul);
        }

        //membuat slug dari judul
        $slug = url_title($this->request->getVar('judul'), '-', true);

        //Query Insert Data
        $this->komikmodel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        //pesan singkat untuk keberhasilan 
        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        //kembali ke halaman data komik
        return redirect()->to('/komik');
    }
}
