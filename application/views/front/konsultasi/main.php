<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="colorlib.com">

    <!-- MATERIAL DESIGN ICONIC FONT -->
    <link rel="stylesheet" href="<?= base_url('assets/colorlib-wizard-9/') ?>fonts/material-design-iconic-font/css/material-design-iconic-font.css">
    <link href="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- DATE-PICKER -->
    <link rel="stylesheet" href="<?= base_url('assets/colorlib-wizard-9/') ?>vendor/date-picker/css/datepicker.min.css">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/colorlib-wizard-9/') ?>css/style.css">
    <link rel="shortcut icon" href="<?= base_url('public/image/') ?>konfigurasi/<?= $konfigurasi->gambar_konfigurasi; ?>" type="image/x-icon">

</head>

<body>
    <div class="wrapper mt-5">
        <?php
        $this->view('session');
        ?>
        <form action="<?= base_url('Front/Konsultasi/process') ?>" id="wizard" method="post">
            <?php
            $no = 1;
            foreach ($gejala as $index => $v_gejala) :
            ?>
                <h4></h4>
                <section>
                    <h3 style="font-size: 16px;">Isi beberapa gejala yang dirasakan sapi anda:</h3>

                    <?php
                    foreach ($v_gejala as $index => $v_data) :
                    ?>
                        <div class="row mb-3">
                            <div class="col-lg-8">
                                <?= $no++; ?>. Apakah <?= $v_data->nama_gejala ?> ?
                            </div>
                            <div class="col-lg-4">
                                <div class="custom-control custom-checkbox">
                                    <input name="gejala_id[]" value="<?= $v_data->id_gejala ?>" type="checkbox" class="custom-control-input" id="gejala-<?= $v_data->id_gejala ?>">
                                    <label class="custom-control-label" for="gejala-<?= $v_data->id_gejala ?>">Iya, merasakan</label>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>

                </section>
            <?php endforeach; ?>

        </form>
    </div>

    <script src="<?= base_url('assets/colorlib-wizard-9/') ?>js/jquery-3.3.1.min.js"></script>

    <!-- JQUERY STEP -->
    <script src="<?= base_url('assets/colorlib-wizard-9/') ?>js/jquery.steps.js"></script>


    <script src="<?= base_url('assets/colorlib-wizard-9/') ?>js/main.js"></script>

    <!-- Template created and distributed by Colorlib -->
    <script>
        $(document).ready(function() {
            $(document).on('click', '.actions li a[href="#finish"]', function() {
                $('#wizard').submit();
            });
        })
    </script>
</body>

</html>