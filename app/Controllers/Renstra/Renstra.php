<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Renstra extends BaseController
{
  public function index()
  {
    $data = array(
      'title'       => 'Rencana Strategis',
      'opd'         => $this->opd->orderBy('kode_opd', 'ASC')->where('unit =', '')->findAll(),
    );

    return view('admin/renstra/renstra_admin', $data);
  }
}
