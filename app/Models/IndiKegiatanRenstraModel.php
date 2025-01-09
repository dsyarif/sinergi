<?php

namespace App\Models;

use CodeIgniter\Model;

class IndiKegiatanRenstraModel extends Model
{
    protected $table            = 'tb_renstra_indi_kegiatan';
    protected $primaryKey       = 'id_ik_renstra';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_ik_renstra', 'uraian_ik_renstra', 'kode_kegiatan', 'kondisi_awal_ik', 'target_ik_th1', 'target_ik_th2', 'target_ik_th3', 'target_ik_th4', 'target_ik_th5', 'target_ik_th6', 'kondisi_akhir_ik', 'satuan_ik', 'formulasi_ik', 'keterangan_ik', 'kode_opd'];

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
