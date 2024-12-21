<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tahapan extends BaseController
{
  public function index()
  {
    $data = array(
      'title'       => 'Tahapan',
      'tahapan'     => $this->tahapan->orderBy('id_tahapan', 'Desc')->findAll(),
    );

    return view('admin/tahapan_view', $data);
  }

  public function save()
  {
    $data = [
      'jenis'        => $this->request->getVar('jenis'),
      'nama_tahapan' => $this->request->getVar('nama_tahapan'),
      'tgl_mulai'    => $this->request->getVar('tgl_mulai'),
      'tgl_selesai'  => $this->request->getVar('tgl_selesai'),
    ];
    $this->tahapan->save($data);
    session()->setFlashdata('success', 'Data Berhasil Disimpan!');
    return redirect()->to('tahapan');
  }

  public function update()
  {
    $data = [
      'id_tahapan'   => $this->request->getVar('id_tahapan'),
      'jenis'        => $this->request->getVar('jenis'),
      'nama_tahapan' => $this->request->getVar('nama_tahapan'),
      'tgl_mulai'    => $this->request->getVar('tgl_mulai'),
      'tgl_selesai'  => $this->request->getVar('tgl_selesai'),
      'status'       => $this->request->getVar('status'),
    ];
    $this->tahapan->save($data);
    session()->setFlashdata('success', 'Data Berhasil Diupdate!');
    return redirect()->to('tahapan');
  }

  public function delete($id)
  {
    $this->tahapan->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }
}
