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
                    <?php $this->view('session'); ?>
                    <div class="card-body">
                        <div>
                            <strong><?= $rule->kode_rule; ?> <?= $rule->nama_rule; ?></strong>
                        </div>
                        <a href="<?= base_url('Admin/RuleDetail/add') ?>" class="btn btn-primary btn-add-gejala"><i class="fas fa-plus-circle"></i> Tambah Gejala</a>

                        <a href="<?= base_url('Admin/RuleDetail/process?rule_id=' . $rule->id_rule . '&page=' . $page) ?>" class="btn btn-primary btn-submit-gejala"><i class="fas fa-paper-plane"></i> Submit</a>

                        <div class="mt-3">
                            <div class="form-group">
                                <label for="">Gejala</label>
                                <select name="gejala_id" class="form-control select2" id="">
                                    <option value="">-- Gejala --</option>
                                    <?php
                                    foreach ($gejala as $key => $v_gejala) {
                                        echo '
                                        <option value="' . $v_gejala->id_gejala . '">' . $v_gejala->kode_gejala . ' ' . $v_gejala->nama_gejala . '</option>
                                        ';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card">
                    <span id="error_modal"></span>
                    <div class="card-header">
                        <i class="mdi mdi-diabetes"></i> <strong>FORM GEJALA</strong>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable">
                                <thead class="text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Gejala</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="loadBody">
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
        $('.select2').select2();
        let table = $('#dataTable').DataTable({
            "ajax": {
                url: "<?= base_url('Admin/RuleDetail/loadPutData') ?>",
            },
        });

        function resetForm() {
            $('#error_modal').html('');
        }
        $(document).on('click', '.btn-add-gejala', function(e) {
            e.preventDefault();
            let output = '';
            let gejala_id = $('select[name="gejala_id"]').val();
            $.ajax({
                url: '<?= base_url('Admin/RuleDetail/getGejala') ?>',
                dataType: 'json',
                data: {
                    gejala_id: gejala_id
                },
                type: 'post',
                success: function(data) {
                    if (data.status == 'error') {
                        $('#error_modal').html(`
                        <div class="alert alert-danger alert-dismissible fade show mb-1" role="alert">
                            <strong>Fail!</strong>${data.output}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        `);
                    }

                    if (data.status == 'success') {
                        resetForm();
                        table.ajax.reload();

                    }
                },
                error: function(x, t, m) {
                    console.log(x.responseJSON);
                }
            })

        })

        $(document).on('click', '.btn-delete-put-gejala', function(e) {
            e.preventDefault();
            let id_gejala = $(this).data('id_gejala');

            $.ajax({
                url: '<?= base_url('Admin/RuleDetail/deletePutGejala') ?>',
                dataType: 'json',
                type: 'post',
                data: {
                    gejala_id: id_gejala
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('#error_modal').html(`
                        <div class="alert alert-success alert-dismissible fade show mb-1" role="alert">
                            <strong>Success! </strong>${data.output}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        `);

                        table.ajax.reload();
                    }
                },
                error: function(x, t, m) {
                    console.log(x.responseJSON);
                }
            })
        })

        $(document).on('click', '.btn-submit-gejala', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin submit beberapa gejala ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        })
    })
</script>