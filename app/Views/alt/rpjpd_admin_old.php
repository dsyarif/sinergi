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
            <!-- <div class="col-lg-4">
              <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                  <li class="breadcrumb-item">
                    <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                  </li>
                  <li class="breadcrumb-item"><a href="#!">Bootstrap Table</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#!">Basic Initialization</a>
                  </li>
                </ul>
              </div>
            </div> -->
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
                    <table id="server-side" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center;">
                          <th>No</th>
                          <th>Tahun Awal</th>
                          <th>Tahun Akhir</th>
                          <th>Status</th>
                          <th style="text-align: center; width: 10%;"><button class="btn hor-grd btn-sm btn-grd-inverse btn-out" onclick="tampil_modal()"> <i class="fa-solid fa-plus"></i> Tambah Data</button></th>
                        </tr>
                      </thead>

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
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="#" id="form-tambah">
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

  <!-- Modal edit periode -->
  <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Edit Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="#" id="form-edit">
          <input type="hidden" name="id_rpjpd" id="id_rpjpd">
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="mb-3">
                  <label class="form-label font-weight-bold">Tahun Awal RPJPD</label>
                  <input type="number" autofocus min="2000" max="9999" id="th_awal_rpjpdd" name="th_awal_rpjpdd" class="form-control tahun-picker" required placeholder="Contoh : 2021">
                  <span class="help-block text-danger"></span>
                </div>
                <div>
                  <label class="form-label font-weight-bold">Status</label>
                  <select name="status_periode" id="status_periode" class="form-control">
                    <option label="== Pilih Status =="></option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                  <span class="help-block text-danger"></span>
                </div>

              </div>
            </div>
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-inverse btn-block" onclick="update_data()">Simpan</button>
            </div>
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Bata</button> -->
          </div>
      </div>
      <!-- <div class="modal-footer d-flex justify-content-center"> -->
      </form>
    </div>
  </div>
</div>
<!-- modal edit data end -->

<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.0.min.js"></script> -->
<script>
  var tabel;
  var method;
  var url;
  $(document).ready(function() {
    // Server side processing Data-table
    $tabel = $('#server-side').DataTable({
      "pageLength": 10,
      ajax: {
        "url": "<?= site_url('rpjpd/list-data') ?>",
        "type": "POST"
      },
      "processing": true,
      "serverSide": true,
      // columns: [{
      //     data: null,
      //     render: function(data, type, row, meta) {
      //       return meta.row + meta.settings._iDisplayStart + 1;
      //     }
      //   },
      //   {
      //     data: 'th_awal_rpjpd',
      //     orderable: true
      //   },
      //   {
      //     data: 'th_akhir_rpjpd'
      //   },
      // ],
    });

  });

  function reload() {
    $tabel.ajax.reload(null, false);
  }

  function tampil_modal() {
    method = 'save';
    $("#form-tambah")[0].reset();
    $('#modal-tambah').modal('show');
    $('#modal-title').text('Tambah Data');
  }

  function simpan_data() {
    url = '<?= site_url('rpjpd/save') ?>';
    // var coba = new FormData($('#form-tambah')[0])
    var tahun = $("#th_awal_rpjpd").val();
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'JSON',
      data: {
        "th_awal_rpjpd": tahun,
      },
      // data: new FormData($('#form-tambah')[0]),
      success: function(response) {
        $('#modal-tambah').modal('hide');
        $("#form-tambah")[0].reset();
        Swal.fire({
          position: "center",
          icon: "success",
          iconColor: '#404E67',
          title: "Selamat",
          text: response.message,
          showConfirmButton: false,
          timer: 2000
        })
        reload()
      },
      error: function(jqXHR, textStatus, errorThrow) {
        alert('Gagal Simpan Data, Silahkan Coba Lagi');
      }
    });
  }

  function editData(id) {
    method = 'update';
    $.ajax({
      url: '<?= site_url('rpjpd/edit/') ?>' + id,
      type: 'GET',
      dataType: 'JSON',
      success: function(data) {
        $('[name="id_rpjpd"]').val(data.id_rpjpd);
        $('[name="th_awal_rpjpdd"]').val(data.th_awal_rpjpd);
        $('[name="status_periode"]').val(data.status_periode);
        $('#modal-edit').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrow) {
        alert('Gagal');
      }
    });
  }


  function update_data() {
    url = '<?= site_url('rpjpd/update') ?>';
    var id = $("#id_rpjpd").val();
    var tahun = $("#th_awal_rpjpdd").val();
    var tahun = $("#status_periode").val();
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'JSON',
      data: {
        "id_rpjpd": id,
        "th_awal_rpjpdd": tahun,
        "status_periode": status_periode,
      },
      // data: new FormData($('#form-tambah')[0]),
      success: function(response) {
        $('#modal-edit').modal('hide');
        $("#form-edit")[0].reset();
        Swal.fire({
          position: "center",
          icon: "success",
          iconColor: '#404E67',
          title: "Selamat",
          text: response.message,
          showConfirmButton: false,
          timer: 2000
        })
        reload()
      },
      error: function(jqXHR, textStatus, errorThrow) {
        alert('Gagal Simpan Data, Silahkan Coba Lagi');
      }
    });
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
            });
            reload()
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