<?php

namespace App\Models;

use CodeIgniter\Model;

class IndiSasaranRenstraModel extends Model
{
    protected $table            = 'tb_renstra_indi_sasaran';
    protected $primaryKey       = 'id_is_renstra';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_sasaran_renstra', 'no_indikator_is', 'uraian_is', 'iku_is_rpjmd', 'kondisi_awal_is', 'target_is_th1', 'target_is_th2', 'target_is_th3', 'target_is_th4', 'target_is_th5', 'target_is_th6', 'kondisi_akhir_is', 'satuan_is', 'formulasi_is', 'keterangan_is', 'kode_opd'];

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
