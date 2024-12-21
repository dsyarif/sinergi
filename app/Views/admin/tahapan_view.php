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
                  <h4>Tahapan</h4>
                  <!-- <span></span> -->
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
                  <h5>Data Tahapan</h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center;" class="dt-center">
                          <th class="text-center">No</th>
                          <th class="text-center">Jenis</th>
                          <th class="text-center">Tahapan</th>
                          <th class="text-center">Tanggal Mulai</th>
                          <th class="text-center">Tanggal Selesai</th>
                          <th class="text-center">Status</th>
                          <th style="text-align: center; width: 10%;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($tahapan as $r): ?>
                          <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $r['jenis']; ?></td>
                            <td class="text-center"><?= $r['nama_tahapan']; ?></td>
                            <td class="text-center"><?= $r['tgl_mulai']; ?></td>
                            <td class="text-center"><?= $r['tgl_selesai']; ?></td>
                            <td class="text-center"><?= $r['status']; ?></td>
                            <td class="d-flex justify-content-center">
                              <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit<?= $r['id_tahapan']; ?>"><i class="fas fa-edit"></i></a>
                              <a class="text-danger mb-1" onclick="hapusData('<?= $r['id_tahapan']; ?>')"><i class="fas fa-trash"></i></a>
                            </td>

                          </tr>

                          <!-- Modal edit periode -->
                          <div class="modal fade" id="modaledit<?= $r['id_tahapan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="<?= base_url() ?>tahapan/update" method="POST" id="form-edit">
                                  <?= csrf_field() ?>
                                  <input type="hidden" name="_method" value="PUT">
                                  <input type="hidden" name="id_tahapan" id="id_tahapan" value="<?= $r['id_tahapan']; ?>">
                                  <div class="modal-body">
                                    <div class="card">
                                      <div class="card-body">
                                        <div class="mb-3">
                                          <label class="form-label font-weight-bold">Jenis</label>
                                          <select name="jenis" class="form-control" required>
                                            <option label="== Pilih Jenis =="></option>
                                            <option value="RPJPD" <?= ($r['jenis'] == 'RPJPD') ? 'selected' : ''; ?>>RPJPD</option>
                                            <option value="RPJMD" <?= ($r['jenis'] == 'RPJMD') ? 'selected' : ''; ?>>RPJMD</option>
                                            <option value="RESNTRA" <?= ($r['jenis'] == 'RESNTRA') ? 'selected' : ''; ?>>RENSTRA</option>
                                            <option value="RKPD" <?= ($r['jenis'] == 'RKPD') ? 'selected' : ''; ?>>RKPD</option>
                                          </select>
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label font-weight-bold">Tahapan</label>
                                          <select name="nama_tahapan" class="form-control" required>
                                            <option label="== Pilih Tahapan =="></option>
                                            <option value="Rancangan Awal" <?= ($r['nama_tahapan'] == 'Rancangan Awal') ? 'selected' : ''; ?>>Rancangan Awal</option>
                                            <option value="Rancangan" <?= ($r['nama_tahapan'] == 'Rancangan') ? 'selected' : ''; ?>>Rancangan</option>
                                            <option value="Musrenbang" <?= ($r['nama_tahapan'] == 'Musrenbang') ? 'selected' : ''; ?>>Rancangan</option>
                                            <option value="Rancangan Akhir" <?= ($r['nama_tahapan'] == 'Rancangan Akhir') ? 'selected' : ''; ?>>Rancangan</option>
                                            <option value="Penetapan" <?= ($r['nama_tahapan'] == 'Penetapan') ? 'selected' : ''; ?>>Rancangan</option>
                                          </select>
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label font-weight-bold">Tanggal Mulai</label>
                                          <input type="date" name="tgl_mulai" required class="form-control" value="<?= $r['tgl_mulai']; ?>">
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label font-weight-bold">Tanggal Selesai</label>
                                          <input type="date" name="tgl_selesai" required class="form-control" value="<?= $r['tgl_selesai']; ?>">
                                        </div>

                                        <div class="mb-3">
                                          <label class="form-label font-weight-bold">Status</label>
                                          <select name="status" class="form-control" required>
                                            <option label="== Pilih Status =="></option>
                                            <option value="Aktif" <?= ($r['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="Dikunci" <?= ($r['status'] == 'Dikunci') ? 'selected' : ''; ?>>Dikunci</option>
                                          </select>
                                        </div>

                                      </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                      <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                    </div>
                                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
                                  </div>
                                </form>
                              </div>
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

    <!-- Modal tambah periode -->
    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Data</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?= base_url() ?>tahapan/save" method="POST" id="form-tambah">
            <?= csrf_field() ?>
            <div class="modal-body">
              <div class="card">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label font-weight-bold">Jenis</label>
                    <select name="jenis" class="form-control" required>
                      <option label="== Pilih Jenis =="></option>
                      <option value="RPJPD">RPJPD</option>
                      <option value="RPJMD">RPJMD</option>
                      <option value="RESNTRA">RESNTRA</option>
                      <option value="RKPD">RKPD</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label font-weight-bold">Tahapan</label>
                    <select name="nama_tahapan" class="form-control" required>
                      <option label="== Pilih Tahapan =="></option>
                      <option value="Rancangan Awal">Rancangan Awal</option>
                      <option value="Rancangan">Rancangan</option>
                      <option value="Musernbang">Musernbang</option>
                      <option value="Rancangan Akhir">Rancangan Akhir</option>
                      <option value="Penetapan">Penetapan</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label font-weight-bold">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" required class="form-control">
                  </div>

                  <div class="mb-3">
                    <label class="form-label font-weight-bold">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" required class="form-control">
                  </div>

                </div>
              </div>
              <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-inverse btn-block" onclick="simpan_data()">Simpan</button>
              </div>
              <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
            </div>
        </div>
        <!-- <div class="modal-footer d-flex justify-content-center"> -->
        </form>
      </div>
    </div>
  </div>
  <!-- modal tambah data end -->

</div>
<!-- modal edit data end -->

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
          url: '<?= site_url('tahapan/delete/') ?>' + id,
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