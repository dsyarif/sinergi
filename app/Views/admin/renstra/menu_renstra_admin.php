<?php
$uri = current_url(true);
$db         = \Config\Database::connect();
$opd        = $db->table('tb_opd')->where(['kode_opd' => $kode_opd])->get()->getRowArray();
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