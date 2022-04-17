<?php

namespace App\Controllers;

use App\Models\AntrianModel;

class Registration extends BaseController
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
        ];

        return view('registration/home', $data);
    }
}
