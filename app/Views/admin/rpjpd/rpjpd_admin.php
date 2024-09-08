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
                  <h4>Periode RPJPD</h4>
                  <span>Rencana Pembangunan Jangka Panjang Daerah</span>
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
                  <h5>Periode RPJPD Kota Pekalongan</h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center;" class="dt-center">
                          <th class="text-center">No</th>
                          <th class="text-center">Tahun Awal</th>
                          <th class="text-center">Tahun Akhir</th>
                          <th class="text-center">Status</th>
                          <th style="text-align: center; width: 10%;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($rpjpd as $r): ?>
                          <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $r['th_awal_rpjpd']; ?></td>
                            <td class="text-center"><?= $r['th_akhir_rpjpd']; ?></td>
                            <td class="text-center"><?= $r['status_periode']; ?></td>
                            <td class="d-flex justify-content-center">
                              <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit<?= $r['id_rpjpd']; ?>"><i class="fas fa-edit"></i></a>
                              <a class="text-danger mb-1" onclick="hapusData('<?= $r['id_rpjpd']; ?>')"><i class="fas fa-trash"></i></a>
                            </td>

                          </tr>

                          <!-- Modal edit periode -->
                          <div class="modal fade" id="modaledit<?= $r['id_rpjpd']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data</h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="<?= base_url() ?>rpjpd/update" method="POST" id="form-edit">
                                  <?= csrf_field() ?>
                                  <input type="hidden" name="_method" value="PUT">
                                  <input type="hidden" name="id_rpjpd" id="id_rpjpd" value="<?= $r['id_rpjpd']; ?>">
                                  <div class="modal-body">
                                    <div class="card">
                                      <div class="card-body">
                                        <div class="mb-3">
                                          <label class="form-label font-weight-bold">Tahun Awal RPJPD</label>
                                          <input type="number" autofocus min="2000" max="9999" id="th_awal_rpjpdd" value="<?= $r['th_awal_rpjpd']; ?>" name="th_awal_rpjpdd" class="form-control tahun-picker" placeholder="Contoh : 2021">
                                          <span class="help-block text-danger"></span>
                                        </div>
                                        <div>
                                          <label class="form-label font-weight-bold">Status</label>
                                          <select name="status_periode" id="status_periode" class="form-control">
                                            <option label="== Pilih Status =="></option>
                                            <option value="Aktif" <?= ($r['status_periode'] == "Aktif") ? 'selected' : ''; ?>>Aktif</option>
                                            <option value="Tidak Aktif" <?= ($r['status_periode'] == "Tidak Aktif") ? 'selected' : ''; ?>>Tidak Aktif</option>
                                          </select>
                                          <span class="help-block text-danger"></span>
                                        </div>

                                      </div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                      <button type="submit" class="btn btn-inverse btn-block">Update</button>
                                    </div>
                                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
                                  </div>
                              </div>
                              <!-- <div class="modal-footer d-flex justify-content-center"> -->
                              </form>
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
          <form action="<?= base_url() ?>rpjpd/save" method="POST" id="form-tambah">
            <?= csrf_field() ?>
            <div class="modal-body">
              <div class="card">
                <div class="card-body">
                  <div>
                    <label class="form-label font-weight-bold">Tahun Awal RPJPD</label>
                    <input type="number" autofocus min="2000" max="9999" id="th_awal_rpjpd" name="th_awal_rpjpd" class="form-control tahun-picker" required placeholder="Contoh : 2021">
                    <span class="help-block text-danger"></span>
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
          url: '<?= site_url('rpjpd/delete/') ?>' + id,
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