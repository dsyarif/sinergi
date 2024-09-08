<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $data = array(
            'title' => 'Dashboard',
        );
        return view('admin/dashboard_view', $data);
    }
}
