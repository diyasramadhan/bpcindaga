<?php

namespace App\Controllers;

class TesPage extends BaseController
{
    public function index()
    {
        return view('pages/home');
    }
}
