<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Bootstrap 4 Landing Page Template" />
    <meta name="keywords" content="bootstrap 4, premium, marketing, multipurpose" />
    <meta content="Themesdesign" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="<?= base_url('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>">
    <!-- css -->
    <link href="<?= base_url('public/frontend/HTML/') ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('public/frontend/HTML/') ?>css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Pe-icon-7 icon -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/frontend/HTML/') ?>css/pe-icon-7-stroke.css">
    <!--Slider-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/frontend/HTML/') ?>css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/frontend/HTML/') ?>css/owl.theme.css" />
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/frontend/HTML/') ?>css/owl.transitions.css" />
    <!-- magnific pop-up -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('public/frontend/HTML/') ?>css/magnific-popup.css" />
    <link href="<?= base_url('public/frontend/HTML/') ?>css/style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('public/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>jquery-toast-plugin-master/dist/jquery.toast.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>">

</head>

<body data-spy="scroll" data-target="#navbarCollapse">
    <?php
    $this->view('toastr');
    ?>
    <!-- TAGLINE HEADER START-->
    <?= $topbar; ?>
    <!-- Static navbar -->

    <!--Navbar Start-->
    <?= $navbar; ?>
    <!-- Navbar End -->
    <!-- content -->
    <?= $content; ?>
    <!-- endcontent -->
    <!-- END CONTACT -->

    <!-- START FOOTER -->
    <?= $footer; ?>
    <!-- END FOOTER -->

    <!-- javascript -->
    <script src="<?= base_url('public/frontend/HTML/') ?>js/jquery.min.js"></script>
    <script src="<?= base_url('public/frontend/HTML/') ?>js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('public/frontend/HTML/') ?>js/jquery.easing.min.js"></script>
    <script src="<?= base_url('public/frontend/HTML/') ?>js/jquery.mb.YTPlayer.js"></script>
    <!-- Portfolio -->
    <script src="<?= base_url('public/frontend/HTML/') ?>js/jquery.magnific-popup.min.js"></script>
    <!-- Owl Carousel -->
    <script src="<?= base_url('public/frontend/HTML/') ?>js/owl.carousel.min.js"></script>
    <script src="<?= base_url('public/frontend/HTML/') ?>js/app.js"></script>
    <script src="<?= base_url('public/fontawesome/js/all.min.js') ?>"></script>
    <script src="<?= base_url('node_modules/sweetalert2/dist/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('assets/') ?>jquery-toast-plugin-master/dist/jquery.toast.min.js"></script>
    <script src="<?= base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/datatables/dataTables.bootstrap4.min.js') ?>"></script>

</body>

</html>