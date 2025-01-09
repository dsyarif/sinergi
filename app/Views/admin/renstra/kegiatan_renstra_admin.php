<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<?php
$db         = \Config\Database::connect();
$ses_rpjmd  = session()->get('rpjmd');
if (!empty($ses_rpjmd)) {
  $d_rpjmd    = $db->table('tb_rpjmd')->where('id_rpjmd', $ses_rpjmd)->get()->getRowArray();
} else {
  $d_rpjmd    = $db->table('tb_rpjmd')->where('status_rpjmd', 'Aktif')->get()->getRowArray();
}
$opd        = $db->table('tb_opd')->where(['kode_opd' => $kode_opd])->get()->getRowArray();
?>
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
      <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
          <?= $this->include('admin/renstra/menu_renstra_admin') ?>
          <div class="row align-items-end">
            <div class="col-xl-10">
              <div class="page-header-title">
                <div class="d-inline">

                  <h4>Kegiatan - Renstra (<?= $opd['singkatan']; ?>)</h4>
                </div>
              </div>
            </div>

            <div class="col-xl-2 float-right">
              <select id="pilihan" onchange="setrpjmd()" class="form-control form-control-inverse text-center">
                <option label="== Pilih RPJMD =="></option>
                <?php foreach ($rpjmd as $r): ?>
                  <option value="<?= $r['id_rpjmd']; ?>" <?= ($ses_rpjmd == $r['id_rpjmd']) ? 'selected' : ''; ?>><?= $r['th_awal_rpjmd']; ?> - <?= $r['th_akhir_rpjmd']; ?></option>
                <?php endforeach ?>
              </select>
            </div>

          </div>
        </div>
        <!-- Page-header end -->

        <!-- Page-body start -->
        <div class="page-body">
          <div class="row">
            <div class="col-sm-12">
              <!-- Zero config.table start -->
              <div class="card">
                <div class="card-header">
                  <h5> <a href="<?= base_url() ?>renstra"><i class="fa-solid fa-arrow-left"></i></a> Data Kegiatan Renstra <?= $opd['singkatan']; ?></h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <!-- <table id="datatable1" class="table table-bordered table-hover"> -->
                    <table class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center; background-color: #354055; color: white;" class="dt-center">
                          <th class="text-center" style="width: 1%; vertical-align: middle;">Kode Kegiatan</th>
                          <th class="text-center" style="width: 5%; vertical-align: middle;">Nama Kegiatan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($kegiatan as $k):
                          $indi_prog    = $db->table('tb_renstra_indi_program')->where(['kode_opd' => $kode_opd, 'kode_program' => $k['kode_program']])->orderBy('no_ip_renstra', 'ASC')->get()->getResultArray();
                        ?>
                          <tr style="background-color: #01A9AC; color: white;">
                            <td class="text-left"><?= $k['kode_program']; ?></td>
                            <td><?= $k['nama_program']; ?></td>
                          </tr>
                          <?php foreach ($indi_prog as $indi):
                            $ip_keg    = $db->table('tb_renstra_ip_keg')->where(['kode_opd' => $kode_opd, 'id_ip_renstra' => $indi['id_ip_renstra']])->orderBy('kode_kegiatan', 'ASC')->get()->getResultArray();
                          ?>
                            <tr>
                              <td class="text-left"></td>
                              <td>Indikator Program : <?= $indi['no_ip_renstra']; ?>. <?= $indi['uraian_ip_renstra']; ?></td>
                            </tr>
                            <?php foreach ($ip_keg as $ip):
                            ?>
                              <?php if ($k['kode_program'] == substr($ip['kode_kegiatan'], 0, -5)):
                                $nm_kegiatan = $db->table('tb_master')->where('kode_kegiatan', $ip['kode_kegiatan'])->get()->getRowArray();
                              ?>
                                <tr>
                                  <td class="text-center"><?= $ip['kode_kegiatan']; ?></td>
                                  <td class="text-primary" onclick="tambahIndiProg(`<?= $ip['kode_kegiatan']; ?>`, `<?= $kode_opd; ?>`, `<?= $nm_kegiatan['nama_kegiatan']; ?>`, `<?= $k['kode_program']; ?>`)"><?= $nm_kegiatan['nama_kegiatan']; ?></td>
                                </tr>
                              <?php endif ?>

                              <?php
                              $indi_keg = $db->table('tb_renstra_indi_kegiatan')->where(['kode_kegiatan' => $ip['kode_kegiatan'], 'kode_opd' => $kode_opd])->orderBy('no_ik_renstra', 'ASC')->get()->getResultArray();
                              ?>
                              <?php if (!empty($indi_keg)): ?>
                                <?php foreach ($indi_keg as $ik):
                                  $jml_subkegiatan = $db->table('tb_renstra_ik_subkeg')->where('id_ik_renstra', $ik['id_ik_renstra'])->get()->getNumRows();

                                ?>
                                  <tr>
                                    <td class="text-right"><?= $ik['no_ik_renstra']; ?>.</td>
                                    <td>
                                      <?= $ik['uraian_ik_renstra']; ?> [<?= $jml_subkegiatan; ?> Sub Kegiatan]
                                      <!-- edit kegiatan -->
                                      <a class="text-warning mb-1 ml-2 mr-2" data-bs-toggle="modal" data-bs-target="#edit_ik_<?= $ik['id_ik_renstra']; ?>"><i data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Indikator Kegiatan Renstra" class="fas fa-edit"></i></a>
                                      <!-- hapus kegiatan & indi kegiatan -->
                                      <a class="text-danger mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Indikator Kegiatan Renstra" onclick="hapusDataIndi(`<?= $ik['id_ik_renstra']; ?>`,`<?= $ik['uraian_ik_renstra']; ?>`)"><i class="fas fa-trash"></i></a>
                                    </td>
                                  </tr>

                                  <!-- Modal Edit indi Kegiatan -->
                                  <div class="modal fade" id="edit_ik_<?= $ik['id_ik_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Edit Indikator Kegiatan Renstra</h5>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <?= form_open('kegiatan-renstra/update-indi'); ?>
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="id_ik_renstra" value="<?= $ik['id_ik_renstra']; ?>">
                                        <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">
                                        <div class="modal-body">
                                          <div class="card">
                                            <div class="card-body">
                                              <!-- tombol pilih kegiatan indikator sasaran pada baris ke 1 -->
                                              <a class="btn btn-primary btn-block btn-mat mb-2 text-white" data-bs-toggle="modal" data-bs-target="#pilihsubkegiatan_<?= $ik['id_ik_renstra']; ?>"><i class="fa-solid fa-list-check"></i> Choose Sub Kegiatan</a>
                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Nama Kegiatan</label>
                                                <p><?= $nm_kegiatan['nama_kegiatan']; ?></p>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">No. Indikator</label>
                                                <input type="number" name="no_ik_renstra" class="form-control" value="<?= $ik['no_ik_renstra']; ?>" required placeholder="Input No. Indikator">
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Uraian Indikator Kegiatan</label>
                                                <textarea name="uraian_ik_renstra" class="form-control" rows="2" required placeholder="Input Uraian Kegiatan"><?= $ik['uraian_ik_renstra']; ?></textarea>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                              </div>
                                              <div class="form-group row">
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?></label>
                                                  <input type="number" value="<?= $ik['kondisi_awal_ik']; ?>" name="kondisi_awal_ik" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd']; ?></label>
                                                  <input type="number" value="<?= $ik['target_ik_th1']; ?>" name="target_ik_th1" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd']; ?>">
                                                </div>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold text-center">Target</label>
                                              </div>
                                              <div class="form-group row">
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?></label>
                                                  <input type="number" value="<?= $ik['target_ik_th2']; ?>" name="target_ik_th2" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?></label>
                                                  <input type="number" value="<?= $ik['target_ik_th3']; ?>" name="target_ik_th3" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?>">
                                                </div>
                                              </div>


                                              <div class="form-group row">
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?></label>
                                                  <input type="number" value="<?= $ik['target_ik_th4']; ?>" name="target_ik_th4" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?></label>
                                                  <input type="number" value="<?= $ik['target_ik_th5']; ?>" name="target_ik_th5" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?>">
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?></label>
                                                  <input type="number" value="<?= $ik['target_ik_th6']; ?>" name="target_ik_th6" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?>">
                                                </div>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                                <input type="number" value="<?= $ik['kondisi_akhir_ik']; ?>" name="kondisi_akhir_ik" class="form-control" required placeholder="Input Kondisi Akhir">
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Satuan</label>
                                                <input type="text" value="<?= $ik['satuan_ik']; ?>" name="satuan_ik" class="form-control" required placeholder="Input Satuan">
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Formulasi</label>
                                                <textarea name="formulasi_ik" rows="3" class="form-control" required placeholder="Input Formulasi"><?= $ik['formulasi_ik']; ?></textarea>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Keterangan</label>
                                                <textarea name="keterangan_ik" rows="3" class="form-control" required placeholder="Input Keterangan"><?= $ik['keterangan_ik']; ?></textarea>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div>
                                                <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                              </div>
                                            </div>
                                          </div>
                                          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
                                        </div>
                                      </div>
                                      <?= form_close(); ?>

                                    </div>
                                  </div>

                                  <!-- Modal Pilih Kegiatan Indikator Kegiatan -->
                                  <div class="modal fade" id="pilihsubkegiatan_<?= $ik['id_ik_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Indikator : <?= $ik['uraian_ik_renstra']; ?></h5>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <?php
                                        // menampilkan seluruh kegiatan pada opd yang dipilih
                                        $subkegiatan        = $db->table('tb_master')
                                          ->join('tb_renstra_bidang_opd', 'tb_master.kode_bidang=tb_renstra_bidang_opd.kode_bidang')
                                          ->join('tb_opd', 'tb_renstra_bidang_opd.kode_opd=tb_opd.kode_opd')
                                          ->where(['tb_opd.kode_opd' => $opd['kode_opd'], 'tb_master.kode_kegiatan' => $ik['kode_kegiatan']])
                                          ->groupBy('kode_subkegiatan')->get()->getResultArray();
                                        //mngecek jumlah kegiatan sudah dipilih
                                        $cek_subkeg    = $db->table('tb_renstra_ik_subkeg')->where('id_ik_renstra', $ik['id_ik_renstra'])->get()->getNumRows();
                                        // menampilkan kegiatan yang sudah dipilih guna edit data
                                        $data_ik_subkeg   = $db->table('tb_renstra_ik_subkeg')->where('id_ik_renstra', $ik['id_ik_renstra'])->get()->getResultArray();

                                        $data_ik_subkeg_array = [];
                                        foreach ($data_ik_subkeg as $kt) {
                                          $data_ik_subkeg_array[$kt['kode_subkegiatan']] = true;
                                        }

                                        $cek_is_prog = $db->table('tb_renstra_ik_subkeg')->where(['id_ik_renstra !=' => $ik['id_ik_renstra'], 'kode_opd' => $opd['kode_opd']])->get()->getResultArray();
                                        $data_cek_is_prog_array = [];
                                        foreach ($cek_is_prog as $c) {
                                          $data_cek_is_prog_array[$c['kode_subkegiatan']] = true;
                                        }
                                        ?>

                                        <?php if ($cek_subkeg == 0): ?>
                                          <?= form_open('kegiatan-renstra/choose-subkegiatan'); ?>
                                          <?= csrf_field() ?>
                                          <div class="modal-body">
                                            <div class="card">
                                              <div class="card-body">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <input type="hidden" name="id_ik_renstra" value="<?= $ik['id_ik_renstra']; ?>">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <div class="mb-3">
                                                  <label class="form-label font-weight-bold">Kegiatan</label>
                                                  <select class="js-example-basic-multiple col-sm-12 z-index-10" name="kode_subkegiatan[]" multiple="multiple" required>

                                                    <?php foreach ($subkegiatan as $p): ?>
                                                      <option value="<?= $p['kode_subkegiatan']; ?>" <?= isset($data_cek_is_prog_array[$p['kode_subkegiatan']]) ? 'disabled' : '' ?>><?= $p['kode_subkegiatan']; ?> - <?= $p['nama_subkegiatan']; ?></option>
                                                    <?php endforeach ?>
                                                  </select>
                                                  <span class="help-block text-danger"></span>
                                                </div>
                                                <div>
                                                  <button type="submit" class="btn btn-inverse btn-block">Simpan Kegiatan</button>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <?= form_close(); ?>
                                        <?php else: ?>
                                          <?= form_open('kegiatan-renstra/edit-choose-subkegiatan'); ?>
                                          <?= csrf_field() ?>
                                          <div class="modal-body">
                                            <div class="card">
                                              <div class="card-body">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <input type="hidden" name="id_ik_renstra" value="<?= $ik['id_ik_renstra']; ?>">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <div class="mb-3">
                                                  <label class="form-label font-weight-bold">Kegiatan</label>
                                                  <select class="js-example-basic-multiple col-sm-12" name="kode_subkegiatan[]" multiple="multiple" required>
                                                    <?php foreach ($subkegiatan as $p): ?>
                                                      <option value="<?= $p['kode_subkegiatan']; ?>" <?= isset($data_cek_is_prog_array[$p['kode_subkegiatan']]) ? 'disabled' : '' ?> <?= isset($data_ik_subkeg_array[$p['kode_subkegiatan']]) ? 'selected' : '' ?>><?= $p['kode_subkegiatan']; ?> - <?= $p['nama_kegiatan']; ?></option>
                                                    <?php endforeach ?>
                                                  </select>
                                                  <span class="help-block text-danger"></span>
                                                </div>
                                                <div>
                                                  <button type="submit" class="btn btn-inverse btn-block">Edit Kegiatan</button>
                                                  <a onclick="hapusIkSubKeg(`<?= $ik['id_ik_renstra']; ?>`, `<?= $opd['kode_opd']; ?>`, `<?= $ik['uraian_ik_renstra']; ?>`)" class="btn btn-danger btn-block text-white">Hapus Semua Kegiatan Terpilih</a>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          <?= form_close(); ?>
                                        <?php endif ?>


                                      </div>
                                    </div>
                                  </div>
                                <?php endforeach ?>
                              <?php endif ?>

                            <?php endforeach ?>
                          <?php endforeach ?>
                        <?php endforeach ?>


                        <!-- Modal tambah indi Kegiatan -->
                        <div class="modal fade" id="tambah_indi_prog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Indikator Kegiatan Renstra</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <?= form_open('kegiatan-renstra/add-indi'); ?>
                              <?= csrf_field() ?>
                              <input type="hidden" name="kode_program" id="kode_program_js">
                              <input type="hidden" name="kode_kegiatan" id="kode_kegiatan_js">
                              <input type="hidden" name="kode_opd" id="kode_opd_js">
                              <div class="modal-body">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Nama Kegiatan</label>
                                      <p id="nama_kegiatan_js"></p>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">No. Indikator</label>
                                      <input type="number" name="no_ik_renstra" class="form-control" required placeholder="Input No. Indikator">
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Uraian Indikator Kegiatan</label>
                                      <textarea name="uraian_ik_renstra" class="form-control" rows="2" required placeholder="Input Uraian Kegiatan"></textarea>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?></label>
                                        <input type="number" name="kondisi_awal_ik" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?>">
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd']; ?></label>
                                        <input type="number" name="target_ik_th1" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd']; ?>">
                                      </div>
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold text-center">Target</label>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?></label>
                                        <input type="number" name="target_ik_th2" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?>">
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?></label>
                                        <input type="number" name="target_ik_th3" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?>">
                                      </div>
                                    </div>


                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?></label>
                                        <input type="number" name="target_ik_th4" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?>">
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?></label>
                                        <input type="number" name="target_ik_th5" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?>">
                                      </div>
                                      <div class="col-sm-6 mt-3">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?></label>
                                        <input type="number" name="target_ik_th6" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?>">
                                      </div>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                      <input type="number" name="kondisi_akhir_ik" class="form-control" required placeholder="Input Kondisi Akhir">
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Satuan</label>
                                      <input type="text" name="satuan_ik" class="form-control" required placeholder="Input Satuan">
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Formulasi</label>
                                      <textarea name="formulasi_ik" rows="3" class="form-control" required placeholder="Input Formulasi"></textarea>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Keterangan</label>
                                      <textarea name="keterangan_ik" rows="3" class="form-control" required placeholder="Input Keterangan"></textarea>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div>
                                      <button type="submit" class="btn btn-inverse btn-block">Simpan</button>
                                    </div>
                                  </div>
                                </div>
                                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
                              </div>
                            </div>
                            <!-- <div class="modal-footer d-flex justify-content-center"> -->
                            <?= form_close(); ?>
                          </div>
                        </div>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Page-body end -->
      </div>
    </div>
    <!-- Main-body end -->
  </div>
