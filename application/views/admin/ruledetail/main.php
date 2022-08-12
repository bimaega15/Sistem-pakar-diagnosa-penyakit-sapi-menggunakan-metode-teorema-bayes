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
                    <?php $this->view('session'); ?>
                    <div class="card-body">
                        <div>
                            <strong><?= $rule->kode_rule; ?> <?= $rule->nama_rule; ?></strong>
                        </div>
                        <a href="<?= base_url('Admin/RuleDetail/add?rule_id=' . $rule->id_rule) ?>" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                        <a href="<?= base_url('Admin/RuleDetail/edit/' . $rule->id_rule) ?>" class="btn btn-warning"><i class="fas fa-pencil-alt"></i> Edit data</a>
                        <a href="<?= base_url('Admin/RuleDetail/delete?rule_id=' . $rule->id_rule) ?>" class="btn btn-danger btn-delete"><i class="fas fa-trash-alt"></i> Delete data</a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Gejala</th>
                                        <th>Nama Gejala</th>
                                        <th>Penyakit</th>
                                        <th>Action</th>
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
            "ajax": {
                url: "<?= base_url('Admin/RuleDetail/loadData') ?>",
                type: 'get',
                data: {
                    rule_id: "<?= $rule->id_rule ?>"
                }
            },
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin hapus beberapa gejala ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Admin/RuleDetail/delete') ?>",
                        type: 'get',
                        data: {
                            rule_id: "<?= $rule->id_rule ?>"
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'success'
                                );
                                table.ajax.reload();

                            } else {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'error'
                                )
                            }
                        },
                        error: function(x, t, m) {
                            console.log(x.responseText);
                        }
                    })
                }
            })
        })

        $(document).on('click', '.btn-delete-one', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            let id_rule_detail = $(this).data('id_rule_detail');

            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin hapus gejala ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes Confirm'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('Admin/RuleDetail/deleteOne') ?>",
                        type: 'get',
                        data: {
                            id_rule_detail: id_rule_detail
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'success'
                                );
                                table.ajax.reload();

                            } else {
                                Swal.fire(
                                    'Deleted!',
                                    data.msg,
                                    'error'
                                )
                            }
                        },
                        error: function(x, t, m) {
                            console.log(x.responseText);
                        }
                    })
                }
            })
        })
    })
</script>