<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TujuanRenstra extends BaseController
{
  public function add($kode)
  {
    $rpjmd = session()->get('rpjmd');

    if (!empty($rpjmd)) {
      $tujuan = $this->tujuanrenstra->join('tb_opd', 'tb_renstra_tujuan.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_tujuan.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_tujuan.id_rpjmd' => $rpjmd, 'tb_renstra_tujuan.kode_opd' => $kode])->orderBy('kode_tujuan', 'ASC')->findAll();
    } else {
      $tujuan = $this->tujuanrenstra->join('tb_opd', 'tb_renstra_tujuan.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_tujuan.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_renstra_tujuan.kode_opd' => $kode])->orderBy('kode_tujuan', 'ASC')->findAll();
    }

    $data = array(
      'title'       => 'Tujuan - Rencana Strategis',
      'kode_opd'    => $kode,
      'rpjmd'       => $this->rpjmd->orderBy('th_awal_rpjmd', 'Desc')->findAll(),
      'tujuan'      => $tujuan,
    );

    return view('admin/renstra/tujuan_renstra_admin', $data);
  }

  public function set_rpjmd($id)
  {
    session()->set('rpjmd', $id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Disimpan!'
    ]);
  }

  public function save()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    if (!empty($rpjmd)) {
      $data = [
        'kode_tujuan'     => $this->request->getPost('kode_tujuan'),
        'uraian_tujuan'   => $this->request->getPost('uraian_tujuan'),
        'kode_opd'        => $this->request->getPost('kode_opd'),
        'id_rpjmd'        => $rpjmd['id_rpjmd'],
      ];
      $this->tujuanrenstra->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }


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
    $this->inditujuanrenstra->where('id_tujuan', $id)->delete();
    $this->tujuanrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  public function add_indi()
  {
    $data = [
      'id_tujuan'           => $this->request->getPost('id_tujuan'),
      'no_indikator'        => $this->request->getPost('no_indikator'),
      'uraian_indikator'    => $this->request->getPost('uraian_indikator'),
      'kondisi_awal'        => $this->request->getPost('kondisi_awal'),
      'target_tujuan_th1'   => $this->request->getPost('target_tujuan_th1'),
      'target_tujuan_th2'   => $this->request->getPost('target_tujuan_th2'),
      'target_tujuan_th3'   => $this->request->getPost('target_tujuan_th3'),
      'target_tujuan_th4'   => $this->request->getPost('target_tujuan_th4'),
      'target_tujuan_th5'   => $this->request->getPost('target_tujuan_th5'),
      'target_tujuan_th6'   => $this->request->getPost('target_tujuan_th6'),
      'kondisi_akhir'       => $this->request->getPost('kondisi_akhir'),
      'satuan'              => $this->request->getPost('satuan'),
      'formulasi'           => $this->request->getPost('formulasi'),
      'keterangan'          => $this->request->getPost('keterangan'),
      'kode_opd'            => $this->request->getPost('kode_opd'),
    ];
    $this->inditujuanrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('tujuan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function update_indi()
  {
    $data = [
      'id_indi_tujuan_renstra'    => $this->request->getPost('id_indi_tujuan_renstra'),
      'no_indikator'              => $this->request->getPost('no_indikator'),
      'uraian_indikator'          => $this->request->getPost('uraian_indikator'),
      'kondisi_awal'              => $this->request->getPost('kondisi_awal'),
      'target_tujuan_th1'         => $this->request->getPost('target_tujuan_th1'),
      'target_tujuan_th2'         => $this->request->getPost('target_tujuan_th2'),
      'target_tujuan_th3'         => $this->request->getPost('target_tujuan_th3'),
      'target_tujuan_th4'         => $this->request->getPost('target_tujuan_th4'),
      'target_tujuan_th5'         => $this->request->getPost('target_tujuan_th5'),
      'target_tujuan_th6'         => $this->request->getPost('target_tujuan_th6'),
      'kondisi_akhir'             => $this->request->getPost('kondisi_akhir'),
      'satuan'                    => $this->request->getPost('satuan'),
      'formulasi'                 => $this->request->getPost('formulasi'),
      'keterangan'                => $this->request->getPost('keterangan'),
    ];
    $this->inditujuanrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate');

    return redirect()->to('tujuan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_indi($id)
  {
    $this->inditujuanrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }
}
