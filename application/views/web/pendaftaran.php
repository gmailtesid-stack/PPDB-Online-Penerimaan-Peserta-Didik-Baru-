<?php
defined('BASEPATH') or exit('No direct script access allowed');
$user = $this->db->get('tbl_user')->row_array();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="admin-themes-lab">
  <meta name="author" content="themes-lab">
  <base href="<?php echo base_url(); ?>" />
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">
  <title>PPDB Online | <?php echo $user['nama_lengkap']; ?></title>
  <link rel="icon" href="assets/images/logo.png" type="image/x-icon" />
  <link href="assets/kitkat/assets/css/style.css" rel="stylesheet">
  <link href="assets/kitkat/assets/css/theme.css" rel="stylesheet">
  <link href="assets/kitkat/assets/css/ui.css" rel="stylesheet">
  <link href="assets/kitkat/assets/css/custom.css" rel="stylesheet">
  <link href="assets/kitkat/assets/plugins/font-awesome-animation/font-awesome-animation.min.css" rel="stylesheet">
  <link href="assets/kitkat/assets/input/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

  <link href="assets/kitkat/assets/plugins/step-form-wizard/css/step-form-wizard.min.css" rel="stylesheet">
  <script src="assets/kitkat/assets/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
</head>

<style>
  #pesan_komentar {
    font-weight: normal;
    color: indianred;
    font-size: 10px;
    margin-bottom: 5px;
  }

  /* --- KODE SUPER UNTUK MEMAKSA BORDER TAMPIL --- */
  
  /* 1. Paksa semua form-control dan input biasa */
  #register .form-control,
  .wizard-validation .form-control,
  .form-group input, 
  .form-group select {
      border: 1px solid #777777 !important;
      background-color: #ffffff !important;
      color: #333333 !important;
      border-radius: 4px !important;
  }

  /* 2. Paksa pembungkus dropdown (Select2 Plugin) yang sering bikin nyaru */
  span.select2-selection.select2-selection--single,
  .select2-container .select2-selection--single,
  .select2-container--default .select2-selection--single {
      border: 1px solid #777777 !important;
      background-color: #ffffff !important;
      height: 38px !important;
      padding-top: 4px !important;
      border-radius: 4px !important;
  }

  /* 3. Paksa teks di dalam dropdown Select2 biar warnanya gelap */
  .select2-container--default .select2-selection--single .select2-selection__rendered,
  .select2-container .select2-selection--single .select2-selection__rendered {
      color: #333333 !important;
      font-weight: bold !important;
  }

  /* 4. Paksa panah dropdown agar tetap terlihat */
  .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px !important;
  }

  /* 5. Matikan efek background warna bawaan template (seperti bg-blue) */
  .bg-blue, .bg-white, .bg-light {
      background-image: none !important;
      background-color: #ffffff !important;
  }

  /* 6. Perjelas Lingkaran Radio Button & Checkbox (Jenis Kelamin, Persetujuan, dll) */
  input[type="radio"], 
  input[type="checkbox"] {
      -webkit-appearance: radio !important;
      -moz-appearance: radio !important;
      appearance: radio !important; 
      width: 17px !important;
      height: 17px !important;
      outline: 1px solid #777777 !important; 
      outline-offset: 1px !important;
      margin-right: 8px !important;
      accent-color: #275555 !important; 
      cursor: pointer;
  }

  div[class^="iradio_"], 
  div[class^="icheckbox_"] {
      border: 1px solid #777777 !important;
      border-radius: 50% !important; 
      background-color: #ffffff !important;
  }

  /* --- KODE UNTUK MEMAKSA NAVIGASI STEP WIZARD KE TENGAH --- */
  .sf-nav-wrap,
  ul.sf-nav,
  .wizard-sea .sf-nav,
  .stepy-header {
      display: flex !important;
      justify-content: center !important;
      width: 100% !important;
      margin: 0 auto !important;
      padding: 0 !important;
  }
  
  ul.sf-nav li {
      float: none !important;
      display: inline-block !important;
  }
  /* -------------------------------------------------------- */
</style>

