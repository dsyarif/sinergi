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
                  <h4>Rencana Strategis (Renstra)</h4>
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
                  <h5>Data Renstra Kota Pekalongan</h5>
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
                          <th class="text-center">Tujuan</th>
                          <th class="text-center">Sasaran</th>
                          <th class="text-center">Program</th>
                          <th class="text-center">Kegiatan</th>
                          <th class="text-center">Sub Kegiatan</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no = 1;
                        foreach ($opd as $o): ?>
                          <?php
                          $db                = \Config\Database::connect();
                          $jml_tujuan        = $db->table('tb_tujuan_renstra')->where(['kode_opd' => $o['kode_opd']])->get()->getNumRows();
                          ?>
                          <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $o['kode_opd']; ?></td>
                            <td><?= $o['singkatan']; ?></td>
                            <td class="text-center">
                              <a href="<?= base_url() ?>tujuan-renstra/add/<?= $o['kode_opd']; ?>" class="btn hor-grd btn-grd-inverse btn-sm">
                                <?= $jml_tujuan; ?> Tujuan
                              </a>
                            </td>
                            <td class="text-center"><button class="btn hor-grd btn-grd-inverse btn-sm">1 Sasaran</button></td>
                            <td class="text-center"><button class="btn hor-grd btn-grd-inverse btn-sm">Program</button></td>
                            <td class="text-center"><button class="btn hor-grd btn-grd-inverse btn-sm">Kegiatan</button></td>
                            <td class="text-center"><button class="btn hor-grd btn-grd-inverse btn-sm">Sub Kegiatan</button></td>
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
<script script>
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
</script>

<?= $this->endSection(); ?>