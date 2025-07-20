<?php

namespace App\Controllers;

class Entry extends BaseController
{
    public function index(): string
    {
        return view('home');
    }

    public function entry(): string
    {
        return view('entry');
    }

    public function report()
    {
        return view('report');
    }

    public function setup()
    {
        return view('setup');
    }


}
