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
            <div class="col-xl-10">
              <div class="page-header-title">
                <div class="d-inline">
                  <h4>Rencana Strategis (Renstra)</h4>
                  <!-- <span>Tuj</span> -->
                </div>
              </div>
            </div>

            <div class="col-xl-2 float-right">
              <select id="pilihan" onchange="setrpjmd()" class="form-control form-control-inverse text-center">
                <?php
                $ses_rpjmd = session()->get('rpjmd');
                ?>
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
                  <h5>Data Renstra Kota Pekalongan</h5>
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
                          // $jml_tujuan        = $db->table('tb_renstra_tujuan')->where(['kode_opd' => $o['kode_opd']])->get()->getNumRows();
                          if (!empty($ses_rpjmd)) {
                            $jml_tujuan        = $db->table('tb_renstra_tujuan')->join('tb_opd', 'tb_renstra_tujuan.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_tujuan.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_tujuan.id_rpjmd' => $ses_rpjmd, 'tb_opd.kode_opd' => $o['kode_opd']])->get()->getNumRows();
                            $jml_sasaran        = $db->table('tb_renstra_sasaran')->join('tb_opd', 'tb_renstra_sasaran.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_sasaran.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['tb_renstra_sasaran.id_rpjmd' => $ses_rpjmd, 'tb_opd.kode_opd' => $o['kode_opd']])->get()->getNumRows();
                          } else {
                            $jml_tujuan        = $db->table('tb_renstra_tujuan')->join('tb_opd', 'tb_renstra_tujuan.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_tujuan.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_opd.kode_opd' => $o['kode_opd']])->get()->getNumRows();
                            $jml_sasaran        = $db->table('tb_renstra_sasaran')->join('tb_opd', 'tb_renstra_sasaran.kode_opd = tb_opd.kode_opd')->join('tb_rpjmd', 'tb_renstra_sasaran.id_rpjmd = tb_rpjmd.id_rpjmd')->where(['status_rpjmd' => 'Aktif', 'tb_opd.kode_opd' => $o['kode_opd']])->get()->getNumRows();
                          }

                          ?>
                          <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td class="text-center"><?= $o['kode_opd']; ?></td>
                            <td><?= $o['singkatan']; ?></td>
                            <td class="text-center">
                              <?php if (!empty($o['unit'])): ?>
                                <a href="#" class="btn hor-grd btn-grd-inverse btn-sm">
                                  <?= $jml_tujuan; ?> Tujuan
                                </a>
                              <?php else: ?>
                                <a href="<?= base_url() ?>tujuan-renstra/add/<?= $o['kode_opd']; ?>" class="btn hor-grd btn-grd-inverse btn-sm">
                                  <?= $jml_tujuan; ?> Tujuan
                                </a>
                              <?php endif ?>

                            </td>
                            <td class="text-center">
                              <?php if (!empty($o['unit'])): ?>
                                <a href="#" class="btn hor-grd btn-grd-inverse btn-sm">
                                  <?= $jml_sasaran; ?> Sasaran
                                </a>
                              <?php else: ?>
                                <a href="<?= base_url() ?>sasaran-renstra/add/<?= $o['kode_opd']; ?>" class="btn hor-grd btn-grd-inverse btn-sm">
                                  <?= $jml_sasaran; ?> Sasaran
                                </a>
                              <?php endif ?>
                            </td>
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
</script>

<script>
  function setrpjmd() {
    var id = $('#pilihan').val();
    $.ajax({
      url: `renstra/set-rpjmd/` + id,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        location.reload();
      }
    });
  }
</script>

<?= $this->endSection(); ?>