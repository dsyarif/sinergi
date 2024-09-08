<?php

namespace App\Controllers\Rpjpd;

use App\Controllers\BaseController;
use CodeIgniter\CLI\Console;
use CodeIgniter\HTTP\ResponseInterface;

class PeriodeRpjpd extends BaseController
{
  public function index()
  {
    $data = array(
      'title'            => 'RPJPD',
    );

    return view('admin/rpjpd/rpjpd_admin', $data);
  }

  // public function listAjax()
  // {
  //   $param['draw'] = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
  //   $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
  //   $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
  //   $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

  //   $list = $this->rpjpd->tampilData($search, $start, $length);
  //   $jumlahData = $this->rpjpd->tampilData($search);

  //   $output = [
  //     'draw' => intval($param['draw']),
  //     'length' => $length,
  //     'recordsTotal' => count($jumlahData),
  //     'recordsFiltered' => count($jumlahData),
  //     'data' => $list
  //   ];
  //   echo json_encode($output);
  //   exit();
  // }

  public function listAjax()
  {
    $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
    $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : '';
    $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : '';
    $search = isset($_REQUEST['search']['value']) ? $_REQUEST['search']['value'] : '';

    $jumlahData = $this->rpjpd->ajaxGetTotal();

    $output = [
      'draw' => intval($draw),
      'length' => $length,
      'recordsTotal' => $jumlahData,
      'recordsFiltered' => $jumlahData,
    ];

    if ($search !== "") {
      $list = $this->rpjpd->ajaxGetDataSearch($search, $start, $length);
    } else {
      $list = $this->rpjpd->ajaxGetData($start, $length);
    }

    if ($search !== "") {
      $total_search = $this->rpjpd->ajaxGetTotalSearch($search);
      $output = [
        'recordsTotal' => $total_search,
        'recordsFiltered' => $total_search,
      ];
    }

    $data = [];
    $no = 1;
    foreach ($list as $temp) {
      $aksi = '
      <div class="d-flex justify-content-center">
      <a href="javascript:void(0)" class="text-warning mb-1 mr-3" onclick="editData(' . $temp['id_rpjpd'] . ')"><i class="fas fa-edit"></i></a>
      <a href="javascript:void(0)" class="text-danger mb-1" onclick="hapusData(' . $temp['id_rpjpd'] . ')"><i class="fas fa-trash"></i></a>
      </div>
      ';
      $row = [];
      $row[] = $no;
      $row[] = $temp['th_awal_rpjpd'];
      $row[] = $temp['th_akhir_rpjpd'];
      $row[] = $temp['status_periode'];
      $row[] = $aksi;
      $data[] = $row;
      $no++;
    }
    $output['data'] = $data;
    echo json_encode($output);
    exit();
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
      return $this->response->setJSON([
        'error' => false,
        'message' => 'Data Berhasil Disimpan!'
      ]);
    } else {
      return $this->response->setJSON([
        'error' => false,
        'message' => 'Data Gagal Disimpan, masih ada Periode RPJPD yang masih aktif'
      ]);
    }
  }

  public function update()
  {
    $data = [
      'id_rpjpd' => $this->request->getVar('id_rpjpd'),
      'th_awal_rpjpd' => $this->request->getVar('th_awal_rpjpdd'),
      'th_akhir_rpjpd' => $this->request->getVar('th_awal_rpjpdd') + 20,
      'status_periode' => $this->request->getVar('status_periode'),
    ];
    $this->rpjpd->save($data);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Diubah"
    ]);
  }

  public function delete($id)
  {
    $this->rpjpd->delete($id);
    return $this->response->setJSON([
      'error' => false,
      'message' => "Data Berhasil Dihapus"
    ]);
  }

  // public function _validate($method)
  // {
  //   if ($this->validate($this->rpjpd->getValidate($method))) {
  //     $data = [];
  //     $data['error_string'] = [];
  //     $data['inputerror'] = [];
  //     $data['status'] = TRUE;

  //     if ($this->validation->hasError('th_awal_rpjpd')) {
  //       $data['inputerror'][] = 'th_awal_rpjpd';
  //       $data['error_string'][] = $this->validation->getError('th_awal_rpjpd');
  //       $data['status'] = FALSE;
  //     }

  //     if ($data['status'] === FALSE) {
  //       echo json_encode($data);
  //       exit();
  //     }
  //   }
  // }

  function edit($id)
  {
    $data = $this->rpjpd->where('id_rpjpd', $id)->first($id);
    echo json_encode($data);
  }
}
