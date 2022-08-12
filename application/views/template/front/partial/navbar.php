<nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand logo text-uppercase" href="<?= base_url('Home') ?>">
            <img src="<?= base_url('public/image/konfigurasi/' . $konfigurasi->gambar_konfigurasi) ?>" alt="" height="40" class="rounded">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
                <li class="nav-item">
                    <a href="<?= base_url('Home') ?>" class="nav-link smoothlink">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Diagnosa <i class="mdi mdi-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?= base_url('Front/Gejala') ?>">Gejala</a>
                        <a class="dropdown-item" href="<?= base_url('Front/Penyakit') ?>">Penyakit</a>
                        <a class="dropdown-item" href="<?= base_url('Front/Solusi') ?>">Solusi</a>
                        <a class="dropdown-item" href="<?= base_url('Front/DiagnosaPakar') ?>">Diagnosa Pakar</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('Front/Konsultasi') ?>" class="nav-link smoothlink">Konsultasi</a>
                </li>
                <?php
                if ($this->session->has_userdata('id_users')) :
                    $profile = check_profile();
                    if ($profile->level == 'users') : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Account <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="<?= base_url('Front/Account/Profile') ?>">My Profile</a>
                                <a class="dropdown-item" href="<?= base_url('Front/Account/Riwayat') ?>">Riwayat</a>
                                <a class="dropdown-item" href="<?= base_url('Front/Logout') ?>">Logout</a>
                            </div>
                        </li>
                    <?php
                    endif;
                    ?>
                <?php
                endif;
                ?>

            </ul>

            <?php
            if (!($this->session->has_userdata('id_users'))) :
            ?>
                <ul class="navbar-nav navbar-center">
                    <li class="nav-item">
                        <a href="<?= base_url('Front/Login') ?>" class="nav-link">Log In</a>
                    </li>
                    <li class="nav-item d-inline-block d-lg-none">
                        <a href="<?= base_url('Front/Register') ?>" class="nav-link">Sign Up</a>
                    </li>
                </ul>
                <div class="navbar-button d-none d-lg-inline-block">
                    <a href="<?= base_url('Front/Register') ?>" class="btn btn-sm btn-soft-primary btn-round">Sign Up</a>
                </div>
            <?php
            endif;
            ?>

            <?php
            if (($this->session->has_userdata('id_users'))) :
                $profile = check_profile();
                $level = $profile->level;
                if ($level != 'users') : ?>
                    <ul class="navbar-nav navbar-center">
                        <li class="nav-item">
                            <a href="<?= base_url('Front/Login') ?>" class="nav-link">Log In</a>
                        </li>
                        <li class="nav-item d-inline-block d-lg-none">
                            <a href="<?= base_url('Front/Register') ?>" class="nav-link">Sign Up</a>
                        </li>
                    </ul>
                    <div class="navbar-button d-none d-lg-inline-block">
                        <a href="<?= base_url('Front/Register') ?>" class="btn btn-sm btn-soft-primary btn-round">Sign Up</a>
                    </div>
                <?php
                endif;
                ?>

            <?php
            endif;
            ?>

        </div>
    </div>
</nav>