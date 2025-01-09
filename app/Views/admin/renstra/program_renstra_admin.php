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

                  <h4>Program - Renstra (<?= $opd['singkatan']; ?>)</h4>
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
                  <h5> <a href="<?= base_url() ?>renstra"><i class="fa-solid fa-arrow-left"></i></a> Data Program Renstra <?= $opd['singkatan']; ?></h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <!-- <table id="datatable1" class="table table-bordered table-hover"> -->
                    <table class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center; background-color: #354055; color: white;" class="dt-center">
                          <th class="text-center" style="width: 1%; vertical-align: middle;">Kode Bidang/Program</th>
                          <th class="text-center" style="width: 5%; vertical-align: middle;">Nama Bidang / Program / Indikator Program</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($program as $p):
                          $is_prog    = $db->table('tb_renstra_is_prog')->join('tb_rpjmd', 'tb_renstra_is_prog.id_rpjmd=tb_rpjmd.id_rpjmd')->where(['kode_opd' => $kode_opd])->orderBy('kode_program', 'ASC')->get()->getResultArray();
                        ?>
                          <tr style="background-color: #01A9AC; color: white;">
                            <td class="text-left"><?= $p['kode_bidang']; ?></td>
                            <td><?= $p['nama_bidang']; ?></td>
                          </tr>
                          <?php foreach ($is_prog as $i): ?>
                            <?php if ($p['kode_bidang'] == substr($i['kode_program'], 0, -3)):
                              $nm_program = $db->table('tb_master')->where('kode_program', $i['kode_program'])->get()->getRowArray();
                            ?>
                              <tr>
                                <td class="text-center"><?= $i['kode_program']; ?></td>
                                <td class="text-primary" onclick="tambahIndiProg(`<?= $i['kode_program']; ?>`, `<?= $kode_opd; ?>`, `<?= $nm_program['nama_program']; ?>`, `<?= $p['kode_bidang']; ?>`)"><?= $nm_program['nama_program']; ?></td>
                              </tr>
                              <?php
                              $ip_prog = $db->table('tb_renstra_indi_program')->where(['kode_program' => $i['kode_program'], 'kode_opd' => $kode_opd])->orderBy('no_ip_renstra', 'ASC')->get()->getResultArray();
                              ?>
                              <?php if (!empty($ip_prog)): ?>
                                <?php foreach ($ip_prog as $ip):
                                  $jml_kegiatan = $db->table('tb_renstra_ip_keg')->where('id_ip_renstra', $ip['id_ip_renstra'])->get()->getNumRows();
                                ?>
                                  <tr>
                                    <td class="text-right"><?= $ip['no_ip_renstra']; ?>.</td>
                                    <td>
                                      <?= $ip['uraian_ip_renstra']; ?> [<?= $jml_kegiatan; ?> Kegiatan]
                                      <!-- edit sasaran -->
                                      <a class="text-warning mb-1 ml-2 mr-2" data-bs-toggle="modal" data-bs-target="#edit_ip_<?= $ip['id_ip_renstra']; ?>"><i data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Indikator Program Renstra" class="fas fa-edit"></i></a>
                                      <!-- hapus sasaran & indi sasaran -->
                                      <a class="text-danger mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Indikator Program Renstra" onclick="hapusDataIndi(`<?= $ip['id_ip_renstra']; ?>`,`<?= $ip['uraian_ip_renstra']; ?>`)"><i class="fas fa-trash"></i></a>
                                    </td>
                                  </tr>

                                  <!-- Modal Edit indi Program -->
                                  <div class="modal fade" id="edit_ip_<?= $ip['id_ip_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Edit Indikator Program Renstra</h5>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <?= form_open('program-renstra/update-indi'); ?>
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="id_ip_renstra" value="<?= $ip['id_ip_renstra']; ?>">
                                        <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">
                                        <div class="modal-body">
                                          <div class="card">
                                            <div class="card-body">
                                              <!-- tombol pilih program indikator sasaran pada baris ke 1 -->
                                              <a class="btn btn-primary btn-block btn-mat mb-2 text-white" data-bs-toggle="modal" data-bs-target="#pilihkegiatan_<?= $ip['id_ip_renstra']; ?>"><i class="fa-solid fa-list-check"></i> Choose Kegiatan</a>
                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Nama Program</label>
                                                <p><?= $nm_program['nama_program']; ?></p>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">No. Indikator</label>
                                                <input type="number" name="no_ip_renstra" class="form-control" value="<?= $ip['no_ip_renstra']; ?>" required placeholder="Input No. Indikator">
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Uraian Indikator Program</label>
                                                <textarea name="uraian_ip_renstra" class="form-control" rows="2" required placeholder="Input Uraian Program"><?= $ip['uraian_ip_renstra']; ?></textarea>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                              </div>
                                              <div class="form-group row">
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?></label>
                                                  <input type="number" value="<?= $ip['kondisi_awal_ip']; ?>" name="kondisi_awal_ip" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd']; ?></label>
                                                  <input type="number" value="<?= $ip['target_ip_th1']; ?>" name="target_ip_th1" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd']; ?>">
                                                </div>
                                              </div>
                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold text-center">Target</label>
                                              </div>
                                              <div class="form-group row">
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?></label>
                                                  <input type="number" value="<?= $ip['target_ip_th2']; ?>" name="target_ip_th2" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?></label>
                                                  <input type="number" value="<?= $ip['target_ip_th3']; ?>" name="target_ip_th3" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?>">
                                                </div>
                                              </div>


                                              <div class="form-group row">
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?></label>
                                                  <input type="number" value="<?= $ip['target_ip_th4']; ?>" name="target_ip_th4" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?>">
                                                </div>
                                                <div class="col-sm-6">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?></label>
                                                  <input type="number" value="<?= $ip['target_ip_th5']; ?>" name="target_ip_th5" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?>">
                                                </div>
                                                <div class="col-sm-6 mt-3">
                                                  <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?></label>
                                                  <input type="number" value="<?= $ip['target_ip_th6']; ?>" name="target_ip_th6" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?>">
                                                </div>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                                <input type="number" value="<?= $ip['kondisi_akhir_ip']; ?>" name="kondisi_akhir_ip" class="form-control" required placeholder="Input Kondisi Akhir">
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Satuan</label>
                                                <input type="text" value="<?= $ip['satuan_ip']; ?>" name="satuan_ip" class="form-control" required placeholder="Input Satuan">
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Formulasi</label>
                                                <textarea name="formulasi_ip" rows="3" class="form-control" required placeholder="Input Formulasi"><?= $ip['formulasi_ip']; ?></textarea>
                                                <span class="help-block text-danger"></span>
                                              </div>

                                              <div class="mb-3">
                                                <label class="form-label font-weight-bold">Keterangan</label>
                                                <textarea name="keterangan_ip" rows="3" class="form-control" required placeholder="Input Keterangan"><?= $ip['keterangan_ip']; ?></textarea>
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
                                  <div class="modal fade" id="pilihkegiatan_<?= $ip['id_ip_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Indikator : <?= $ip['uraian_ip_renstra']; ?></h5>
                                          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <?php
                                        // menampilkan seluruh kegiatan pada opd yang dipilih
                                        $kegiatan        = $db->table('tb_master')->join('tb_renstra_bidang_opd', 'tb_master.kode_bidang=tb_renstra_bidang_opd.kode_bidang')->join('tb_opd', 'tb_renstra_bidang_opd.kode_opd=tb_opd.kode_opd')->where(['tb_opd.kode_opd' => $opd['kode_opd'], 'tb_master.kode_program' => $ip['kode_program']])->groupBy('kode_kegiatan')->get()->getResultArray();
                                        //mngecek jumlah kegiatan sudah dipilih
                                        $cek_kegiatan    = $db->table('tb_renstra_ip_keg')->where('id_ip_renstra', $ip['id_ip_renstra'])->get()->getNumRows();
                                        // menampilkan kegiatan yang sudah dipilih guna edit data
                                        $data_ip_keg   = $db->table('tb_renstra_ip_keg')->where('id_ip_renstra', $ip['id_ip_renstra'])->get()->getResultArray();

                                        $data_ip_keg_array = [];
                                        foreach ($data_ip_keg as $kt) {
                                          $data_ip_keg_array[$kt['kode_kegiatan']] = true;
                                        }

                                        $cek_is_prog = $db->table('tb_renstra_ip_keg')->where(['id_ip_renstra !=' => $ip['id_ip_renstra'], 'kode_opd' => $opd['kode_opd']])->get()->getResultArray();
                                        $data_cek_is_prog_array = [];
                                        foreach ($cek_is_prog as $c) {
                                          $data_cek_is_prog_array[$c['kode_kegiatan']] = true;
                                        }
                                        ?>

                                        <?php if ($cek_kegiatan == 0): ?>
                                          <?= form_open('program-renstra/choose-kegiatan'); ?>
                                          <?= csrf_field() ?>
                                          <div class="modal-body">
                                            <div class="card">
                                              <div class="card-body">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <input type="hidden" name="id_ip_renstra" value="<?= $ip['id_ip_renstra']; ?>">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <div class="mb-3">
                                                  <label class="form-label font-weight-bold">Kegiatan</label>
                                                  <select class="js-example-basic-multiple col-sm-12 z-index-10" name="kode_kegiatan[]" multiple="multiple" required>

                                                    <?php foreach ($kegiatan as $p): ?>
                                                      <option value="<?= $p['kode_kegiatan']; ?>" <?= isset($data_cek_is_prog_array[$p['kode_kegiatan']]) ? 'disabled' : '' ?>><?= $p['kode_kegiatan']; ?> - <?= $p['nama_kegiatan']; ?></option>
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
                                          <?= form_open('program-renstra/edit-choose-kegiatan'); ?>
                                          <?= csrf_field() ?>
                                          <div class="modal-body">
                                            <div class="card">
                                              <div class="card-body">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <input type="hidden" name="id_ip_renstra" value="<?= $ip['id_ip_renstra']; ?>">
                                                <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                                <div class="mb-3">
                                                  <label class="form-label font-weight-bold">Kegiatan</label>
                                                  <select class="js-example-basic-multiple col-sm-12" name="kode_kegiatan[]" multiple="multiple" required>
                                                    <?php foreach ($kegiatan as $p): ?>
                                                      <option value="<?= $p['kode_kegiatan']; ?>" <?= isset($data_cek_is_prog_array[$p['kode_kegiatan']]) ? 'disabled' : '' ?> <?= isset($data_ip_keg_array[$p['kode_kegiatan']]) ? 'selected' : '' ?>><?= $p['kode_kegiatan']; ?> - <?= $p['nama_kegiatan']; ?></option>
                                                    <?php endforeach ?>
                                                  </select>
                                                  <span class="help-block text-danger"></span>
                                                </div>
                                                <div>
                                                  <button type="submit" class="btn btn-inverse btn-block">Edit Kegiatan</button>
                                                  <a onclick="hapusIpKeg(`<?= $ip['id_ip_renstra']; ?>`, `<?= $opd['kode_opd']; ?>`, `<?= $ip['uraian_ip_renstra']; ?>`)" class="btn btn-danger btn-block text-white">Hapus Semua Kegiatan Terpilih</a>
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
                            <?php endif ?>
                          <?php endforeach ?>
                        <?php endforeach ?>


                        <!-- Modal tambah indi Program -->
                        <div class="modal fade" id="tambah_indi_prog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Indikator Program Renstra</h5>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <?= form_open('program-renstra/add-indi'); ?>
                              <?= csrf_field() ?>
                              <input type="hidden" name="kode_bidang" id="kode_bidang_js">
                              <input type="hidden" name="kode_program" id="kode_program_js">
                              <input type="hidden" name="kode_opd" id="kode_opd_js">
                              <div class="modal-body">
                                <div class="card">
                                  <div class="card-body">
                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Nama Program</label>
                                      <p id="nama_program_js"></p>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">No. Indikator</label>
                                      <input type="number" name="no_ip_renstra" class="form-control" required placeholder="Input No. Indikator">
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Uraian Indikator Program</label>
                                      <textarea name="uraian_ip_renstra" class="form-control" rows="2" required placeholder="Input Uraian Program"></textarea>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?></label>
                                        <input type="number" name="kondisi_awal_ip" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1; ?>">
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd']; ?></label>
                                        <input type="number" name="target_ip_th1" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd']; ?>">
                                      </div>
                                    </div>
                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold text-center">Target</label>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?></label>
                                        <input type="number" name="target_ip_th2" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1; ?>">
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?></label>
                                        <input type="number" name="target_ip_th3" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2; ?>">
                                      </div>
                                    </div>


                                    <div class="form-group row">
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?></label>
                                        <input type="number" name="target_ip_th4" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3; ?>">
                                      </div>
                                      <div class="col-sm-6">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?></label>
                                        <input type="number" name="target_ip_th5" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4; ?>">
                                      </div>
                                      <div class="col-sm-6 mt-3">
                                        <label class="form-label font-weight-bold">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?></label>
                                        <input type="number" name="target_ip_th6" class="form-control" required placeholder="Target Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5; ?>">
                                      </div>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                      <input type="number" name="kondisi_akhir_ip" class="form-control" required placeholder="Input Kondisi Akhir">
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Satuan</label>
                                      <input type="text" name="satuan_ip" class="form-control" required placeholder="Input Satuan">
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Formulasi</label>
                                      <textarea name="formulasi_ip" rows="3" class="form-control" required placeholder="Input Formulasi"></textarea>
                                      <span class="help-block text-danger"></span>
                                    </div>

                                    <div class="mb-3">
                                      <label class="form-label font-weight-bold">Keterangan</label>
                                      <textarea name="keterangan_ip" rows="3" class="form-control" required placeholder="Input Keterangan"></textarea>
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
      html: "<strong>Indikator Program</strong> </br><h6>(" + uraian + ")</h6>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('program-renstra/delete-indi/') ?>' + id,
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

  function hapusIpKeg(id, kode_opd, uraian_ip) {
    $('#pilihkegiatan_' + id).modal('hide');
    Swal.fire({
      title: "Hapus Semua Kegiatan?",
      html: "Indikator Program </br><strong>" + uraian_ip + "</strong>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('program-renstra/delete-ip-keg/') ?>' + id + "/" + kode_opd,
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

  // Fungsi memunculkan modal tambah indikator program
  function tambahIndiProg(kode_prog, kode_opd, nama_prog, kode_bidang) {
    $('#tambah_indi_prog').modal('show');
    $('#kode_program_js').val(kode_prog);
    $('#kode_opd_js').val(kode_opd);
    $('#nama_program_js').html(nama_prog);
    $('#kode_bidang_js').val(kode_bidang);
  }
</script>
<script>
  function setrpjmd() {
    var id = $('#pilihan').val();
    $.ajax({
      url: '<?= site_url('program-renstra/set-rpjmd/') ?>' + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        location.reload();
      }
    });
  }
</script>
<?= $this->endSection(); ?>