<body class="fixed-topbar sidebar-hover theme-sltl color-green">
  <section>
    <div class="main-content">
      <div class="topbar" style="background-color: #275555ff; color: #fff;">
        <div class="header-left">
          <div class="col-sm-12">
            <div style="margin-top:-8px;">
              <h2>
                <strong class="text-primary">
                  <a href=""><span style="margin-left:40px;color:#fff;">PPDB Online</span></a>
                </strong>
              </h2>
            </div>
          </div>
        </div>
      </div>
      <div>
        <div class="page-content page-wizard">
          <div class="header" style="margin-top:-20px; text-align: center;">
            <img src="img/logo.png" style="margin-bottom:10px;" width="100"><br>
            <h2 align="center">FORM PENDAFTARAN PPDB ONLINE <strong> <br><?php echo $user['nama_lengkap']; ?></strong></h2>
            <hr style="margin-top:20px;">
          </div>
          <div class="row" style="margin-top:-30px;">
            <div class="col-lg-12">
              <div class="tabs tabs-linetriangle">
                <div class="tab-content">
                  <div class="tab-pane active" id="style">
                    <div class="wizard-div current wizard-sea" id="register">
                      <!-- BAGIAN FORM INI YANG GUA PERBAIKI -->
                      <form role="form" class="wizard wizard-validation" data-style="sky" action="<?php echo base_url('web/pendaftaran'); ?>" enctype="multipart/form-data" method="post">
                        
                        <fieldset>
                          <legend>Ketentuan</legend>
                          <div class="col-md-2"></div>
                          <div class="col-md-8">
                            <?php $this->load->view('web/step/1'); ?>
                            <div class="col-md-12">
                              <span class="text-primary" style="font-size:18px;color:#222;"><strong>Apakah Anda setuju dengan ketentuan PPDB Online diatas?</strong></span>
                              <div class="form-group" style="padding-bottom:30px;">
                                <div class="radio bg-success" style="padding-top:10px;padding-bottom:10px;border-radius:3px;color:#222;">
                                  <label>
                                    <input type="radio" value="cek" name="cek" data-parsley-group="block0" data-radio="iradio_square-blue" data-parsley-errors-container='div[id="condition-ck"]' required> <b>Ya, saya menyetujui ketentuan PPDB Online!</b>
                                  </label>
                                  <div id="condition-ck" style=" background:#FFBABA; color: #D8000C; width:auto; padding-left:10px; font-size: 10px;"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-2"></div>
                        </fieldset>

                        <fieldset>
                          <legend>Data Siswa</legend>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <?php $this->load->view('web/step/2'); ?>
                            </div>
                          </div>
                          <div class="col-lg-12"></div>
                        </fieldset>

                        <fieldset>
                          <legend>Data Alamat</legend>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <?php $this->load->view('web/step/3'); ?>
                            </div>
                          </div>
                          <div class="col-lg-12"></div>
                        </fieldset>

                        <fieldset>
                          <legend>Data Orang Tua</legend>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <?php $this->load->view('web/step/4'); ?>
                            </div>
                          </div>
                        </fieldset>

                        <fieldset>
                          <legend>Data Sekolah</legend>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <?php $this->load->view('web/step/5'); ?>
                            </div>
                          </div>
                        </fieldset>

                        <fieldset>
                          <legend>Upload Berkas</legend>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <div class="alert alert-info"><b>Format File:</b> JPG, JPEG, PNG. Maksimal ukuran 5MB per file.</div>
                              
                              <div class="form-group">
                                <label>Foto Kartu Keluarga (KK) <span class="text-danger">*</span></label>
                                <input type="file" name="foto_kk" class="form-control" accept="image/*" required>
                              </div>
                              <div class="form-group">
                                <label>Foto KTP Orang Tua / Wali <span class="text-danger">*</span></label>
                                <input type="file" name="foto_ktp" class="form-control" accept="image/*" required>
                              </div>
                              <div class="form-group">
                                <label>Foto Surat Keterangan Lulus (SKL) <span class="text-danger">*</span></label>
                                <input type="file" name="foto_skl" class="form-control" accept="image/*" required>
                              </div>
                              <div class="form-group">
                                <label>Foto Ijazah (Jika ada)</label>
                                <input type="file" name="foto_ijazah" class="form-control" accept="image/*">
                              </div>
                              <div class="form-group">
                                <label>Pas Foto Terbaru <span class="text-danger">*</span></label>
                                <input type="file" name="pas_foto" class="form-control" accept="image/*" required>
                              </div>

                            </div>
                          </div>
                        </fieldset>

                        <fieldset>
                          <legend>Konfirmasi</legend>
                          <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                              <div class="panel">
                                <div class="panel-heading" style="background: #275555ff; color: honeydew;">
                                  <h2 align="center" style="margin-top: 10px;">KONFIRMASI<br><b>DATA CALON SISWA</b> </h2>
                                </div>
                                <div class="panel-body">
                                  <span style="font-size:15px">
                                    <p align="center">Proses pendaftaran PPDB Online <?php echo $user['nama_lengkap']; ?> hampir selesai. <br>Silakan periksa kembali data-data yang sudah anda masukkan.</p><br><br>
                                    <div class="col-md-12">
                                      <span class="text-primary" style="font-size:18px;"><strong>Apakah data calon siswa sudah sesuai?</strong></span>
                                      <div class="form-group">
                                        <div class="radio bg-success p-10" style="border-radius:3px;">
                                          <label>
                                            <input type="radio" value="cekx" name="cekx" data-parsley-group="blockx" data-radio="iradio_square-blue" data-parsley-errors-container='div[id="condition-cx"]' required>
                                            <b>Ya, data sudah sesuai!</b>
                                          </label>
                                          <div class="faa-flash animated" id="condition-cx" style=" background:#FFBABA; color: #D8000C; width:auto; padding-left:10px; font-size: 10px;"></div>
                                        </div>
                                      </div>
                                  </span>
                                </div>
                              </div>
                        </fieldset>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <div class="footer">
              <div class="copyright">
                <p class="pull-left sm-pull-reset">
                  <span>Copyright &copy; <a href="#" target="_blank"><?php echo $user['nama_lengkap']; ?></a> <?php echo date('Y'); ?></span>
                </p>
                <p class="pull-right sm-pull-reset">
                  <span><a href="" class="m-r-10"><i class="fa fa-home"></i> Beranda </a> | <a href="#" class="m-l-10 m-r-10" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-legal"></i> Ketentuan & Syarat PPDB</a></span>
                </p>
              </div>
            </div>
          </div>
          </div>
        </section>
  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="margin-top:5px;">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <?php $this->load->view('web/step/1'); ?>
        </div>
      </div>
    </div>
  </div>

  <a href="#" class="scrollup"><i class="fa fa-angle-up"></i></a>
  <script src="assets/kitkat/assets/plugins/jquery/jquery-1.11.1.min.js"></script>
  <script src="assets/kitkat/assets/plugins/jquery/jquery-migrate-1.2.1.min.js"></script>
  <script src="assets/kitkat/assets/plugins/jquery-ui/jquery-ui-1.11.2.min.js"></script>
  <script src="assets/kitkat/assets/plugins/gsap/main-gsap.min.js"></script>
  <script src="assets/kitkat/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/kitkat/assets/plugins/jquery-cookies/jquery.cookies.min.js"></script> <script src="assets/kitkat/assets/plugins/jquery-block-ui/jquery.blockUI.min.js"></script> <script src="assets/kitkat/assets/plugins/translate/jqueryTranslator.min.js"></script> <script src="assets/kitkat/assets/plugins/bootbox/bootbox.min.js"></script> <script src="assets/kitkat/assets/plugins/mcustom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script> <script src="assets/kitkat/assets/plugins/bootstrap-dropdown/bootstrap-hover-dropdown.min.js"></script> <script src="assets/kitkat/assets/plugins/charts-sparkline/sparkline.min.js"></script> <script src="assets/kitkat/assets/plugins/retina/retina.min.js"></script> <script src="assets/kitkat/assets/plugins/select2/select2.min.js"></script> <script src="assets/kitkat/assets/plugins/icheck/icheck.min.js"></script> <script src="assets/kitkat/assets/plugins/backstretch/backstretch.min.js"></script> <script src="assets/kitkat/assets/plugins/bootstrap-progressbar/bootstrap-progressbar.min.js"></script> <script src="assets/kitkat/assets/plugins/charts-chartjs/Chart.min.js"></script>
  <script src="assets/kitkat/assets/plugins/timepicker/jquery-ui-timepicker-addon.min.js"></script>
  <script src="assets/kitkat/assets/plugins/multidatepicker/multidatespicker.min.js"></script>
  <script src="assets/kitkat/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script src="assets/kitkat/assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js"></script>
  <script src="assets/kitkat/assets/js/sidebar_hover.js"></script> <script src="assets/kitkat/assets/js/application.js"></script> <script src="assets/kitkat/assets/js/plugins.js"></script> <script src="assets/kitkat/assets/js/widgets/notes.js"></script> <script src="assets/kitkat/assets/js/quickview.js"></script> <script src="assets/kitkat/assets/js/pages/search.js"></script> <script src="assets/kitkat/js/cust.js"></script> <script src="assets/kitkat/assets/plugins/step-form-wizard/plugins/parsley/parsley.min.js"></script> <script src="assets/kitkat/assets/plugins/step-form-wizard/js/step-form-wizard.js"></script> <script src="assets/kitkat/assets/js/pages/form_wizard.js"></script>
  <script src="assets/kitkat/assets/input/js/fileinput.js" type="text/javascript"></script>
  
  <!-- SCRIPT FILEINPUT INI JUGA GUA PERBAIKI -->
  <script>
    $("input[type='file']").fileinput({
      allowedFileExtensions: ['jpg', 'jpeg', 'png', 'pdf'],
      showPreview: false,
      showUpload: false,
      browseClass: "btn btn-primary",
      maxFileSize: 5120,
      removeLabel: "Hapus",
      removeClass: "btn btn-danger",
      removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> "
    });
  </script>

  <script type="text/javascript">
    function hanyaAngka(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
      return true;
    }
  </script>
  </body>

</html> 