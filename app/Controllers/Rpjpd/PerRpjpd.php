<?php

namespace App\Controllers\Rpjpd;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PerRpjpd extends BaseController
{
  public function index()
  {
    $data = array(
      'title'           => 'Periode RPJPD',
      'rpjpd' => $this->rpjpd->orderBy('th_awal_rpjpd', 'Desc')->findAll()
    );

    return view('admin/rpjpd/rpjpd_admin', $data);
  }

  public function save()
  {
    $data_periode = $this->rpjpd->where('status_periode', 'Aktif')->first();
    if (empty($data_periode)) {
      $data = [
        'th_awal_rpjpd' => $this->request->getVar('th_awal_rpjpd'),
        'th_akhir_rpjpd' => $this->request->getVar('th_awal_rpjpd') + 20,
      ];
      $this->rpjpd->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan!');
    } else {
      session()->setFlashdata('danger', 'Data Gagal Disimpan, masih ada Periode RPJPD yang masih aktif');
    }
    return redirect()->to('rpjpd');
  }

  public function delete($id)
  {
    $this->rpjpd->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  function update()
  {
    $data = [
      'id_rpjpd'        => $this->request->getVar('id_rpjpd'),
      'periode_rpjpd'   => $this->request->getVar('periode_rpjpd'),
      'th_awal_rpjpd'   => $this->request->getVar('th_awal_rpjpdd'),
      'th_akhir_rpjpd'  => $this->request->getVar('th_awal_rpjpdd') + 20,
    ];
    $this->rpjpd->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate!');
    return redirect()->to('rpjpd');
  }
}
