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
    }
}
