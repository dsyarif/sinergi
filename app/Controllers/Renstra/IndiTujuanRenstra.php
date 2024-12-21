<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class IndiTujuanRenstra extends BaseController
{
  public function add($id)
  {
    $tujuan_renstra = $this->tujuanrenstra->where('id_tujuan_renstra', $id)->first();
    $data = array(
      'title'       => 'Indikator Tujuan - Rencana Strategis',
      'tujuan_renstra'   => $tujuan_renstra,
      'inditujuan'      => $this->inditujuanrenstra->join('tb_renstra_tujuan', 'tb_renstra_tujuan.id_tujuan_renstra = tb_renstra_indi_tujuan.id_tujuan')->orderBy('no_indikator', 'ASC')->where('tb_renstra_tujuan.id_tujuan_renstra', $id)->findAll(),
    );

    return view('admin/renstra/indi_tujuan_renstra_admin', $data);
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
