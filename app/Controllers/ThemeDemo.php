<?php

namespace App\Controllers;

class ThemeDemo extends BaseController
{
    public function index(): string
    {
        return view('theme_demo');
    }
}
