<section class="section" id="contact">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="title-box text-center">
                    <h6 class="title-sub-title mb-0 text-primary f-17">Hubungi kami</h6>
                    <h3 class="title-heading mt-4">Jika membutuhkan lebih, bantuan medis</h3>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-4">
                <div class="contact-info bg-light p-4 rounded mt-4">
                    <h5 class="f-18">Contact Details</h5>
                    <p class="text-muted">Berikut beberapa kontak kami yang dapat anda hubungi: </p>
                    <div class="mt-4">
                        <div class="media">
                            <i class="pe-7s-home h4"></i>
                            <div class="media-body pl-3">
                                <h5 class="mt-0 f-17">Alamat</h5>
                                <p class="text-muted mb-0">
                                    <?= $konfigurasi->alamat_konfigurasi; ?>
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 pt-1">
                            <div class="media">
                                <i class="pe-7s-mail-open-file h4"></i>
                                <div class="media-body pl-3">
                                    <h5 class="mt-0 f-17">Email</h5>
                                    <p class="text-muted mb-0">
                                        <a href="mailto:<?= $konfigurasi->email_konfigurasi; ?>"><?= $konfigurasi->email_konfigurasi; ?></a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-1">
                            <div class="media">
                                <i class="pe-7s-call h4"></i>
                                <div class="media-body pl-3">
                                    <h5 class="mt-0 f-17">Call Support</h5>
                                    <p class="text-muted mb-0">
                                        <?= $konfigurasi->nohp_konfigurasi; ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="pl-0 pl-lg-2 mt-4">
                    <h5 class="f-18">Kirim pesan</h5>
                    <div class="custom-form mt-3">
                        <div id="error_modal"></div>
                        <form method="post" action="<?= base_url('Home/sendKontak') ?>" name="contact-form" id="contact-form" class="form-submit">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mt-3">
                                        <label class="contact-lable">Nama depan</label>
                                        <input name="nama_depan" id="nama_depan" class="form-control" type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group mt-3">
                                        <label class="contact-lable">Nama belakang</label>
                                        <input name="nama_belakang" id="nama_belakang" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label class="contact-lable">Alamat Email</label>
                                        <input type="text" name="email" id="email" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label class="contact-lable">Subject</label>
                                        <input name="subject" id="subject" class="form-control" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label class="contact-lable">Pesan kamu</label>
                                        <textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-3 text-right">
                                    <button type="submit" id="submit" name="send" class="submitBnt btn btn-primary btn-round btn-submit" value="Send Message" type="submit">
                                        <div id="simple-msg"></div> <i class="fas fa-paper-plane"></i>
                                        Kirim Pesan
                                        <img id="loading_image" src="<?= base_url('public/image/loading/loading.svg') ?>" alt="" height="50px;" class="d-none">
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>


</section>