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
                  $opd        = $db->table('tb_opd')->where(['kode_opd' => $tujuan_renstra['kode_opd']])->get()->getRowArray();
                  ?>
                  <h4>Indikator Tujuan - Renstra (<?= $opd['nama_opd']; ?>)</h4>
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
                  <h5> <a href="<?= base_url() ?>tujuan-renstra/add/<?= $tujuan_renstra['kode_opd'] ?>"><i class="fa-solid fa-arrow-left"></i></a> Data Indikator Tujuan Renstra (<?= $opd['singkatan']; ?>)</h5>
                  <button style="margin-top: -10px;" class="btn hor-grd btn-sm btn-grd-inverse btn-out float-right" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button>
                  <hr>
                  <span><strong>Uraian Tujuan : </strong><?= $tujuan_renstra['uraian_tujuan']; ?></span>
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <table id="datatable" class="display cell-border table-bordered" style="min-width: 845px; border:1px solid #aaa;">
                      <thead>

                        <tr>
                          <th rowspan="2" style="text-align: center;">No.</th>
                          <th rowspan="2" style="text-align: center;">Uraian</th>
                          <th rowspan="2" style="text-align: center;">Satuan</th>
                          <th rowspan="2" style="text-align: center; width: 1%;">Kondisi Awal</th>
                          <th colspan="6" style="text-align: center;">Target</th>
                          <th rowspan="2" style="text-align: center;">Kondisi Akhir</th>
                          <th rowspan="2" style="text-align: center;">
                            Aksi
                          </th>

                        </tr>
                        <tr>
                          <th style="text-align: center;">Th. 2021</th>
                          <th style="text-align: center;">Th. 2022</th>
                          <th style="text-align: center;">Th. 2023</th>
                          <th style="text-align: center;">Th. 2024</th>
                          <th style="text-align: center;">Th. 2025</th>
                          <th style="text-align: center;">Th. 2026</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($inditujuan as $in): ?>
                          <tr>
                            <td class="text-center"><?= $in['no_indikator']; ?></td>
                            <td class="text-center"><?= $in['uraian_indikator']; ?></td>
                            <td class="text-center"><?= $in['satuan']; ?></td>
                            <td class="text-center" style="width: 5%;"><?= $in['kondisi_awal']; ?></td>
                            <td class="text-center"><?= $in['target_tujuan_th1']; ?></td>
                            <td class="text-center"><?= $in['target_tujuan_th2']; ?></td>
                            <td class="text-center"><?= $in['target_tujuan_th3']; ?></td>
                            <td class="text-center"><?= $in['target_tujuan_th4']; ?></td>
                            <td class="text-center"><?= $in['target_tujuan_th5']; ?></td>
                            <td class="text-center"><?= $in['target_tujuan_th6']; ?></td>
                            <td class="text-center"><?= $in['kondisi_akhir']; ?></td>
                            <td class="text-center">
                              <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit_<?= $in['id_tujuan_renstra']; ?>"><i class="fas fa-edit"></i></a>
                              <a class="text-danger mb-1" onclick="hapusData('<?= $in['id_tujuan_renstra']; ?>')"><i class="fas fa-trash"></i></a>
                            </td>
                          </tr>
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
                <label class="form-label font-weight-bold">Kode Indikator Tujuan</label>
                <input type="text" name="kode_tujuan" class="form-control" required placeholder="Input Kode Indikator Tujuan">
                <span class="help-block text-danger"></span>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold">Uraian Indikator Tujuan</label>
                <input type="text" name="uraian_tujuan" class="form-control" required placeholder="Input Uraian Indikator Tujuan">
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
    // Server side processing Data-table
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