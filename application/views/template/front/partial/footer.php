<section class="py-5 bg-light">
    <div class="container">

        <div class="row">
            <div class="col-lg-4">
                <div class="footer-info mt-4">
                    <img src="<?= base_url('public/image/sapi/sapi_2.png') ?>" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-lg-8">
                <div class="d-flex align-items-middle">
                    <p>
                        <?= $konfigurasi->tentang_konfigurasi; ?>
                    </p>
                </div>
            </div>
        </div>

        <hr class="my-5">

        <div class="row">
            <div class="col-12">
                <div class="text-center">
                    <p class="text-muted mb-0">2022 © <?= $konfigurasi->copyright_konfigurasi; ?></p>
                </div>
            </div>
        </div>

    </div>
</section>