<?php

namespace App\Models;

use CodeIgniter\Model;

class RpjpdModel extends Model
{
  protected $table            = 'tb_rpjpd';
  protected $primaryKey       = 'id_rpjpd';
  protected $useAutoIncrement = true;
  protected $returnType       = 'array';
  protected $useSoftDeletes   = false;
  protected $protectFields    = true;
  protected $allowedFields    = ['th_awal_rpjpd', 'th_akhir_rpjpd', 'status_periode'];

  protected bool $allowEmptyInserts = false;
  protected bool $updateOnlyChanged = true;

  protected array $casts = [];
  protected array $castHandlers = [];

  // Dates
  protected $useTimestamps = false;
  protected $dateFormat    = 'datetime';
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';
  protected $deletedField  = 'deleted_at';

  // Validation
  protected $validationRules      = [];
  protected $validationMessages   = [];
  protected $skipValidation       = false;
  protected $cleanValidationRules = true;

  // Callbacks
  protected $allowCallbacks = true;
  protected $beforeInsert   = [];
  protected $afterInsert    = [];
  protected $beforeUpdate   = [];
  protected $afterUpdate    = [];
  protected $beforeFind     = [];
  protected $afterFind      = [];
  protected $beforeDelete   = [];
  protected $afterDelete    = [];

  public function getValidation($method = null)
  {
    $rule = [
      'th_awal_rpjpd' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Tahun Awal harus diisi'
        ]
      ]
    ];

    return $rule;
  }

  public function tampilData($search = null, $start = 0, $length = 0)
  {
    if ($search) {
      $arr = explode(" ", $search);
      for ($i = 0; $i < count($arr); $i++) {
        $this->like('th_awal_rpjpd', $arr[$i])->orlike('th_akhir_rpjpd', $arr[$i]);
      }
    }

    // if ($start != 0 or $length != 0) {
    //   $this->limit($length, $start);
    // }

    return $this->orderBy('th_awal_rpjpd', 'DESC')->get()->getResult();
  }

  public function ajaxGetData($start, $length)
  {
    $result = $this->orderBy('th_awal_rpjpd', 'Desc')->findAll();
    return $result;
  }

  public function ajaxGetDataSearch($search, $start, $length)
  {
    $result = $this->like('th_awal_rpjpd', $search)
      ->orlike('th_akhir_rpjpd', $search)
      ->orderBy('id_rpjpd', 'DESC')
      ->findAll($start, $length);
    return $result;
  }
  public function ajaxGetTotal()
  {
    $result = $this->countAll();
    if (isset($result)) {
      return $result;
    }
    return 0;
  }
  public function ajaxGetTotalSearch($search)
  {
    $result = $this->like('th_awal_rpjpd', $search)
      ->orlike('th_akhir_rpjpd', $search)
      ->countAllResults();
    if (isset($result)) {
      return $result;
    }
    return 0;
  }
}