</div>


<script>
  $(document).ready(function() {
    $('#datatable').DataTable({
      scrollY: 400,
      deferRender: true,
      scroller: true,
      layout: {
        topStart: {
          buttons: [{
              extend: 'pdf',
              className: 'btn-inverse'
            },
            {
              extend: 'print',
              className: 'btn-inverse'
            },
            {
              extend: 'excel',
              className: 'btn-inverse'
            },
            {
              extend: 'colvis',
              className: 'btn-inverse'
            }
          ]
        }
      }
    });
  });

  function hapusDataIndi(id, uraian) {
    Swal.fire({
      title: "Hapus Data?",
      html: "<strong>Indikator Kegiatan</strong> </br><h6>(" + uraian + ")</h6>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('kegiatan-renstra/delete-indi/') ?>' + id,
          type: 'DELETE',
          dataType: 'JSON',
          success: function(response) {
            Swal.fire({
              title: "Data Terhapus!",
              text: "Selamat Data Berhasil Dihapus",
              confirmButtonColor: "#404E67",
              iconColor: '#404E67',
              icon: "success"
            }).then(function() {
              location.reload();
            });
          },
          error: function(jqXHR, textStatus, errorThrow) {
            alert('Gagal Hapus Data, Silahkan Coba Lagi');
          }
        });

      }
    });
  }

  function hapusIkSubKeg(id, kode_opd, uraian_ip) {
    $('#pilihkegiatan_' + id).modal('hide');
    Swal.fire({
      title: "Hapus Semua Kegiatan?",
      html: "Indikator Kegiatan </br><strong>" + uraian_ip + "</strong>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('kegiatan-renstra/delete-ik-subkeg/') ?>' + id + "/" + kode_opd,
          type: 'DELETE',
          dataType: 'JSON',
          success: function(response) {
            Swal.fire({
              title: "Data Terhapus!",
              text: "Selamat Data Berhasil Dihapus",
              confirmButtonColor: "#404E67",
              iconColor: '#404E67',
              icon: "success"
            }).then(function() {
              location.reload();
            });
          },
          error: function(jqXHR, textStatus, errorThrow) {
            alert('Gagal Hapus Data, Silahkan Coba Lagi');
          }
        });

      }
    });
  }

  // Fungsi memunculkan modal tambah indikator kegiatan
  function tambahIndiProg(kode_prog, kode_opd, nama_prog, kode_program) {
    $('#tambah_indi_prog').modal('show');
    $('#kode_kegiatan_js').val(kode_prog);
    $('#kode_opd_js').val(kode_opd);
    $('#nama_kegiatan_js').html(nama_prog);
    $('#kode_program_js').val(kode_program);
  }
</script>
<script>
  function setrpjmd() {
    var id = $('#pilihan').val();
    $.ajax({
      url: '<?= site_url('kegiatan-renstra/set-rpjmd/') ?>' + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        location.reload();
      }
    });
  }
</script>
<?= $this->endSection(); ?>