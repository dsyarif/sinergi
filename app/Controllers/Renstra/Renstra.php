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
      'rpjmd'       => $this->rpjmd->orderBy('th_awal_rpjmd', 'Desc')->findAll(),
      'opd'         => $this->opd->orderBy('kode_opd', 'ASC')->where('unit =', '')->findAll(),
    );

    return view('admin/renstra/renstra_admin', $data);
  }

  public function set_rpjmd($id)
  {
    session()->set('rpjmd', $id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Disimpan!'
    ]);
  }
}
