<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $title; ?> - Perencanaan Kota Pekalongan </title>
  <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="#">
  <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
  <meta name="author" content="#">
  <!-- Favicon icon -->
  <link rel="icon" href="<?= base_url() ?>assets\images\logo0.png" type="image/x-icon">
  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
  <!-- Required Fremwork -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bower_components\bootstrap\css\bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>bower_components\sweetalert\css\sweetalert.css">
  <!-- feather Awesome -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets\icon\feather\css\feather.css">

  <!-- font awesome -->
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">

  <!-- Data Table Css -->
  <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.2/b-3.1.0/b-html5-3.1.0/fc-5.0.1/fh-4.0.1/r-3.0.2/datatables.min.css" rel="stylesheet">

  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets\css\style.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets\css\jquery.mCustomScrollbar.css">

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" />
  <style>
    body {
      font-family: poppins;
    }
  </style>
  <script type="text/javascript" src="<?= base_url() ?>bower_components\jquery\js\jquery.min.js"></script>
</head>

<body>
  <!-- Pre-loader start -->
  <div class="theme-loader">
    <div class="ball-scale">
      <div class='contain'>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
        <div class="ring">
          <div class="frame"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- Pre-loader end -->

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">

      <nav class="navbar header-navbar pcoded-header">
        <div class="navbar-wrapper">

          <div class="navbar-logo">
            <a class="mobile-menu" id="mobile-collapse" href="#!">
              <i class="feather icon-menu"></i>
            </a>
            <a href="index-1.htm">
              <img class="img-fluid" src="<?= base_url() ?>assets\images\logo5.png" style="height: 90px;" alt="Theme-Logo">
            </a>
            <a class="mobile-options">
              <i class="feather icon-more-horizontal"></i>
            </a>
          </div>

          <div class="navbar-container container-fluid">
            <ul class="nav-left">
              <li class="header-search">
                <div class="main-search morphsearch-search">
                  <div class="input-group">
                    <span class="input-group-addon search-close"><i class="feather icon-x"></i></span>
                    <input type="text" class="form-control">
                    <span class="input-group-addon search-btn"><i class="feather icon-search"></i></span>
                  </div>
                </div>
              </li>
              <li>
                <a href="#!" onclick="javascript:toggleFullScreen()">
                  <i class="feather icon-maximize full-screen"></i>
                </a>
              </li>
            </ul>
            <ul class="nav-right">
              <li class="header-notification">
                <div class="dropdown-primary dropdown">
                  <div class="dropdown-toggle" data-toggle="dropdown">
                    <i class="feather icon-bell"></i>
                    <span class="badge bg-c-pink">5</span>
                  </div>
                  <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <li>
                      <h6>Notifications</h6>
                      <label class="label label-danger">New</label>
                    </li>
                    <li>
                      <div class="media">
                        <img class="d-flex align-self-center img-radius" src="<?= base_url() ?>assets\images\avatar-4.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                          <h5 class="notification-user">John Doe</h5>
                          <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                          <span class="notification-time">30 minutes ago</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media">
                        <img class="d-flex align-self-center img-radius" src="<?= base_url() ?>assets\images\avatar-3.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                          <h5 class="notification-user">Joseph William</h5>
                          <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                          <span class="notification-time">30 minutes ago</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media">
                        <img class="d-flex align-self-center img-radius" src="<?= base_url() ?>assets\images\avatar-4.jpg" alt="Generic placeholder image">
                        <div class="media-body">
                          <h5 class="notification-user">Sara Soudein</h5>
                          <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                          <span class="notification-time">30 minutes ago</span>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </li>
              <!-- <li class="header-notification">
                <div class="dropdown-primary dropdown">
                  <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                    <i class="feather icon-message-square"></i>
                    <span class="badge bg-c-green">3</span>
                  </div>
                </div>
              </li> -->
              <li class="user-profile header-notification">
                <div class="dropdown-primary dropdown">
                  <div class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= base_url() ?>assets\images\avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                    <span>John Doe</span>
                    <i class="feather icon-chevron-down"></i>
                  </div>
                  <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <li>
                      <a href="#!">
                        <i class="feather icon-settings"></i> Settings
                      </a>
                    </li>
                    <li>
                      <a href="user-profile.htm">
                        <i class="feather icon-user"></i> Profile
                      </a>
                    </li>
                    <li>
                      <a href="auth-normal-sign-in.htm">
                        <i class="feather icon-log-out"></i> Logout
                      </a>
                    </li>
                  </ul>

                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
          <nav class="pcoded-navbar">
            <div class="pcoded-inner-navbar main-menu">
              <div class="pcoded-navigatio-lavel">Navigation</div>
              <ul class="pcoded-item pcoded-left-item">
                <li class="">
                  <a href="<?= base_url() ?>">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Dashboard</span>
                  </a>
                </li>
                <li class="">
                  <a href="navbar-light.htm">
                    <span class="pcoded-micon"><i class="feather icon-users"></i></span>
                    <span class="pcoded-mtext">Pengguna</span>
                  </a>
                </li>
              </ul>
              <div class="pcoded-navigatio-lavel">RPJPD</div>
              <ul class="pcoded-item pcoded-left-item">
                <li class="">
                  <a href="<?= base_url() ?>rpjpd">
                    <span class="pcoded-micon"><i class="feather icon-calendar"></i></span>
                    <span class="pcoded-mtext">Periode</span>
                  </a>
                </li>
                <li class="pcoded-hasmenu">
                  <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                    <span class="pcoded-mtext">Tahapan</span>
                  </a>
                  <ul class="pcoded-submenu">
                    <li class="">
                      <a href="<?= base_url() ?>">
                        <span class="pcoded-mtext">Rancangan Awal</span>
                      </a>
                    </li>
                    <li class="">
                      <a href="<?= base_url() ?>">
                        <span class="pcoded-mtext">Rancangan</span>
                      </a>
                    </li>
                    <li class="">
                      <a href="<?= base_url() ?>">
                        <span class="pcoded-mtext">Musrenbang</span>
                      </a>
                    </li>
                    <li class="">
                      <a href="<?= base_url() ?>">
                        <span class="pcoded-mtext">Rancangan Akhir</span>
                      </a>
                    </li>
                    <li class="">
                      <a href="<?= base_url() ?>">
                        <span class="pcoded-mtext">Final</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="">
                  <a href="navbar-light.htm">
                    <span class="pcoded-micon"><i class="feather icon-menu"></i></span>
                    <span class="pcoded-mtext">Kegiatan</span>
                  </a>
                </li>
              </ul>

            </div>
          </nav>
          <?= $this->renderSection('content'); ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Required Jquery -->
  <!-- <script data-cfasync="false" src="..\..\..\cdn-cgi\scripts\5c5dd728\cloudflare-static\email-decode.min.js"></script> -->
  <script type="text/javascript" src="<?= base_url() ?>bower_components\jquery-ui\js\jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>bower_components\popper.js\js\popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>bower_components\bootstrap\js\bootstrap.min.js"></script>


  <script src="<?= base_url() ?>assets\js\jquery.mCustomScrollbar.concat.min.js"></script>
  <!-- <script type="text/javascript" src="<?= base_url() ?>assets\js\SmoothScroll.js"></script> -->
  <script src="<?= base_url() ?>assets\js\pcoded.min.js"></script>

  <!-- data-table js -->

  <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.2/b-3.1.0/b-html5-3.1.0/fc-5.0.1/fh-4.0.1/r-3.0.2/datatables.min.js"></script>


  <!-- custom js -->
  <script src="<?= base_url() ?>assets\js\vartical-layout.min.js"></script>
  <!-- <script type="text/javascript" src="<?= base_url() ?>assets\pages\dashboard\custom-dashboard.js"></script> -->
  <script type="text/javascript" src="<?= base_url() ?>assets\js\script.min.js"></script>

  <!-- swetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- year-picker -->
  <script>
    $(function() {
      $('.tahun-picker').datepicker({
        yearRange: "c-100:c+5",
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        closeText: 'Select',
        currentText: 'This year',
        onClose: function(dateText, inst) {
          var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
          $(this).val($.datepicker.formatDate("yy", new Date(year, 0, 1)));
        },
        beforeShow: function(input, inst) {
          if ($(this).val() != '') {
            var tmpyear = $(this).val();
            $(this).datepicker('option', 'defaultDate', new Date(tmpyear, 0, 1));
          }
        }
      }).focus(function() {
        $(".ui-datepicker-month").hide();
        $(".ui-datepicker-calendar").hide();
        $(".ui-datepicker-current").hide();
        /*$(".ui-datepicker-close").hide();*/
        $(".ui-datepicker-prev").hide();
        $(".ui-datepicker-next").hide();
        $("#ui-datepicker-div").position({
          my: "left top",
          at: "left bottom",
          of: $(this)
        });
      }).attr("readonly", false);
    });
  </script>

  <script>
    $(function() {
      <?php if (session()->has("success")) { ?>
        Swal.fire({
          icon: 'success',
          iconColor: '#353c4e',
          title: 'Selamat!',
          // confirmButtonColor: "#353c4e",
          showConfirmButton: false,
          timer: 2000,
          text: '<?= session("success") ?>'
        })
      <?php } ?>
      <?php if (session()->has("warning")) { ?>
        Swal.fire({
          iconColor: '#353c4e',
          icon: 'warning',
          title: 'Peringatan!',
          confirmButtonColor: "#353c4e",
          text: '<?= session("warning") ?>'
        })
      <?php } ?>
      <?php if (session()->has("danger")) { ?>
        Swal.fire({
          icon: 'error',
          iconColor: '#353c4e',
          title: 'Mohon Maaf!',
          confirmButtonColor: "#353c4e",
          text: '<?= session("danger") ?>'
        })
      <?php } ?>
    });
  </script>
</body>

</html>