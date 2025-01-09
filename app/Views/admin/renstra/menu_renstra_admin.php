<?php
$uri        = current_url(true);
$ses_rpjmd  = session()->get('rpjmd');
$db         = \Config\Database::connect();
$opd        = $db->table('tb_opd')->where(['kode_opd' => $kode_opd])->get()->getRowArray();
// if (!empty($ses_rpjmd)) {
//   $jml_tujuan        = $db->table('tb_renstra_tujuan')->join('tb_opd', 'tb_renstra_tujuan.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_tujuan.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_tujuan.id_rpjmd' => $ses_rpjmd, 'tb_opd.kode_opd' => $opd['kode_opd']])->get()->getNumRows();
//   $jml_sasaran        = $db->table('tb_renstra_sasaran')->join('tb_opd', 'tb_renstra_sasaran.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_sasaran.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_sasaran.id_rpjmd' => $ses_rpjmd, 'tb_opd.kode_opd' => $opd['kode_opd']])->get()->getNumRows();
//   $jml_program        = $db->table('tb_renstra_is_prog')->join('tb_opd', 'tb_renstra_is_prog.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_is_prog.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_is_prog.id_rpjmd' => $ses_rpjmd, 'tb_opd.kode_opd' => $opd['kode_opd']])->get()->getNumRows();
// } else {
//   $jml_tujuan        = $db->table('tb_renstra_tujuan')->join('tb_opd', 'tb_renstra_tujuan.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_tujuan.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_opd.kode_opd' => $opd['kode_opd']])->get()->getNumRows();
//   $jml_sasaran        = $db->table('tb_renstra_sasaran')->join('tb_opd', 'tb_renstra_sasaran.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_sasaran.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_opd.kode_opd' => $opd['kode_opd']])->get()->getNumRows();
//   $jml_program        = $db->table('tb_renstra_is_prog')->join('tb_opd', 'tb_renstra_is_prog.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_is_prog.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_opd.kode_opd' => $opd['kode_opd']])->get()->getNumRows();
// }

?>
<!-- menu - menu   -->
<div class="card text-center">
  <div class="card-block">
    <a href="<?= base_url() ?>tujuan-renstra/add/<?= $opd['kode_opd']; ?>" class="btn btn-out-dashed <?= ($uri->getSegment(1) == 'tujuan-renstra') ? 'btn-primary' : 'btn-secondary'; ?> btn-square mb-2">Tujuan</a>
    <a href="<?= base_url() ?>sasaran-renstra/add/<?= $opd['kode_opd']; ?>" class="btn btn-out-dashed <?= ($uri->getSegment(1) == 'sasaran-renstra') ? 'btn-primary' : 'btn-secondary'; ?> btn-square mb-2">Sasaran</a>
    <a href="<?= base_url() ?>program-renstra/add/<?= $opd['kode_opd']; ?>" class="btn btn-out-dashed <?= ($uri->getSegment(1) == 'program-renstra') ? 'btn-primary' : 'btn-secondary'; ?> btn-square mb-2">Program</a>
    <a href="<?= base_url() ?>kegiatan-renstra/add/<?= $opd['kode_opd']; ?>" class="btn btn-out-dashed <?= ($uri->getSegment(1) == 'kegiatan-renstra') ? 'btn-primary' : 'btn-secondary'; ?> btn-square mb-2">Kegiatan</a>
    <a href="<?= base_url() ?>sub-kegiatan-renstra/add/<?= $opd['kode_opd']; ?>" class="btn btn-out-dashed <?= ($uri->getSegment(1) == 'sub-kegiatan-renstra') ? 'btn-primary' : 'btn-secondary'; ?> btn-square mb-2">Sub Kegiatan</a>
  </div>
</div>