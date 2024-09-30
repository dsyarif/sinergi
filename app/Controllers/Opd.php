<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Opd extends BaseController
{
  public function index()
  {
    $data = array(
      'title'       => 'OPD',
      'opd'         => $this->opd->orderBy('kode_opd', 'ASC')->findAll(),
    );

    return view('admin/opd_admin', $data);
  }
}
