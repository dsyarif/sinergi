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
                    <table id="datatable" class="table table-striped table-bordered nowrap">
                      <thead>
                        <tr style="text-align: center; background-color: #354055; color: white;" class="dt-center">
                          <th rowspan="2" class="text-center" style="width: 5%; vertical-align: middle;">Kode Bidang/Program</th>
                          <th rowspan="2" class="text-center" style="width: 5%; vertical-align: middle;">Nama Bidang / Program / Indikator Program</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($program as $p):
                          $is_prog    = $db->table('tb_renstra_is_prog')->where(['kode_opd' => $kode_opd])->get()->getResultArray();
                          // dd($is_prog);
                        ?>
                          <tr style="background-color: #01A9AC; color: white;">
                            <td><?= $p['kode_bidang']; ?></td>
                            <td><?= $p['nama_bidang']; ?></td>
                          </tr>
                          <?php foreach ($is_prog as $i): ?>
                            <?php if ($p['kode_bidang'] == substr($i['kode_program'], 0, -3)):
                              $nama_bidang = $db->table('tb_master')->where('kode_program', $i['kode_program'])->get()->getRowArray();
                            ?>

                              <tr>
                                <td><?= $i['kode_program']; ?></td>
                                <td><?= $nama_bidang['nama_program']; ?></td>
                              </tr>
                            <?php endif ?>
                          <?php endforeach ?>
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

<!-- Modal tambah program -->
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel" id="modal-title">Tambah Data</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url() ?>program-renstra/save" method="POST" id="form-tambah">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <input type="hidden" name="kode_opd" value="<?= $opd['kode_opd']; ?>">
              <div class="mb-3">
                <label class="form-label font-weight-bold">Kode Program</label>
                <input type="text" name="kode_program" class="form-control" required placeholder="Input Kode Program">
                <span class="help-block text-danger"></span>
              </div>

              <div class="mb-3">
                <label class="form-label font-weight-bold">Uraian Program</label>
                <input type="text" name="uraian_program" class="form-control" required placeholder="Input Uraian Program">
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
          url: '<?= site_url('program-renstra/delete/') ?>' + id,
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
      html: "Indikator Program </br><strong>" + uraian + "</strong>",
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