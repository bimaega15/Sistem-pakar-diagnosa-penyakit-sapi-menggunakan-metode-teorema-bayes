<section class="section pt-5" id="how-it-work">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="title-box text-center">
                    <h3 class="title-heading mt-4">Form Login
                    </h3>
                    <strong>Masukan account anda</strong>
                </div>
            </div>
        </div>

        <div id="interface_work"></div>
        <div class="row">
            <div class="col-lg-6 mx-auto">
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
                        <form action="<?= base_url('Front/Login/process') ?>" method="post" class="form-submit" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" name="username" placeholder="Username..." class="form-control" value="<?= set_value('username') ?>">
                            </div>

                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="cookie" name="cookie">
                                    <label class="form-check-label" for="cookie">
                                        Remember me
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="reset" class="btn btn-danger"><i class="fas fa-redo"></i> Cancel</button>
                                <button type="submit" class="btn btn-primary"> <i class="fas fa-save"></i> Submit</button>
                                <div class="float-right">
                                    <span>Anda belum memiliki account?</span> <a href="<?= base_url('Front/Register') ?>">
                                        <span class="badge badge-primary">
                                            Register
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