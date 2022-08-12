<div class="topbar">
    <div class="container">
        <div class="float-left">
            <div class="phone-topbar">
                <ul class="list-inline topbar-link mb-0">
                    <li class="list-inline-item mr-4 pr-2"><a href="mailto:<?= $konfigurasi->email_konfigurasi; ?>"><i class="mdi mdi-email mr-2 f-16"></i> <?= $konfigurasi->email_konfigurasi; ?></a></li>
                    <li class="list-inline-item">
                        <a href="#">
                            <i class="mdi mdi-earth mr-2 f-16"></i><?= $konfigurasi->alamat_konfigurasi; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="float-right">
            <ul class="list-inline topbar-social pb-0 pt-2 mt-1 mb-0">
                <li class="list-inline-item pl-2">
                    <span class="text-white">
                        <?= $konfigurasi->copyright_konfigurasi; ?>
                    </span>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>