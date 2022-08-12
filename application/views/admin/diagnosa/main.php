<?php $profile = check_profile(); ?>
<div class="main-content">

    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?= $title; ?></h4>

                    <div class="page-title-right">
                        <?= $breadcrumbs; ?>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <span id="error_modal"></span>
                    <?php $this->view('session'); ?>
                    <div class="card-body">
                        <a href="<?= base_url('Admin/Diagnosa/submit') ?>" class="btn btn-primary btn-submit">
                            <i class="fas fa-save"></i> Submit
                        </a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Gejala</th>
                                        <th>Nama Gejala</th>
                                        <th class="text-center" width="20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- end row -->
</div>
<!-- End Page-content -->

<?= $footer; ?>
</div>

<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "ajax": "<?= base_url('Admin/Diagnosa/loadData') ?>",
        });

        $(document).on('click', '.gejala_id', function() {
            let gejala_id = $(this).data('id_gejala');
            let value = null;
            if ($(this).is(':checked')) {
                value = $(this).val();
            }

            $.ajax({
                url: '<?= base_url('Admin/Diagnosa/saveSession') ?>',
                method: 'get',
                dataType: 'json',
                data: {
                    gejala_id,
                    value,
                },
                success: function(data) {
                    if (data.status == 'error') {
                        $('#error_modal').html(`
                        <div class="alert alert-danger alert-dismissible fade show mb-1" role="alert">
                            <strong>Fail! </strong>${data.output}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        `);
                    }
                    if (data.status == 'success') {
                        $('#error_modal').html(`
                        <div class="alert alert-success alert-dismissible fade show mb-1" role="alert">
                            <strong>Success! </strong>${data.output}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        `);
                    }
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })
    })
</script>