<?php
date_default_timezone_set('Asia/Jakarta');
$cek    = $user;
$nama   = $cek->nama_lengkap;
$email  = '';

$level  = $cek->username;

$menu       = strtolower($this->uri->segment(1) ?? '');
$sub_menu = strtolower($this->uri->segment(2) ?? '');
$sub_menu3 = strtolower($this->uri->segment(3) ?? '');
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo base_url(); ?>" />

    <title><?php echo $judul_web; ?> - PPDB Online</title>
    <link rel="icon" type="image/png" href="img/logo.png">

    <link href="assets/panel/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
    <link href="assets/panel/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="assets/panel/css/core.css" rel="stylesheet" type="text/css">
    <link href="assets/panel/css/components.css" rel="stylesheet" type="text/css">
    <link href="assets/panel/css/colors.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="assets/panel/js/plugins/loaders/pace.min.js"></script>
    <script type="text/javascript" src="assets/panel/js/core/libraries/jquery.min.js"></script>
    <script type="text/javascript" src="assets/panel/js/core/libraries/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/panel/js/plugins/loaders/blockui.min.js"></script>
    <?php
    if ($sub_menu == "" or $sub_menu == "profile" or $sub_menu == "ubah_pass" or $menu == "laporan" or $sub_menu == "statistik") { ?>
        <script type="text/javascript" src="assets/panel/js/plugins/visualization/d3/d3.min.js"></script>
        <script type="text/javascript" src="assets/panel/js/plugins/visualization/d3/d3_tooltip.js"></script>
        <script type="text/javascript" src="assets/panel/js/plugins/forms/styling/switchery.min.js"></script>
        <script type="text/javascript" src="assets/panel/js/plugins/forms/styling/uniform.min.js"></script>
        <script type="text/javascript" src="assets/panel/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
        <script type="text/javascript" src="assets/panel/js/plugins/ui/moment/moment.min.js"></script>
        <script type="text/javascript" src="assets/panel/js/plugins/pickers/daterangepicker.js"></script>

        <script type="text/javascript" src="assets/panel/js/core/app.js"></script>
        <?php
    } ?>

    <?php
    if ($sub_menu == "verifikasi" or $sub_menu == "set_pengumuman") { ?>
        <script type="text/javascript" src="assets/panel/js/plugins/tables/datatables/datatables.min.js"></script>
        <script type="text/javascript" src="assets/panel/js/core/app.js"></script>
        <script type="text/javascript" src="assets/panel/js/pages/datatables_basic.js"></script>
        <?php
    } ?>

    <script src="assets/panel/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="assets/panel/css/sweetalert.css">
    <script type="text/javascript" src="assets/panel/js/sweetalert.min.js"></script>
</head>

<body class="navbar-bottom">

    <div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="panel_admin/">PPDB <label class="label label-primary">Online</label></a>
            <ul class="nav navbar-nav visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <img src="img/logo.png" alt="foto">
                        <span><?php echo ucwords($nama); ?></span>
                        <i class="caret"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="panel_admin/profile"><i class="icon-user-plus"></i> Profile</a></li>
                        <li><a href="panel_admin/ubah_pass"><i class="icon-key"></i> Ubah Password</a></li>
                        <li class="divider"></li>
                        <li><a href="panel_admin/logout"><i class="icon-switch2"></i> Keluar</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="page-container">

        <div class="page-content">

            <div class="sidebar sidebar-main sidebar-default">
                <div class="sidebar-content">
                    <div class="panel panel-success" style="margin-bottom: 0;">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="glyphicon glyphicon-list"></i>
                            </h3>
                        </div>
                    </div>
                    <div class="sidebar-category sidebar-category-visible">
                        <div class="category-title h6">
                            <span><b>MENU DASHBOARD</b></span>
                            <ul class="icons-list">
                                <li><a href="#" data-action="collapse"></a></li>
                            </ul>
                        </div>
                        <div class="category-content sidebar-user">
                            <div class="media">
                                <a href="panel_admin/profile" class="media-left"><img src="img/logo.png" class="img-flat img-sm" alt="foto"></a>
                                <div class="media-body">
                                    <div class="text-size-mini text-muted">
                                        <i class="icon-pin text-size-small"></i> &nbsp;<?php echo $level; ?>
                                    </div>
                                    <span class="media-heading text-semibold"><?php echo ucwords($nama); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="category-content no-padding">
                            <ul class="navigation navigation-main navigation-accordion">

                                <li class="navigation-header"><span>Utama</span> <i class="icon-menu" title="Main pages"></i></li>
                                <li class="<?php if ($menu == 'panel_admin' and $sub_menu == '') {
                                                echo 'active';
                                            } ?>"><a href="panel_admin"><i class="icon-home4"></i> <span><b>HOME</b></span></a></li>
                                <li class="<?php if ($menu == 'panel_admin' and $sub_menu == 'verifikasi' or $sub_menu == 'edit_materi') {
                                                echo 'active';
                                            } ?>"><a href="panel_admin/verifikasi"><i class="icon-file-check"></i> <span><b>VERIFIKASI</b></span></a></li>

                                <li class="<?php if ($menu == 'panel_admin' and $sub_menu == 'set_pengumuman') {
                                                echo 'active';
                                            } ?>"><a href="panel_admin/set_pengumuman"><i class="icon-display4"></i> <span><b>KELULUSAN</b></span></a></li>
                                <li class="<?php if ($menu == 'panel_admin' and $sub_menu == 'export') {
                                                echo 'active';
                                            } ?>"><a href="panel_admin/export"><i class="icon-file-excel"></i> <span><b>EXPORT DATA</b></span></a></li>


                                <li class="navigation-header"><span>Lainnya</span> <i class="icon-menu" title="Data visualization"></i></li>
                                <li>
                                    <a href="#"><i class="icon-cog3"></i> <span><b>PENGATURAN</b></span></a>
                                    <ul>
                                        <li class="<?php if ($sub_menu == 'profile') {
                                                        echo 'active';
                                                    } ?>"><a href="panel_admin/profile"><i class="icon-user"></i><b>PROFIL</b></a></li>
                                        <li class="<?php if ($sub_menu == 'ubah_pass') {
                                                        echo 'active';
                                                    } ?>"><a href="panel_admin/ubah_pass"><i class="icon-lock"></i><b>UBAH PASSWORD</b></a></li>
                                    </ul>
                                </li>
                                <li><a href="panel_admin/logout"><i class="icon-switch2"></i> <span><b>KELUAR</b></span></a></li>
                                </ul>
                        </div>
                    </div>
                    </div>
            </div>
            ```

