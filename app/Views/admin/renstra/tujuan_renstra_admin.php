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

                  <h4>Tujuan - Renstra (<?= $opd['singkatan']; ?>)</h4>
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
                  <h5> <a href="<?= base_url() ?>renstra"><i class="fa-solid fa-arrow-left"></i></a> Data Tujuan Renstra <?= $opd['singkatan']; ?></h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr style="text-align: center;" class="dt-center">
                          <th rowspan="2" class="text-center" style="width: 5%; vertical-align: middle;">Kode Tujuan</th>
                          <th rowspan="2" class="text-center" style="vertical-align: middle;">Uraian Tujuan</th>
                          <?php if (!empty($d_rpjmd) && $d_rpjmd['status_rpjmd'] == 'Aktif'): ?>
                            <th rowspan="2" style="text-align: center; width: 10%; vertical-align: middle;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                          <?php endif ?>
                          <th rowspan="2" class="text-center" style="vertical-align: middle;">Indikator Tujuan</th>
                          <th rowspan="2" style="text-align: center; vertical-align: middle;">Satuan</th>
                          <th colspan="2" style="text-align: center; vertical-align: middle;">Kondisi Awal</th>
                          <th colspan="5" style="text-align: center; vertical-align: middle;">Target</th>
                          <th rowspan="2" style="text-align: center; vertical-align: middle;">Kondisi Akhir</th>
                        </tr>

                        <tr>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] - 1 ?></th>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] ?></th>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 1 ?></th>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 2 ?></th>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 3 ?></th>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 4 ?></th>
                          <th style="text-align: center;vertical-align: middle;">Th. <?= $d_rpjmd['th_awal_rpjmd'] + 5 ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($tujuan as $t): ?>
                          <?php
                          $indi_tujuan_1  = $db->table('tb_renstra_indi_tujuan')->where(['id_tujuan' => $t['id_tujuan_renstra']])->orderBy('no_indikator', 'ASC')->get()->getRowArray();

                          $indi_tujuan_2  = $db->table('tb_renstra_indi_tujuan')->where(['id_tujuan' => $t['id_tujuan_renstra']])->orderBy('no_indikator', 'ASC')->get(1000, 1)->getResultArray();
                          $jml_indi_tujuan_2 = $db->table('tb_renstra_indi_tujuan')->where(['id_tujuan' => $t['id_tujuan_renstra']])->orderBy('no_indikator', 'ASC')->get(1000, 1)->getNumRows();
                          ?>

                          <tr>
                            <!-- tombol aksi tujuan -->
                            <td class="text-center" style="vertical-align: middle;" rowspan="<?= $jml_indi_tujuan_2 + 1; ?>"><?= $t['kode_tujuan']; ?></td>
                            <td rowspan="<?= $jml_indi_tujuan_2 + 1; ?>" style="vertical-align: middle;"><?= $t['uraian_tujuan']; ?></td>
                            <?php if ($t['status_rpjmd'] == 'Aktif'): ?>
                              <td class="text-center" rowspan="<?= $jml_indi_tujuan_2 + 1; ?>" style="vertical-align: middle;">
                                <!-- tambah indi tujuan -->
                                <a class="text-inverse mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#tambah_indi_<?= $t['id_tujuan_renstra']; ?>"><i class="fa-regular fa-square-plus" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Indikator Tujuan Renstra"></i></a>
                                <!-- edit tujuan -->
                                <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit_<?= $t['id_tujuan_renstra']; ?>"><i data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Tujuan Renstra" class="fas fa-edit"></i></a>
                                <!-- hapus tujuan & indi tujuan -->
                                <a class="text-danger mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Tujuan Renstra" onclick="hapusData('<?= $t['id_tujuan_renstra']; ?>')"><i class="fas fa-trash"></i></a>
                              </td>
                            <?php endif ?>

                            <?php if (!empty($indi_tujuan_1)): ?>
                              <td data-bs-toggle="modal" data-bs-target="#edit_indi_<?= $indi_tujuan_1['id_indi_tujuan_renstra']; ?>"><?= $indi_tujuan_1['uraian_indikator']; ?></td>
                              <?php
                              $data_indi_tujuan_1 = $db->table('tb_renstra_indi_tujuan')->where(['id_indi_tujuan_renstra' => $indi_tujuan_1['id_indi_tujuan_renstra']])->get()->getRowArray();
                              ?>

                              <!-- Modal edit indi Tujuan baris 1 -->
                              <div class="modal fade" id="edit_indi_<?= $indi_tujuan_1['id_indi_tujuan_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title"><?= ($d_rpjmd['status_rpjmd'] == 'Aktif') ? 'Edit' : ''; ?> Indikator Tujuan Renstra</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <?= form_open('tujuan-renstra/update-indi'); ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id_indi_tujuan_renstra" value="<?= $indi_tujuan_1['id_indi_tujuan_renstra']; ?>">
                                    <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">

                                    <div class="modal-body">
                                      <div class="card">
                                        <div class="card-body">
                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Tujuan</label>
                                            <p><?= $t['uraian_tujuan']; ?></p>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">No. Indikator</label>
                                            <input type="number" name="no_indikator" class="form-control" value="<?= $data_indi_tujuan_1['no_indikator']; ?>" required placeholder="Input No. Indikator">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Indikator Tujuan</label>
                                            <textarea name="uraian_indikator" class="form-control" required placeholder="Input Uraian Tujuan"><?= $data_indi_tujuan_1['uraian_indikator']; ?></textarea>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] - 1; ?></label>
                                              <input type="number" value="<?= $data_indi_tujuan_1['kondisi_awal']; ?>" name="kondisi_awal" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] - 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd']; ?></label>
                                              <input type="number" name="target_tujuan_th1" class="form-control" value="<?= $data_indi_tujuan_1['target_tujuan_th1']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd']; ?>">
                                            </div>
                                          </div>


                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold text-center">Target</label>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 1; ?></label>
                                              <input type="number" name="target_tujuan_th2" class="form-control" value="<?= $data_indi_tujuan_1['target_tujuan_th2']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 2; ?></label>
                                              <input type="number" name="target_tujuan_th3" class="form-control" value="<?= $data_indi_tujuan_1['target_tujuan_th3']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 2; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 3; ?></label>
                                              <input type="number" name="target_tujuan_th4" class="form-control" value="<?= $data_indi_tujuan_1['target_tujuan_th4']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 3; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 4; ?></label>
                                              <input type="number" name="target_tujuan_th5" class="form-control" value="<?= $data_indi_tujuan_1['target_tujuan_th5']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 4; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 5; ?></label>
                                              <input type="number" name="target_tujuan_th6" class="form-control" value="<?= $data_indi_tujuan_1['target_tujuan_th6']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 5; ?>">
                                            </div>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                            <input type="number" name="kondisi_akhir" class="form-control" value="<?= $data_indi_tujuan_1['kondisi_akhir']; ?>" required placeholder="Input Kondisi Akhir">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Satuan</label>
                                            <input type="text" name="satuan" class="form-control" value="<?= $data_indi_tujuan_1['satuan']; ?>" required placeholder="Input Satuan">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Formulasi</label>
                                            <textarea name="formulasi" class="form-control" required rows="2" placeholder="Input Formulasi"><?= $data_indi_tujuan_1['formulasi']; ?></textarea>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" required rows="2" placeholder="Input Keterangan"><?= $data_indi_tujuan_1['keterangan']; ?></textarea>
                                            <span class="help-block text-danger"></span>
                                          </div>
                                          <?php if ($d_rpjmd['status_rpjmd'] == 'Aktif'): ?>
                                            <div>
                                              <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                              <button type="button" class="btn btn-danger btn-block" onclick="hapusDataIndi(`<?= $indi_tujuan_1['id_indi_tujuan_renstra']; ?>`, `<?= $indi_tujuan_1['uraian_indikator']; ?>`)">Delete</button>
                                            </div>
                                          <?php endif ?>
                                        </div>
                                      </div>
                                      <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
                                    </div>
                                  </div>
                                  <!-- <div class="modal-footer d-flex justify-content-center"> -->
                                  <?= form_close(); ?>
                                </div>
                              </div>

                            <?php else: ?>
                              <td>-</td>
                            <?php endif ?>
                            <?php if (!empty($indi_tujuan_1['satuan'])): ?>
                              <td class="text-center" data-toggle="tooltip" data-placement="top" title="Formulasi : <?= $indi_tujuan_1['formulasi']; ?> ; Keterangan : <?= $indi_tujuan_1['keterangan']; ?>"><?= $indi_tujuan_1['satuan'] ?></td>
                            <?php else: ?>
                              <td class="text-center">-</td>
                            <?php endif ?>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['kondisi_awal'])) ? $indi_tujuan_1['kondisi_awal'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['target_tujuan_th1'])) ? $indi_tujuan_1['target_tujuan_th1'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['target_tujuan_th2'])) ? $indi_tujuan_1['target_tujuan_th2'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['target_tujuan_th3'])) ? $indi_tujuan_1['target_tujuan_th3'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['target_tujuan_th4'])) ? $indi_tujuan_1['target_tujuan_th4'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['target_tujuan_th5'])) ? $indi_tujuan_1['target_tujuan_th5'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['target_tujuan_th6'])) ? $indi_tujuan_1['target_tujuan_th6'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_tujuan_1['kondisi_akhir'])) ? $indi_tujuan_1['kondisi_akhir'] : '-'; ?></td>

                          </tr>

                          <!-- Modal edit tujuan -->
                          <div class="modal fade" id="modaledit_<?= $t['id_tujuan_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Edit Data</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <?= form_open('tujuan-renstra/update'); ?>
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id_tujuan_renstra" value="<?= $t['id_tujuan_renstra']; ?>">
                                <div class="modal-body">
                                  <div class="card">
                                    <div class="card-body">
                                      <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Kode Tujuan</label>
                                        <input type="text" name="kode_tujuan" class="form-control" required value="<?= $t['kode_tujuan']; ?>" placeholder="Input Kode Tujuan">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Uraian Tujuan</label>
                                        <input type="text" name="uraian_tujuan" class="form-control" required value="<?= $t['uraian_tujuan']; ?>" placeholder="Input Uraian Tujuan">
                                        <span class="help-block text-danger"></span>
                                      </div>
                                      <div>
                                        <button type="submit" class="btn btn-inverse btn-block">Edit</button>

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

                          <!-- Modal tambah indi Tujuan -->
                          <div class="modal fade" id="tambah_indi_<?= $t['id_tujuan_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Indikator Tujuan Renstra</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <?= form_open('tujuan-renstra/add-indi'); ?>
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id_tujuan" value="<?= $t['id_tujuan_renstra']; ?>">
                                <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">
                                <div class="modal-body">
                                  <div class="card">
                                    <div class="card-body">
                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Uraian Tujuan</label>
                                        <p><?= $t['uraian_tujuan']; ?></p>
                                        <!-- <input type="text" value="<?= $t['uraian_tujuan']; ?>" disabled class="form-control"> -->
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">No. Indikator</label>
                                        <input type="number" name="no_indikator" class="form-control" required placeholder="Input No. Indikator">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Uraian Indikator Tujuan</label>
                                        <textarea name="uraian_indikator" rows="2" class="form-control" required placeholder="Input Uraian Tujuan"></textarea>
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] - 1; ?></label>
                                          <input type="number" name="kondisi_awal" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] - 1; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd']; ?></label>
                                          <input type="number" name="target_tujuan_th1" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd']; ?>">
                                        </div>
                                      </div>


                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold text-center">Target</label>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 1; ?></label>
                                          <input type="number" name="target_tujuan_th2" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 1; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 2; ?></label>
                                          <input type="number" name="target_tujuan_th3" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 2; ?>">
                                        </div>
                                      </div>


                                      <div class="form-group row">
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 3; ?></label>
                                          <input type="number" name="target_tujuan_th4" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 3; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 4; ?></label>
                                          <input type="number" name="target_tujuan_th5" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 4; ?>">
                                        </div>
                                        <div class="col-sm-6 mt-3">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 5; ?></label>
                                          <input type="number" name="target_tujuan_th6" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 5; ?>">
                                        </div>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                        <input type="number" name="kondisi_akhir" class="form-control" required placeholder="Input Kondisi Akhir">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Satuan</label>
                                        <input type="text" name="satuan" class="form-control" required placeholder="Input Satuan">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Formulasi</label>
                                        <textarea name="formulasi" class="form-control" rows="2" required placeholder="Input Formulasi"></textarea>
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="2" required placeholder="Input Keterangan"></textarea>
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

                          <?php if ($jml_indi_tujuan_2 > 0): ?>
                            <?php foreach ($indi_tujuan_2 as $in): ?>
                              <tr>
                                <td data-bs-toggle="modal" data-bs-target="#edit_indi_<?= $in['id_indi_tujuan_renstra']; ?>"><?= $in['uraian_indikator']; ?></td>
                                <?php if (!empty($in['satuan'])): ?>
                                  <td class="text-center" data-toggle="tooltip" data-placement="top" title="Formulasi : <?= $in['formulasi']; ?>"><?= $in['satuan'] ?></td>
                                <?php else: ?>
                                  <td class="text-center">-</td>
                                <?php endif ?>
                                <td class="text-center"><?= (!empty($in['kondisi_awal'])) ? $in['kondisi_awal'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_tujuan_th1'])) ? $in['target_tujuan_th1'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_tujuan_th2'])) ? $in['target_tujuan_th2'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_tujuan_th3'])) ? $in['target_tujuan_th3'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_tujuan_th4'])) ? $in['target_tujuan_th4'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_tujuan_th5'])) ? $in['target_tujuan_th5'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_tujuan_th6'])) ? $in['target_tujuan_th6'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['kondisi_akhir'])) ? $in['kondisi_akhir'] : '-'; ?></td>
                              </tr>

                              <?php
                              $data_indi_tujuan_2 = $db->table('tb_renstra_indi_tujuan')->where(['id_indi_tujuan_renstra' => $in['id_indi_tujuan_renstra']])->get()->getRowArray();
                              ?>

                              <!-- Modal edit indi Tujuan baris ke 2 dan seterusnya -->
                              <div class="modal fade" id="edit_indi_<?= $in['id_indi_tujuan_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title"><?= ($d_rpjmd['status_rpjmd'] == 'Aktif') ? 'Edit' : ''; ?> Indikator Tujuan Renstra</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <?= form_open('tujuan-renstra/update-indi'); ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id_indi_tujuan_renstra" value="<?= $in['id_indi_tujuan_renstra']; ?>">
                                    <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">

                                    <div class="modal-body">
                                      <div class="card">
                                        <div class="card-body">
                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Tujuan</label>
                                            <p><?= $t['uraian_tujuan']; ?></p>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">No. Indikator</label>
                                            <input type="number" name="no_indikator" class="form-control" value="<?= $data_indi_tujuan_2['no_indikator']; ?>" required placeholder="Input No. Indikator">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Indikator Tujuan</label>
                                            <textarea name="uraian_indikator" required class="form-control" placeholder="Input Uraian Tujuan" rows="2"><?= $data_indi_tujuan_2['uraian_indikator']; ?></textarea>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold text-center">Kondisi Awal</label>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] - 1; ?></label>
                                              <input type="number" value="<?= $data_indi_tujuan_2['kondisi_awal']; ?>" name="kondisi_awal" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] - 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd']; ?></label>
                                              <input type="number" name="target_tujuan_th1" class="form-control" value="<?= $data_indi_tujuan_2['target_tujuan_th1']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd']; ?>">
                                            </div>
                                          </div>


                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold text-center">Target</label>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 1; ?></label>
                                              <input type="number" name="target_tujuan_th2" class="form-control" value="<?= $data_indi_tujuan_2['target_tujuan_th2']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 2; ?></label>
                                              <input type="number" name="target_tujuan_th3" class="form-control" value="<?= $data_indi_tujuan_2['target_tujuan_th3']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 2; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 3; ?></label>
                                              <input type="number" name="target_tujuan_th4" class="form-control" value="<?= $data_indi_tujuan_2['target_tujuan_th4']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 3; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 4; ?></label>
                                              <input type="number" name="target_tujuan_th5" class="form-control" value="<?= $data_indi_tujuan_2['target_tujuan_th5']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 4; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 5; ?></label>
                                              <input type="number" name="target_tujuan_th6" class="form-control" value="<?= $data_indi_tujuan_2['target_tujuan_th6']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 5; ?>">
                                            </div>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                            <input type="number" name="kondisi_akhir" class="form-control" value="<?= $data_indi_tujuan_2['kondisi_akhir']; ?>" required placeholder="Input Kondisi Akhir">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Satuan</label>
                                            <input type="text" name="satuan" class="form-control" value="<?= $data_indi_tujuan_2['satuan']; ?>" required placeholder="Input Satuan">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Formulasi</label>
                                            <textarea name="formulasi" class="form-control" required rows="2" placeholder="Input Formulasi"><?= $data_indi_tujuan_2['formulasi']; ?></textarea>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Keterangan</label>
                                            <textarea name="keterangan" class="form-control" required rows="2" placeholder="Input Keterangan"><?= $data_indi_tujuan_2['keterangan']; ?></textarea>
                                            <span class="help-block text-danger"></span>
                                          </div>
                                          <?php if ($d_rpjmd['status_rpjmd'] == 'Aktif'): ?>
                                            <div>
                                              <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                              <button type="button" class="btn btn-danger btn-block" onclick="hapusDataIndi(`<?= $data_indi_tujuan_2['id_indi_tujuan_renstra']; ?>`, `<?= $data_indi_tujuan_2['uraian_indikator']; ?>`)">Delete</button>
                                            </div>
                                          <?php endif ?>
                                        </div>
                                      </div>
                                      <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
                                    </div>
                                  </div>
                                  <!-- <div class="modal-footer d-flex justify-content-center"> -->
                                  <?= form_close(); ?>
                                </div>
                              </div>
                            <?php endforeach ?>
                          <?php endif ?>

                        <?php endforeach ?>
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

