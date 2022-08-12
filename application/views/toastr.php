<?php
if ($this->session->has_userdata('success_toastr')) { ?>
    <div id="session_status_toastr" data-status="success" data-text="<?= $this->session->flashdata('success_toastr') ?>"></div>
<?php
}
if ($this->session->has_userdata('error_toastr')) { ?>
    <div id="session_status_toastr" data-status="error" data-text="<?= $this->session->flashdata('error_toastr') ?>"></div>
<?php
}
