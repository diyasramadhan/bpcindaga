<?php

namespace App\Controllers;

class HomeCi extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
}