<!-- Modal tambah tujuan -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Data</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url() ?>tujuan-renstra/save" method="POST" id="form-tambah">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
              <div class="mb-3">
                <label class="form-label font-weight-bold">Kode Tujuan</label>
                <input type="text" name="kode_tujuan" class="form-control" required placeholder="Input Kode Tujuan">
                <span class="help-block text-danger"></span>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold">Uraian Tujuan</label>
                <input type="text" name="uraian_tujuan" class="form-control" required placeholder="Input Uraian Tujuan">
                <span class="help-block text-danger"></span>
              </div>

            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-inverse btn-block">Simpan</button>
          </div>
          <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
        </div>
    </div>
    <!-- <div class="modal-footer d-flex justify-content-center"> -->
    <?= form_close(); ?>
  </div>
</div>

<script>
  $(document).ready(function() {
    $tabel = $('#datatable').DataTable();

  });

  function tampil_modal() {
    method = 'save';
    $("#form-tambah")[0].reset();
    $('#modal-tambah').modal('show');
    $('#modal-title').text('Tambah Data');
  }


  function hapusData(id) {
    Swal.fire({
      title: "Hapus Data?",
      text: "Data Akan Dihapus Secara Permanen!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('tujuan-renstra/delete/') ?>' + id,
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

  function hapusDataIndi(id, uraian) {
    $('#edit_indi_' + id).modal('hide');
    Swal.fire({
      title: "Hapus Data?",
      html: "Indikator Tujuan </br><strong>" + uraian + "</strong>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('tujuan-renstra/delete-indi/') ?>' + id,
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
</script>
<script>
  function setrpjmd() {
    var id = $('#pilihan').val();
    $.ajax({
      url: '<?= site_url('tujuan-renstra/set-rpjmd/') ?>' + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        location.reload();
      }
    });
  }
</script>
<?= $this->endSection(); ?>