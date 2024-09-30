<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TujuanRenstra extends BaseController
{
  public function add($kode)
  {
    $data = array(
      'title'       => 'Tujuan - Rencana Strategis',
      'kode_opd'   => $kode,
      'tujuan'      => $this->tujuanrenstra->join('tb_opd', 'tb_tujuan_renstra.kode_opd = tb_opd.kode_opd')->orderBy('kode_tujuan', 'ASC')->where('tb_tujuan_renstra.kode_opd', $kode)->findAll(),
    );

    return view('admin/renstra/tujuan_renstra_admin', $data);
  }

  public function save()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $data = [
      'kode_tujuan'     => $this->request->getPost('kode_tujuan'),
      'uraian_tujuan'   => $this->request->getPost('uraian_tujuan'),
      'kode_opd'        => $this->request->getPost('kode_opd'),
      'id_rpjmd'        => $rpjmd['id_rpjmd'],
    ];
    $this->tujuanrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('tujuan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function update()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $data = [
      'id_tujuan_renstra'     => $this->request->getPost('id_tujuan_renstra'),
      'kode_tujuan'     => $this->request->getPost('kode_tujuan'),
      'uraian_tujuan'   => $this->request->getPost('uraian_tujuan'),
      'kode_opd'        => $this->request->getPost('kode_opd'),
      'id_rpjmd'        => $rpjmd['id_rpjmd'],
    ];
    $this->tujuanrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate');

    return redirect()->to('tujuan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete($id)
  {
    $this->tujuanrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }
}
