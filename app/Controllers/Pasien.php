<?php

namespace App\Controllers;

use App\Models\PasienModel;
use CodeIgniter\Validation\Rules;
use Error;
use Kint\Parser\FsPathPlugin;

class Pasien extends BaseController
{
    protected $komikmodel;
    public function __construct()
    {
        $this->komikmodel = new PasienModel();
    }

    public function index()
    {
        //$komik =  $this->komikmodel->findAll();

        $data = [
            'title' => 'Komik ',
            'komik' => $this->komikmodel->getKomik()
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikmodel->getKomik($slug)
        ];

        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('judul Komik' . $slug . 'Tidak Ditemukan');
        }

        return view('komik/detail', $data);
    }



    public function create()
    {
        //session();
        $data = [
            'title' => 'From Tambah data Komik',
            'validation' => \config\Services::validation()
        ];
        return view('komik/create', $data);
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



    public function delete($id)
    {
        $komik = $this->komikmodel->find($id);

        if ($komik['sampul'] != 'default.png') {
            unlink('img/' . $komik['sampul']);
        }

        $this->komikmodel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/komik');
    }



    public function edit($slug)
    {
        $data = [
            'title' => 'From edit data Komik',
            'validation' => \config\Services::validation(),
            'komik' => $this->komikmodel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }



    public function update($id)
    {
        //cek Judul
        $komiklama = $this->komikmodel->getKomik($this->request->getVar('slug'));
        if ($komiklama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        //Validasi Input
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
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
            return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaSampul);
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        //membuat slug dari judul
        $slug = url_title($this->request->getVar('judul'), '-', true);

        //Query Insert Data
        $this->komikmodel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul,
        ]);

        //pesan singkat untuk keberhasilan 
        session()->setFlashdata('pesan', 'Data berhasil diubah.');

        //kembali ke halaman data komik
        return redirect()->to('/komik');
    }
}
