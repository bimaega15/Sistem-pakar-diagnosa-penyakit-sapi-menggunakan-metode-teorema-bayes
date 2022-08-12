<section class="section pt-5" id="how-it-work">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="title-box text-center">
                    <h3 class="title-heading mt-4">Form Registrasi
                    </h3>
                    <strong>Silahkan isi identitas anda</strong>
                </div>
            </div>
        </div>

        <div id="interface_work"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <?php
                    $this->view('session');
                    if (validation_errors()) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Fail! </strong><?= validation_errors(); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                    endif;
                    ?>
                    <div class="card-body">
                        <form action="<?= base_url('Front/Register/process') ?>" method="post" class="form-submit" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="username" placeholder="Username..." class="form-control" value="<?= set_value('username') ?>">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="password" name="password" placeholder="Password..." class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Confirm Password</label>
                                        <input type="password" name="confirm_password" placeholder="Confirm password..." class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama_profile" class="form-control" placeholder="Nama profile" value="<?= set_value('nama_profile') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea id="alamat_profile" class="form-control alamat_profile" placeholder="Alamat" name="alamat_profile">
                    <?= set_value('alamat_profile') ?>    
                    </textarea>
                            </div>
                            <div class="form-group">
                                <label for="">No. HP</label>
                                <input type="number" name="nohp_profile" class="form-control" placeholder="No. HP" value="<?= set_value('nohp_profile') ?>">
                            </div>
                            <div class="form-group">
                                <label for="">Jenis Kelamin</label> <br>
                                <?php
                                $jenis_kelamin = set_value('jenis_kelamin_profile');
                                ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="jenis_kelamin_profile" type="radio" id="jenis_kelamin_profile1" value="L" <?= $jenis_kelamin == 'L' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jenis_kelamin_profile1">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="jenis_kelamin_profile" type="radio" id="jenis_kelamin_profile2" value="P" <?= $jenis_kelamin == 'P' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="jenis_kelamin_profile2">Perempuan</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Gambar profile</label>
                                <input type="file" name="gambar_profile" class="form-control">
                                <span id="load_gambar_profile"></span>
                            </div>

                            <div class="form-group">
                                <button type="reset" class="btn btn-danger"><i class="fas fa-redo"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Submit</button>
                                <div class="float-right">
                                    <span>Anda sudah memiliki account?</span> <a href="<?= base_url('Front/Login') ?>">
                                        <span class="badge badge-primary">
                                            Sign In
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END HOE IT WORK -->
<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var pane = $('#alamat_profile');
        pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
            .replace(/(<[^\/][^>]*>)\s*/g, '$1')
            .replace(/\s*(<\/[^>]+>)/g, '$1'));
    })
</script>