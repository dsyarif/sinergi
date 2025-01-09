<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class KegiatanRenstra extends BaseController
{
  public function add($kode)
  {
    $rpjmd = session()->get('rpjmd');

    if (!empty($rpjmd)) {
      $kegiatan = $this->master
        ->join('tb_renstra_ip_keg', 'tb_master.kode_kegiatan = tb_renstra_ip_keg.kode_kegiatan')
        ->join('tb_rpjmd', 'tb_renstra_ip_keg.id_rpjmd = tb_rpjmd.id_rpjmd')
        ->where(['tb_renstra_ip_keg.id_rpjmd' => $rpjmd, 'tb_renstra_ip_keg.kode_opd' => $kode])->orderBy('kode_program', 'ASC')->groupBy('kode_program')->findAll();
    } else {
      $kegiatan = $this->master
        ->join('tb_renstra_ip_keg', 'tb_master.kode_kegiatan = tb_renstra_ip_keg.kode_kegiatan')
        ->join('tb_rpjmd', 'tb_renstra_ip_keg.id_rpjmd = tb_rpjmd.id_rpjmd')
        ->where(['status_rpjmd' => 'Aktif', 'tb_renstra_ip_keg.kode_opd' => $kode])->orderBy('kode_program', 'ASC')->groupBy('kode_program')->findAll();
    }

    $data = array(
      'title'       => 'Kegiatan - Rencana Strategis',
      'kode_opd'    => $kode,
      'rpjmd'       => $this->rpjmd->orderBy('th_awal_rpjmd', 'Desc')->findAll(),
      'kegiatan'     => $kegiatan,
    );

    return view('admin/renstra/kegiatan_renstra_admin', $data);
  }

  public function set_rpjmd($id)
  {
    session()->set('rpjmd', $id);
    return $this->response->setJSON([
      'error' => false,
      'message' => 'Data Berhasil Disimpan!'
    ]);
  }


  public function add_indi()
  {
    $data = [
      'no_ik_renstra'          => $this->request->getPost('no_ik_renstra'),
      'uraian_ik_renstra'      => $this->request->getPost('uraian_ik_renstra'),
      'kode_kegiatan'           => $this->request->getPost('kode_kegiatan'),
      'kondisi_awal_ik'        => $this->request->getPost('kondisi_awal_ik'),
      'target_ik_th1'          => $this->request->getPost('target_ik_th1'),
      'target_ik_th2'          => $this->request->getPost('target_ik_th2'),
      'target_ik_th3'          => $this->request->getPost('target_ik_th3'),
      'target_ik_th4'          => $this->request->getPost('target_ik_th4'),
      'target_ik_th5'          => $this->request->getPost('target_ik_th5'),
      'target_ik_th6'          => $this->request->getPost('target_ik_th6'),
      'kondisi_akhir_ik'       => $this->request->getPost('kondisi_akhir_ik'),
      'satuan_ik'              => $this->request->getPost('satuan_ik'),
      'kode_opd'               => $this->request->getPost('kode_opd'),
      'formulasi_ik'           => $this->request->getPost('formulasi_ik'),
      'keterangan_ik'          => $this->request->getPost('keterangan_ik'),
    ];
    $this->indikegiatanrenstra->save($data);
    session()->setFlashdata('success', 'Indikator Kegiatan Berhasil Disimpan');

    return redirect()->to('kegiatan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }


  public function update_indi()
  {
    $data = [
      'id_ik_renstra'          => $this->request->getPost('id_ik_renstra'),
      'no_ik_renstra'          => $this->request->getPost('no_ik_renstra'),
      'uraian_ik_renstra'      => $this->request->getPost('uraian_ik_renstra'),
      'kondisi_awal_ik'        => $this->request->getPost('kondisi_awal_ik'),
      'target_ik_th1'          => $this->request->getPost('target_ik_th1'),
      'target_ik_th2'          => $this->request->getPost('target_ik_th2'),
      'target_ik_th3'          => $this->request->getPost('target_ik_th3'),
      'target_ik_th4'          => $this->request->getPost('target_ik_th4'),
      'target_ik_th5'          => $this->request->getPost('target_ik_th5'),
      'target_ik_th6'          => $this->request->getPost('target_ik_th6'),
      'kondisi_akhir_ik'       => $this->request->getPost('kondisi_akhir_ik'),
      'satuan_ik'              => $this->request->getPost('satuan_ik'),
      'kode_opd'               => $this->request->getPost('kode_opd'),
      'formulasi_ik'           => $this->request->getPost('formulasi_ik'),
      'keterangan_ik'          => $this->request->getPost('keterangan_ik'),
    ];
    $this->indikegiatanrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate');

    return redirect()->to('kegiatan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_indi($id)
  {
    $this->renstraiksubkeg->where('id_ik_renstra', $id)->delete();
    $this->indikegiatanrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  public function choose_subkegiatan()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $pilihan = $this->request->getPost('kode_subkegiatan');

    if (!empty($rpjmd)) {
      foreach ($pilihan as $p) {
        $data = [
          'id_ik_renstra'     => $this->request->getPost('id_ik_renstra'),
          'kode_subkegiatan'  => $p,
          'kode_opd'          => $this->request->getPost('kode_opd'),
          'id_rpjmd'          => $rpjmd['id_rpjmd'],
        ];
        $this->renstraiksubkeg->save($data);
      }
      session()->setFlashdata('success', 'Sub Kegiatan Berhasil Dipilih');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('kegiatan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function edit_choose_subkegiatan()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $pilihan = $this->request->getPost('kode_subkegiatan');
    $this->renstraiksubkeg->where('id_ik_renstra', $this->request->getPost('id_ik_renstra'))->delete();

    if (!empty($rpjmd)) {
      foreach ($pilihan as $p) {
        $data = [
          'id_ik_renstra'     => $this->request->getPost('id_ik_renstra'),
          'kode_subkegiatan'  => $p,
          'kode_opd'          => $this->request->getPost('kode_opd'),
          'id_rpjmd'          => $rpjmd['id_rpjmd'],
        ];
        $this->renstraiksubkeg->save($data);
      }
      session()->setFlashdata('success', 'Sub Kegiatan Berhasil Dipilih');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('kegiatan-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_ik_subkeg($id)
  {
    $this->renstraiksubkeg->where('id_ik_renstra', $id)->delete();
    return $this->response->setJSON([
      'error' => false,
      'message' => "Sub Kegiatan Renstra Berhasil Dihapus"
    ]);
  }
}
