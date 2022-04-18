<?php

namespace App\Controllers;

use App\Models\AntrianModel;

class Registration extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pendaftaran | BP Cindaga'
        ];

        return view('registration/home', $data);
    }
}
