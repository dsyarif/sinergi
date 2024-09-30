<?= $this->extend('admin/template'); ?>

<?= $this->section('content'); ?>
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <!-- Main-body start -->
    <div class="main-body">
      <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
          <div class="row align-items-end">
            <div class="col-lg-8">
              <div class="page-header-title">
                <div class="d-inline">
                  <?php
                  $db         = \Config\Database::connect();
                  $opd        = $db->table('tb_opd')->where(['kode_opd' => $kode_opd])->get()->getRowArray();
                  ?>
                  <h4>Tujuan - Renstra (<?= $opd['singkatan']; ?>)</h4>
                  <!-- <span>Tuj</span> -->
                </div>
              </div>
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
                    <table id="datatable" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center;" class="dt-center">
                          <!-- <th class="text-center">Indikator Sasaran RPJMD</th> -->
                          <th class="text-center" style="width: 5%;">Kode Tujuan</th>
                          <th class="text-center">Uraian Tujuan</th>
                          <th class="text-center">Indikator Tujuan</th>
                          <th style="text-align: center; width: 10%;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($tujuan as $t): ?>
                          <?php
                          $db                = \Config\Database::connect();
                          $jml_indi_tujuan        = $db->table('tb_indi_tujuan_renstra')->where(['id_tujuan' => $t['id_tujuan_renstra']])->get()->getNumRows();
                          ?>
                          <tr>
                            <!-- <td class="text-center"><?= $t['id_indi_sasaran_rpjmd']; ?></td> -->
                            <td class="text-center"><?= $t['kode_tujuan']; ?></td>
                            <td><?= $t['uraian_tujuan']; ?></td>
                            <td class="text-center">
                              <a href="<?= base_url() ?>indi-tujuan-renstra/add/<?= $t['id_tujuan_renstra']; ?>" class="btn hor-grd btn-grd-inverse btn-sm">
                                <?= $jml_indi_tujuan; ?> Indikator
                              </a>
                            </td>
                            <td class="text-center">
                              <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit_<?= $t['id_tujuan_renstra']; ?>"><i class="fas fa-edit"></i></a>
                              <a class="text-danger mb-1" onclick="hapusData('<?= $t['id_tujuan_renstra']; ?>')"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>

                          <!-- Modal edit periode -->
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

    // if (confirm("Apakah Anda YAkin Ingin Hapus Data?")) {

    // }
  }
</script>

<?= $this->endSection(); ?>