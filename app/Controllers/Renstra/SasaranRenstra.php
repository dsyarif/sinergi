<?php

namespace App\Controllers\Renstra;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SasaranRenstra extends BaseController
{

  public function add($kode)
  {
    $rpjmd = session()->get('rpjmd');

    if (!empty($rpjmd)) {
      $sasaran = $this->sasaranrenstra->join('tb_opd', 'tb_renstra_sasaran.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_sasaran.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_sasaran.id_rpjmd' => $rpjmd, 'tb_renstra_sasaran.kode_opd' => $kode])->orderBy('kode_sasaran', 'ASC')->findAll();
    } else {
      $sasaran = $this->sasaranrenstra->join('tb_opd', 'tb_renstra_sasaran.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_sasaran.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_renstra_sasaran.kode_opd' => $kode])->orderBy('kode_sasaran', 'ASC')->findAll();
    }

    $data = array(
      'title'       => 'Sasaran - Rencana Strategis',
      'kode_opd'    => $kode,
      'rpjmd'       => $this->rpjmd->orderBy('th_awal_rpjmd', 'Desc')->findAll(),
      'tujuan'      => $this->tujuanrenstra->where('kode_opd', $kode)->orderBy('id_tujuan_renstra', 'Asc')->findAll(),
      'sasaran'     => $sasaran,
    );

    return view('admin/renstra/sasaran_renstra_admin', $data);
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
        'id_tujuan_renstra'     => $this->request->getPost('id_tujuan_renstra'),
        'kode_sasaran'     => $this->request->getPost('kode_sasaran'),
        'uraian_sasaran'   => $this->request->getPost('uraian_sasaran'),
        'kode_opd'        => $this->request->getPost('kode_opd'),
        'id_rpjmd'        => $rpjmd['id_rpjmd'],
      ];
      $this->sasaranrenstra->save($data);
      session()->setFlashdata('success', 'Data Berhasil Disimpan');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('sasaran-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function update()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $data = [
      'id_sasaran_renstra'     => $this->request->getPost('id_sasaran_renstra'),
      'id_tujuan_renstra'     => $this->request->getPost('id_tujuan_renstra'),
      'kode_sasaran'     => $this->request->getPost('kode_sasaran'),
      'uraian_sasaran'   => $this->request->getPost('uraian_sasaran'),
      'kode_opd'        => $this->request->getPost('kode_opd'),
      'id_rpjmd'        => $rpjmd['id_rpjmd'],
    ];
    $this->sasaranrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate');

    return redirect()->to('sasaran-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete($id)
  {
    $is_renstra = $this->indisasaranrenstra->where('id_sasaran_renstra', $id)->findAll();
    foreach ($is_renstra as $is) {
      $this->renstraisprog->where('id_is_renstra', $is['id_is_renstra'])->delete();
    }
    $this->indisasaranrenstra->where('id_sasaran_renstra', $id)->delete();
    $this->sasaranrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  public function add_indi()
  {
    $data = [
      'id_sasaran_renstra'     => $this->request->getPost('id_sasaran_renstra'),
      'no_indikator_is'        => $this->request->getPost('no_indikator_is'),
      'uraian_is'              => $this->request->getPost('uraian_is'),
      'kondisi_awal_is'        => $this->request->getPost('kondisi_awal_is'),
      'target_is_th1'          => $this->request->getPost('target_is_th1'),
      'target_is_th2'          => $this->request->getPost('target_is_th2'),
      'target_is_th3'          => $this->request->getPost('target_is_th3'),
      'target_is_th4'          => $this->request->getPost('target_is_th4'),
      'target_is_th5'          => $this->request->getPost('target_is_th5'),
      'target_is_th6'          => $this->request->getPost('target_is_th6'),
      'kondisi_akhir_is'       => $this->request->getPost('kondisi_akhir_is'),
      'satuan_is'              => $this->request->getPost('satuan_is'),
      'formulasi_is'           => $this->request->getPost('formulasi_is'),
      'keterangan_is'          => $this->request->getPost('keterangan_is'),
      'kode_opd'               => $this->request->getPost('kode_opd'),
    ];
    $this->indisasaranrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan');

    return redirect()->to('sasaran-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function update_indi()
  {
    $data = [
      'id_is_renstra'          => $this->request->getPost('id_is_renstra'),
      'no_indikator_is'        => $this->request->getPost('no_indikator_is'),
      'uraian_is'              => $this->request->getPost('uraian_is'),
      'kondisi_awal_is'        => $this->request->getPost('kondisi_awal_is'),
      'target_is_th1'          => $this->request->getPost('target_is_th1'),
      'target_is_th2'          => $this->request->getPost('target_is_th2'),
      'target_is_th3'          => $this->request->getPost('target_is_th3'),
      'target_is_th4'          => $this->request->getPost('target_is_th4'),
      'target_is_th5'          => $this->request->getPost('target_is_th5'),
      'target_is_th6'          => $this->request->getPost('target_is_th6'),
      'kondisi_akhir_is'       => $this->request->getPost('kondisi_akhir_is'),
      'satuan_is'              => $this->request->getPost('satuan_is'),
      'formulasi_is'           => $this->request->getPost('formulasi_is'),
      'keterangan_is'          => $this->request->getPost('keterangan_is'),
      'kode_opd'               => $this->request->getPost('kode_opd'),
    ];
    $this->indisasaranrenstra->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate');

    return redirect()->to('sasaran-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_indi($id)
  {
    $this->renstraisprog->where('id_is_renstra', $id)->delete();
    $this->indisasaranrenstra->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  public function choose_program()
  {
    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();
    $pilihan = $this->request->getPost('kode_program');

    if (!empty($rpjmd)) {
      foreach ($pilihan as $p) {
        $data = [
          'id_is_renstra'     => $this->request->getPost('id_is_renstra'),
          'kode_program'      => $p,
          'kode_opd'          => $this->request->getPost('kode_opd'),
          'id_rpjmd'          => $rpjmd['id_rpjmd'],
        ];
        $this->renstraisprog->save($data);
      }
      session()->setFlashdata('success', 'Program Berhasil Dipilih');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('sasaran-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function edit_choose_program()
  {
    $this->renstraisprog->where('id_is_renstra', $this->request->getPost('id_is_renstra'))->delete();

    $rpjmd = $this->rpjmd->where('status_rpjmd', 'Aktif')->first();

    $pilihan = $this->request->getPost('kode_program');

    if (!empty($rpjmd)) {
      foreach ($pilihan as $p) {
        $data = [
          'id_is_renstra'     => $this->request->getPost('id_is_renstra'),
          'kode_program'      => $p,
          'kode_opd'          => $this->request->getPost('kode_opd'),
          'id_rpjmd'          => $rpjmd['id_rpjmd'],
        ];
        $this->renstraisprog->save($data);
      }
      session()->setFlashdata('success', 'Program Berhasil Dipilih');
    } else {
      session()->setFlashdata('warning', 'Data Gagal Disimpan, Pastikan Ada RPJMD yang Aktif');
    }
    return redirect()->to('sasaran-renstra/add/' . $this->request->getPost('kode_opd') . '');
  }

  public function delete_is_prog($id)
  {
    $this->renstraisprog->where('id_is_renstra', $id)->delete();
    return $this->response->setJSON([
      'error' => false,
      'message' => "Program Renstra Berhasil Dihapus"
    ]);
  }
}
