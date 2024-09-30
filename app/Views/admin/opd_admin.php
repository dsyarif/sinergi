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
                  <h4>OPD</h4>
                  <span>Organisasi Perangkat Daerah</span>
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
                  <h5>OPD Kota Pekalongan</h5>
                  <!-- Button trigger modal -->
                </div>
                <div class="card-block">
                  <div class="dt-responsive table-responsive">
                    <table id="datatable" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center;" class="dt-center">
                          <th class="text-center">No</th>
                          <th class="text-center">Kode OPD</th>
                          <th class="text-center">Nama OPD</th>
                          <th class="text-center">Singkatan</th>
                          <th class="text-center">Keterangan</th>
                          <th style="text-align: center; width: 10%;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($opd as $o): ?>
                          <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $o['kode_opd']; ?></td>
                            <td><?= $o['nama_opd']; ?></td>
                            <td><?= $o['singkatan']; ?></td>
                            <td class="text-center"><?= $o['ket']; ?></td>
                            <td class="d-flex justify-content-center">
                              <a class="text-warning mb-1 mr-3" data-bs-toggle="modal" data-bs-target="#modaledit<?= $o['kode_opd']; ?>"><i class="fas fa-edit"></i></a>
                              <a class="text-danger mb-1" onclick="hapusData('<?= $o['kode_opd']; ?>')"><i class="fas fa-trash"></i></a>
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
          url: '<?= site_url('rpjmd/delete/') ?>' + id,
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