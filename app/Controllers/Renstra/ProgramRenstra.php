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
        ->where(['tb_renstra_is_prog.kode_opd' => $kode])->orderBy('kode_bidang', 'ASC')->groupBy('kode_bidang')->findAll();
    } else {
      $program = $this->master
        ->join('tb_renstra_is_prog', 'tb_master.kode_program = tb_renstra_is_prog.kode_program')
        ->where(['tb_renstra_is_prog.kode_opd' => $kode])->orderBy('kode_bidang', 'ASC')->groupBy('kode_bidang')->findAll();
    }

    $data = array(
      'title'       => 'Program - Rencana Strategis',
      'kode_opd'    => $kode,
      'rpjmd'       => $this->rpjmd->orderBy('th_awal_rpjmd', 'Desc')->findAll(),
      'program'     => $program,
    );

    return view('admin/renstra/program_renstra_admin', $data);
  }
}
