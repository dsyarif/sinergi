<?php

namespace App\Controllers\Rpjmd;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PeriodeRpjmd extends BaseController
{
  public function index()
  {
    $data = array(
      'title'           => 'Periode RPJMD',
      'rpjpd'           => $this->rpjpd->orderBy('th_awal_rpjpd', 'Desc')->findAll(),
      'rpjmd'           => $this->rpjmd->join('tb_rpjpd', 'tb_rpjmd.id_rpjpd = tb_rpjpd.id_rpjpd', 'left')->orderBy('th_awal_rpjmd', 'Desc')->findAll()
    );

    return view('admin/rpjmd/rpjmd_admin', $data);
  }

  public function save()
  {
    $data_periode = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    if (empty($data_periode)) {
      $data = [
        'id_rpjpd' => $this->request->getVar('id_rpjpd'),
        'th_awal_rpjmd' => $this->request->getVar('th_awal_rpjmd'),
        'th_akhir_rpjmd' => $this->request->getVar('th_awal_rpjmd') + 5,
      ];
      $this->rpjmd->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan!');
    } else {
      session()->setFlashdata('danger', 'Data Gagal Disimpan, masih ada Periode RPJMD yang masih aktif');
    }
    return redirect()->to('rpjmd');
  }

  function update()
  {
    $data = [
      'id_rpjmd'        => $this->request->getVar('id_rpjmd'),
      'status_rpjmd'   => $this->request->getVar('status_rpjmd'),
      'th_awal_rpjmd'   => $this->request->getVar('th_awal_rpjmdd'),
      'th_akhir_rpjmd'  => $this->request->getVar('th_awal_rpjmdd') + 5,
      'status_rpjmd'  => $this->request->getVar('status_rpjmd'),
      'id_rpjpd'  => $this->request->getVar('id_rpjpd'),
    ];
    $this->rpjmd->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate!');
    return redirect()->to('rpjmd');
  }

  public function delete($id)
  {
    $this->rpjmd->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }
}
