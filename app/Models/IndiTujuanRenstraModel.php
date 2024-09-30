<?php

namespace App\Models;

use CodeIgniter\Model;

class IndiTujuanRenstraModel extends Model
{
    protected $table            = 'tb_indi_tujuan_renstra';
    protected $primaryKey       = 'id_indi_tujuan_renstra';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_tujuan', 'no_indikator', 'uraian_indikator', 'iku_kota_rpjmd', 'kondisi_awal', 'target_tujuan_th1', 'target_tujuan_th2', 'target_tujuan_th3', 'target_tujuan_th4', 'target_tujuan_th5', 'target_tujuan_th6', 'kondisi_akhir', 'satuan', 'formulasi', 'keterangan', 'kode_opd'];

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
}
