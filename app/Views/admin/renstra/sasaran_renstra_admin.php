<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
      <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
        <div class="card text-center">
            <div class="card-block">
              <button class="btn btn-out-dashed btn-primary btn-square mb-2">Tujuan</button>
              <button class="btn btn-out-dashed btn-secondary btn-square mb-2">Sasaran</button>
              <button class="btn btn-out-dashed btn-secondary btn-square mb-2">Program</button>
              <button class="btn btn-out-dashed btn-secondary btn-square mb-2">Kegiatan</button>
              <button class="btn btn-out-dashed btn-secondary btn-square mb-2">Sub Kegiatan</button>
            </div>
          </div>
          <div class="row align-items-end">
            <div class="col-xl-10">
              <div class="page-header-title">
                <div class="d-inline">
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
                  <h4>Sasaran - Renstra (<?= $opd['singkatan']; ?>)</h4>
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
                  <h5> <a href="<?= base_url() ?>renstra"><i class="fa-solid fa-arrow-left"></i></a> Data Sasaran Renstra <?= $opd['singkatan']; ?></h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr style="text-align: center;" class="dt-center">
                          <th rowspan="2" class="text-center" style="width: 5%; vertical-align: middle;">Kode Sasaran</th>
                          <th rowspan="2" class="text-center" style="vertical-align: middle;">Uraian Sasaran</th>
                          <?php if (!empty($d_rpjmd) && $d_rpjmd['status_rpjmd'] == 'Aktif'): ?>
                            <th rowspan="2" style="text-align: center; width: 10%; vertical-align: middle;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                          <?php endif ?>
                          <th rowspan="2" class="text-center" style="vertical-align: middle;">Indikator Sasaran</th>
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
                        foreach ($sasaran as $t): ?>
                          <?php
                          $indi_sasaran_1  = $db->table('tb_renstra_indi_sasaran')->where(['id_sasaran_renstra' => $t['id_sasaran_renstra']])->orderBy('no_indikator_is', 'ASC')->get()->getRowArray();

                          $indi_sasaran_2  = $db->table('tb_renstra_indi_sasaran')->where(['id_sasaran_renstra' => $t['id_sasaran_renstra']])->orderBy('no_indikator_is', 'ASC')->get(1000, 1)->getResultArray();
                          $jml_indi_sasaran_2 = $db->table('tb_renstra_indi_sasaran')->where(['id_sasaran_renstra' => $t['id_sasaran_renstra']])->orderBy('no_indikator_is', 'ASC')->get(1000, 1)->getNumRows();
                          ?>

                          <tr>
                            <!-- tombol aksi sasaran -->

                            <td class="text-center" style="vertical-align: middle;" rowspan="<?= $jml_indi_sasaran_2 + 1; ?>"><?= $t['kode_sasaran']; ?></td>
                            <td rowspan="<?= $jml_indi_sasaran_2 + 1; ?>" style="vertical-align: middle;"><?= $t['uraian_sasaran']; ?></td>
                            <?php if ($t['status_rpjmd'] == 'Aktif'): ?>
                              <td class="text-center" rowspan="<?= $jml_indi_sasaran_2 + 1; ?>" style="vertical-align: middle;">
                                <!-- tambah indi sasaran -->
                                <a class="text-inverse mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#tambah_indi_<?= $t['id_sasaran_renstra']; ?>"><i class="fa-regular fa-square-plus" data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Indikator Sasaran Renstra"></i></a>
                                <!-- edit sasaran -->
                                <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit_<?= $t['id_sasaran_renstra']; ?>"><i data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Sasaran Renstra" class="fas fa-edit"></i></a>
                                <!-- hapus sasaran & indi sasaran -->
                                <a class="text-danger mb-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Sasaran Renstra" onclick="hapusData('<?= $t['id_sasaran_renstra']; ?>')"><i class="fas fa-trash"></i></a>
                              </td>
                            <?php endif ?>

                            <?php if (!empty($indi_sasaran_1)): ?>
                              <td data-bs-toggle="modal" data-bs-target="#edit_indi_<?= $indi_sasaran_1['id_is_renstra']; ?>"><?= $indi_sasaran_1['uraian_is']; ?></td>
                              <?php
                              $data_indi_sasaran_1 = $db->table('tb_renstra_indi_sasaran')->where(['id_is_renstra' => $indi_sasaran_1['id_is_renstra']])->get()->getRowArray();
                              ?>

                              <!-- Modal edit indi Sasaran 1 -->
                              <div class="modal fade" id="edit_indi_<?= $indi_sasaran_1['id_is_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title"><?= ($d_rpjmd['status_rpjmd'] == 'Aktif') ? 'Edit' : ''; ?> Indikator Sasaran Renstra</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <?= form_open('sasaran-renstra/update-indi'); ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id_is_renstra" value="<?= $indi_sasaran_1['id_is_renstra']; ?>">
                                    <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">

                                    <div class="modal-body">
                                      <div class="card">
                                        <div class="card-body">
                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Sasaran</label>
                                            <p><?= $t['uraian_sasaran']; ?></p>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">No. Indikator</label>
                                            <input type="number" name="no_indikator_is" class="form-control" value="<?= $data_indi_sasaran_1['no_indikator_is']; ?>" required placeholder="Input No. Indikator">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Indikator Sasaran</label>
                                            <input type="text" name="uraian_is" class="form-control" value="<?= $data_indi_sasaran_1['uraian_is']; ?>" required placeholder="Input Uraian Sasaran">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Kondisi Awal</label>
                                            <input type="number" name="kondisi_awal_is" class="form-control" value="<?= $data_indi_sasaran_1['kondisi_awal_is']; ?>" required placeholder="Input Kondisi Awal">
                                            <span class="help-block text-danger"></span>
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold text-center">Target</label>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] - 1; ?></label>
                                              <input type="number" name="target_is_th1" class="form-control" value="<?= $data_indi_sasaran_1['target_is_th1']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] - 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd']; ?></label>
                                              <input type="number" name="target_is_th2" class="form-control" value="<?= $data_indi_sasaran_1['target_is_th2']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd']; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 1; ?></label>
                                              <input type="number" name="target_is_th3" class="form-control" value="<?= $data_indi_sasaran_1['target_is_th3']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 2; ?></label>
                                              <input type="number" name="target_is_th4" class="form-control" value="<?= $data_indi_sasaran_1['target_is_th4']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 2; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 3; ?></label>
                                              <input type="number" name="target_is_th5" class="form-control" value="<?= $data_indi_sasaran_1['target_is_th5']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 3; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 4; ?></label>
                                              <input type="number" name="target_is_th6" class="form-control" value="<?= $data_indi_sasaran_1['target_is_th6']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 4; ?>">
                                            </div>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                            <input type="number" name="kondisi_akhir_is" class="form-control" value="<?= $data_indi_sasaran_1['kondisi_akhir_is']; ?>" required placeholder="Input Kondisi Akhir">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Satuan</label>
                                            <input type="text" name="satuan_is" class="form-control" value="<?= $data_indi_sasaran_1['satuan_is']; ?>" required placeholder="Input Satuan">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Formulasi</label>
                                            <input type="text" name="formulasi_is" class="form-control" value="<?= $data_indi_sasaran_1['formulasi_is']; ?>" required placeholder="Input Formulasi">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Keterangan</label>
                                            <input type="text" name="keterangan_is" class="form-control" value="<?= $data_indi_sasaran_1['keterangan_is']; ?>" required placeholder="Input Keterangan">
                                            <span class="help-block text-danger"></span>
                                          </div>
                                          <?php if ($d_rpjmd['status_rpjmd'] == 'Aktif'): ?>
                                            <div>
                                              <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                              <button type="button" class="btn btn-danger btn-block" onclick="hapusDataIndi(`<?= $indi_sasaran_1['id_is_renstra']; ?>`, `<?= $indi_sasaran_1['uraian_is']; ?>`)">Delete</button>
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
                            <?php if (!empty($indi_sasaran_1['satuan_is'])): ?>
                              <td class="text-center" data-toggle="tooltip" data-placement="top" title="Formulasi : <?= $indi_sasaran_1['formulasi_is']; ?> ; Keterangan : <?= $indi_sasaran_1['keterangan_is']; ?>"><?= $indi_sasaran_1['satuan_is'] ?></td>
                            <?php else: ?>
                              <td class="text-center">-</td>
                            <?php endif ?>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['kondisi_awal_is'])) ? $indi_sasaran_1['kondisi_awal_is'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['target_is_th1'])) ? $indi_sasaran_1['target_is_th1'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['target_is_th2'])) ? $indi_sasaran_1['target_is_th2'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['target_is_th3'])) ? $indi_sasaran_1['target_is_th3'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['target_is_th4'])) ? $indi_sasaran_1['target_is_th4'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['target_is_th5'])) ? $indi_sasaran_1['target_is_th5'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['target_is_th6'])) ? $indi_sasaran_1['target_is_th6'] : '-'; ?></td>
                            <td class="text-center"><?= (!empty($indi_sasaran_1['kondisi_akhir_is'])) ? $indi_sasaran_1['kondisi_akhir_is'] : '-'; ?></td>

                          </tr>

                          <!-- Modal edit sasaran -->
                          <div class="modal fade" id="modaledit_<?= $t['id_sasaran_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Edit Data</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <?= form_open('sasaran-renstra/update'); ?>
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id_sasaran_renstra" value="<?= $t['id_sasaran_renstra']; ?>">
                                <div class="modal-body">
                                  <div class="card">
                                    <div class="card-body">
                                      <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Tujuan Renstra</label>
                                        <select name="id_tujuan_renstra" class="form-control" required>
                                          <option label="== Pilih Tujuan Renstra =="></option>
                                          <?php foreach ($tujuan as $tu): ?>
                                            <option value="<?= $tu['id_tujuan_renstra']; ?>" <?= ($tu['id_tujuan_renstra'] == $t['id_tujuan_renstra']) ? 'selected' : ''; ?>><?= $tu['kode_tujuan']; ?>. <?= $tu['uraian_tujuan']; ?></option>
                                          <?php endforeach ?>
                                        </select>
                                        <span class="help-block text-danger"></span>
                                      </div>


                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Kode Sasaran</label>
                                        <input type="text" name="kode_sasaran" class="form-control" required value="<?= $t['kode_sasaran']; ?>" placeholder="Input Kode Sasaran">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Uraian Sasaran</label>
                                        <input type="text" name="uraian_sasaran" class="form-control" required value="<?= $t['uraian_sasaran']; ?>" placeholder="Input Uraian Sasaran">
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

                          <!-- Modal tambah indi Sasaran -->
                          <div class="modal fade" id="tambah_indi_<?= $t['id_sasaran_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Indikator Sasaran Renstra</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <?= form_open('sasaran-renstra/add-indi'); ?>
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id_sasaran_renstra" value="<?= $t['id_sasaran_renstra']; ?>">
                                <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">
                                <div class="modal-body">
                                  <div class="card">
                                    <div class="card-body">
                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Uraian Sasaran</label>
                                        <p><?= $t['uraian_sasaran']; ?></p>
                                        <!-- <input type="text" value="<?= $t['uraian_sasaran']; ?>" disabled class="form-control"> -->
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">No. Indikator</label>
                                        <input type="number" name="no_indikator_is" class="form-control" required placeholder="Input No. Indikator">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Uraian Indikator Sasaran</label>
                                        <input type="text" name="uraian_is" class="form-control" required placeholder="Input Uraian Sasaran">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Kondisi Awal</label>
                                        <input type="number" name="kondisi_awal_is" class="form-control" required placeholder="Input Kondisi Awal">
                                        <span class="help-block text-danger"></span>
                                      </div>
                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold text-center">Target</label>
                                      </div>
                                      <div class="form-group row">
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] - 1; ?></label>
                                          <input type="number" name="target_is_th1" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] - 1; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd']; ?></label>
                                          <input type="number" name="target_is_th2" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd']; ?>">
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 1; ?></label>
                                          <input type="number" name="target_is_th3" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 1; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 2; ?></label>
                                          <input type="number" name="target_is_th4" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 2; ?>">
                                        </div>
                                      </div>

                                      <div class="form-group row">
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 3; ?></label>
                                          <input type="number" name="target_is_th5" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 3; ?>">
                                        </div>
                                        <div class="col-sm-6">
                                          <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 4; ?></label>
                                          <input type="number" name="target_is_th6" class="form-control" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 4; ?>">
                                        </div>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                        <input type="number" name="kondisi_akhir_is" class="form-control" required placeholder="Input Kondisi Akhir">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Satuan</label>
                                        <input type="text" name="satuan_is" class="form-control" required placeholder="Input Satuan">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Formulasi</label>
                                        <input type="text" name="formulasi_is" class="form-control" required placeholder="Input Formulasi">
                                        <span class="help-block text-danger"></span>
                                      </div>

                                      <div class="mb-3">
                                        <label class="form-label font-weight-bold">Keterangan</label>
                                        <input type="text" name="keterangan_is" class="form-control" required placeholder="Input Keterangan">
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

                          <?php if ($jml_indi_sasaran_2 > 0): ?>
                            <?php foreach ($indi_sasaran_2 as $in): ?>
                              <tr>
                                <td data-bs-toggle="modal" data-bs-target="#edit_indi_<?= $in['id_is_renstra']; ?>"><?= $in['uraian_is']; ?></td>
                                <?php if (!empty($in['satuan_is'])): ?>
                                  <td class="text-center" data-toggle="tooltip" data-placement="top" title="Formulasi : <?= $in['formulasi_is']; ?>"><?= $in['satuan_is'] ?></td>
                                <?php else: ?>
                                  <td class="text-center">-</td>
                                <?php endif ?>
                                <td class="text-center"><?= (!empty($in['kondisi_awal_is'])) ? $in['kondisi_awal_is'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_is_th1'])) ? $in['target_is_th1'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_is_th2'])) ? $in['target_is_th2'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_is_th3'])) ? $in['target_is_th3'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_is_th4'])) ? $in['target_is_th4'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_is_th5'])) ? $in['target_is_th5'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['target_is_th6'])) ? $in['target_is_th6'] : '-'; ?></td>
                                <td class="text-center"><?= (!empty($in['kondisi_akhir_is'])) ? $in['kondisi_akhir_is'] : '-'; ?></td>
                              </tr>

                              <?php
                              $data_indi_sasaran_2 = $db->table('tb_renstra_indi_sasaran')->where(['id_is_renstra' => $in['id_is_renstra']])->get()->getRowArray();
                              ?>

                              <!-- Modal edit indi Sasaran 1 -->
                              <div class="modal fade" id="edit_indi_<?= $in['id_is_renstra']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title"><?= ($d_rpjmd['status_rpjmd'] == 'Aktif') ? 'Edit' : ''; ?> Indikator Sasaran Renstra</h5>
                                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <?= form_open('sasaran-renstra/update-indi'); ?>
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="id_is_renstra" value="<?= $in['id_is_renstra']; ?>">
                                    <input type="hidden" name="kode_opd" value="<?= $kode_opd; ?>">

                                    <div class="modal-body">
                                      <div class="card">
                                        <div class="card-body">
                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Sasaran</label>
                                            <p><?= $t['uraian_sasaran']; ?></p>
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">No. Indikator Sasaran</label>
                                            <input type="number" name="no_indikator_is" class="form-control" value="<?= $data_indi_sasaran_2['no_indikator_is']; ?>" required placeholder="Input No. Indikator Sasaran">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Uraian Indikator Sasaran</label>
                                            <input type="text" name="uraian_is" class="form-control" value="<?= $data_indi_sasaran_2['uraian_is']; ?>" required placeholder="Input Uraian Indikator Sasaran">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Kondisi Awal</label>
                                            <input type="number" name="kondisi_awal_is" class="form-control" value="<?= $data_indi_sasaran_2['kondisi_awal_is']; ?>" required placeholder="Input Kondisi Awal">
                                            <span class="help-block text-danger"></span>
                                          </div>
                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold text-center">Target</label>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] - 1; ?></label>
                                              <input type="number" name="target_is_th1" class="form-control" value="<?= $data_indi_sasaran_2['target_is_th1']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] - 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd']; ?></label>
                                              <input type="number" name="target_is_th2" class="form-control" value="<?= $data_indi_sasaran_2['target_is_th2']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd']; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 1; ?></label>
                                              <input type="number" name="target_is_th3" class="form-control" value="<?= $data_indi_sasaran_2['target_is_th3']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 1; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 2; ?></label>
                                              <input type="number" name="target_is_th4" class="form-control" value="<?= $data_indi_sasaran_2['target_is_th4']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 2; ?>">
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 3; ?></label>
                                              <input type="number" name="target_is_th5" class="form-control" value="<?= $data_indi_sasaran_2['target_is_th5']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 3; ?>">
                                            </div>
                                            <div class="col-sm-6">
                                              <label class="form-label font-weight-bold">Th. <?= $t['th_awal_rpjmd'] + 4; ?></label>
                                              <input type="number" name="target_is_th6" class="form-control" value="<?= $data_indi_sasaran_2['target_is_th6']; ?>" required placeholder="Target Th. <?= $t['th_awal_rpjmd'] + 4; ?>">
                                            </div>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Kondisi Akhir</label>
                                            <input type="number" name="kondisi_akhir_is" class="form-control" value="<?= $data_indi_sasaran_2['kondisi_akhir_is']; ?>" required placeholder="Input Kondisi Akhir">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Satuan</label>
                                            <input type="text" name="satuan_is" class="form-control" value="<?= $data_indi_sasaran_2['satuan_is']; ?>" required placeholder="Input Satuan">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Formulasi</label>
                                            <input type="text" name="formulasi_is" class="form-control" value="<?= $data_indi_sasaran_2['formulasi_is']; ?>" required placeholder="Input Formulasi">
                                            <span class="help-block text-danger"></span>
                                          </div>

                                          <div class="mb-3">
                                            <label class="form-label font-weight-bold">Keterangan</label>
                                            <input type="text" name="keterangan_is" class="form-control" value="<?= $data_indi_sasaran_2['keterangan_is']; ?>" required placeholder="Input Keterangan">
                                            <span class="help-block text-danger"></span>
                                          </div>
                                          <?php if ($d_rpjmd['status_rpjmd'] == 'Aktif'): ?>
                                            <div>
                                              <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                              <button type="button" class="btn btn-danger btn-block" onclick="hapusDataIndi(`<?= $data_indi_sasaran_2['id_is_renstra']; ?>`, `<?= $data_indi_sasaran_2['uraian_is']; ?>`)">Delete</button>
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

<!-- Modal tambah sasaran -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Data</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url() ?>sasaran-renstra/save" method="POST" id="form-tambah">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
              <div class="mb-3">
                <label class="form-label font-weight-bold">Tujuan Renstra</label>
                <select name="id_tujuan_renstra" class="form-control" required>
                  <option label="== Pilih Tujuan Renstra =="></option>
                  <?php foreach ($tujuan as $t): ?>
                    <option value="<?= $t['id_tujuan_renstra']; ?>"><?= $t['kode_tujuan']; ?>. <?= $t['uraian_tujuan']; ?></option>
                  <?php endforeach ?>
                </select>
                <span class="help-block text-danger"></span>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold">Kode Sasaran</label>
                <input type="text" name="kode_sasaran" class="form-control" required placeholder="Input Kode Sasaran">
                <span class="help-block text-danger"></span>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold">Uraian Sasaran</label>
                <input type="text" name="uraian_sasaran" class="form-control" required placeholder="Input Uraian Sasaran">
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
          url: '<?= site_url('sasaran-renstra/delete/') ?>' + id,
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
      html: "Indikator Sasaran </br><strong>" + uraian + "</strong>",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#404E67",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, Hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '<?= site_url('sasaran-renstra/delete-indi/') ?>' + id,
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
      url: '<?= site_url('sasaran-renstra/set-rpjmd/') ?>' + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        location.reload();
      }
    });
  }
</script>
<?= $this->endSection(); ?>