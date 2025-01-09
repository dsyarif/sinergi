<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ProgramRenstra extends BaseController
{
  public function add($kode)
  {
    $rpjmd = session()->get('rpjmd');

    if (!empty($rpjmd)) {
      $program = $this->master
        ->join('tb_renstra_is_prog', 'tb_master.kode_program = tb_renstra_is_prog.kode_program')
        ->join('tb_rpjmd', 'tb_renstra_is_prog.id_rpjmd = tb_rpjmd.id_rpjmd')
        ->where(['tb_renstra_is_prog.id_rpjmd' => $rpjmd, 'tb_renstra_is_prog.kode_opd' => $kode])->orderBy('kode_bidang', 'ASC')->groupBy('kode_bidang')->findAll();
    } else {
      $program = $this->master
        ->join('tb_renstra_is_prog', 'tb_master.kode_program = tb_renstra_is_prog.kode_program')
        ->join('tb_rpjmd', 'tb_renstra_is_prog.id_rpjmd = tb_rpjmd.id_rpjmd')
        ->where(['status_rpjmd' => 'Aktif', 'tb_renstra_is_prog.kode_opd' => $kode])->orderBy('kode_bidang', 'ASC')->groupBy('kode_bidang')->findAll();
    }

    $data = array(
      'title'       => 'Program - Rencana Strategis',
      'kode_opd'    => $kode,
      'rpjmd'       => $this->rpjmd->orderBy('th_awal_rpjmd', 'Desc')->findAll(),
      'program'     => $program,
    );

    return view('admin/renstra/program_renstra_admin', $data);
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
      'no_ip_renstra'          => $this->request->getPost('no_ip_renstra'),
      'uraian_ip_renstra'      => $this->request->getPost('uraian_ip_renstra'),
      'kode_bidang'            => $this->request->getPost('kode_bidang'),
      'kode_program'           => $this->request->getPost('kode_program'),
      'kondisi_awal_ip'        => $this->request->getPost('kondisi_awal_ip'),
      'target_ip_th1'          => $this->request->getPost('target_ip_th1'),
      'target_ip_th2'          => $this->request->getPost('target_ip_th2'),
      'target_ip_th3'          => $this->request->getPost('target_ip_th3'),
      'target_ip_th4'          => $this->request->getPost('target_ip_th4'),
      'target_ip_th5'          => $this->request->getPost('target_ip_th5'),
      'target_ip_th6'          => $this->request->getPost('target_ip_th6'),
      'kondisi_akhir_ip'       => $this->request->getPost('kondisi_akhir_ip'),
      'satuan_ip'              => $this->request->getPost('satuan_ip'),
      'kode_opd'               => $this->request->getPost('kode_opd'),
      'formulasi_ip'           => $this->request->getPost('formulasi_ip'),
      'keterangan_ip'          => $this->request->getPost('keterangan_ip'),
    ];
    $this->indiprogramrenstra->save($data);
    session()->setFlashdata('success', 'Indikator Program Berhasil Disimpan');

    return redirect()->to('program-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function update_indi()
  {
    $data = [
      'id_ip_renstra'          => $this->request->getPost('id_ip_renstra'),
      'no_ip_renstra'          => $this->request->getPost('no_ip_renstra'),
      'uraian_ip_renstra'      => $this->request->getPost('uraian_ip_renstra'),
      'kondisi_awal_ip'        => $this->request->getPost('kondisi_awal_ip'),
      'target_ip_th1'          => $this->request->getPost('target_ip_th1'),
      'target_ip_th2'          => $this->request->getPost('target_ip_th2'),
      'target_ip_th3'          => $this->request->getPost('target_ip_th3'),
      'target_ip_th4'          => $this->request->getPost('target_ip_th4'),
      'target_ip_th5'          => $this->request->getPost('target_ip_th5'),
      'target_ip_th6'          => $this->request->getPost('target_ip_th6'),
      'kondisi_akhir_ip'       => $this->request->getPost('kondisi_akhir_ip'),
      'satuan_ip'              => $this->request->getPost('satuan_ip'),
      'kode_opd'               => $this->request->getPost('kode_opd'),
      'formulasi_ip'           => $this->request->getPost('formulasi_ip'),
      'keterangan_ip'          => $this->request->getPost('keterangan_ip'),
    ];
    $this->indiprogramrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate');

    return redirect()->to('program-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_indi($id)
  {
    $this->renstraipkeg->where('id_ip_renstra', $id)->delete();
    $this->indiprogramrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  public function choose_kegiatan()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $pilihan = $this->request->getPost('kode_kegiatan');

    if (!empty($rpjmd)) {
      foreach ($pilihan as $p) {
        $data = [
          'id_ip_renstra'     => $this->request->getPost('id_ip_renstra'),
          'kode_kegiatan'     => $p,
          'kode_opd'          => $this->request->getPost('kode_opd'),
          'id_rpjmd'          => $rpjmd['id_rpjmd'],
        ];
        $this->renstraipkeg->save($data);
      }
      session()->setFlashdata('success', 'Kegiatan Berhasil Dipilih');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('program-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function edit_choose_kegiatan()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $pilihan = $this->request->getPost('kode_kegiatan');
    $this->renstraipkeg->where('id_ip_renstra', $this->request->getPost('id_ip_renstra'))->delete();

    if (!empty($rpjmd)) {
      foreach ($pilihan as $p) {
        $data = [
          'id_ip_renstra'     => $this->request->getPost('id_ip_renstra'),
          'kode_kegiatan'     => $p,
          'kode_opd'          => $this->request->getPost('kode_opd'),
          'id_rpjmd'          => $rpjmd['id_rpjmd'],
        ];
        $this->renstraipkeg->save($data);
      }
      session()->setFlashdata('success', 'Kegiatan Berhasil Dipilih');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('program-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_ip_keg($id)
  {
    $this->renstraipkeg->where('id_ip_renstra', $id)->delete();
    return $this->response->setJSON([
      'error' => false,
      'message' => "Program Renstra Berhasil Dihapus"
    ]);
  }
}
