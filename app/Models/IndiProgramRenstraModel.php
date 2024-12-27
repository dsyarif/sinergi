<?php

namespace App\Models;

use CodeIgniter\Model;

class IndiProgramRenstraModel extends Model
{
    protected $table            = 'tb_renstra_indi_program';
    protected $primaryKey       = 'id_ip_renstra';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_ip_renstra', 'uraian_ip_renstra', 'kode_bidang', 'kode_program', 'kondisi_awal_ip', 'target_ip_th1', 'target_ip_th2', 'target_ip_th3', 'target_ip_th4', 'target_ip_th5', 'target_ip_th6', 'kondisi_akhir_ip', 'satuan_ip', 'formulasi_ip', 'keterangan_ip', 'kode_opd'];

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
