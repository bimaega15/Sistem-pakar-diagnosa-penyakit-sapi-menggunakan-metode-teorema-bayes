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
                        <a data-toggle="modal" data-target="#modalForm" href="<?= base_url('Admin/ProbabilitasPakar/add') ?>" class="btn btn-primary btn-add"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Gejala</th>
                                        <th>Nama Penyakit</th>
                                        <th>Bobot Probabilitas</th>
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

<!-- Modal -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormProbabilitasPakar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormProbabilitasPakar"> Form Probabilitas Pakar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Admin/ProbabilitasPakar/process') ?>" method="post" class="form-submit">
                <input type="hidden" name="page" value="">
                <input type="hidden" name="id_probabilitas_pakar" value="">
                <div class="modal-body">
                    <div id="error_modal"></div>
                    <div class="form-group">
                        <label for="">Gejala</label>
                        <select name="gejala_id" class="form-control" id="">
                            <option value="">-- Gejala --</option>
                            <?php foreach ($gejala as $key => $v_gejala) {
                                echo '<option value="' . $v_gejala->id_gejala . '">' . $v_gejala->kode_gejala . ' ' . $v_gejala->nama_gejala . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Penyakit</label>
                        <select name="penyakit_id" class="form-control" id="">
                            <option value="">-- Penyakit --</option>
                            <?php foreach ($penyakit as $key => $v_penyakit) {
                                echo '<option value="' . $v_penyakit->id_penyakit . '">' . $v_penyakit->kode_penyakit . ' ' . $v_penyakit->nama_penyakit . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Bobot probabilitas</label>
                        <input type="number" name="bobot_probabilitas_pakar" placeholder="Bobot probabilitas..." class="form-control" step="any">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-redo"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary btn-submit"> <i class="fas fa-save"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "ajax": "<?= base_url('Admin/ProbabilitasPakar/loadData') ?>",
        });

        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();
            $('.form-submit')[0].reset();
            resetForm();
            $('input[name="page"]').val('add');
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            $('input[name="kode_ProbabilitasPakar"]').attr('readonly', true);
            const id_probabilitas_pakar = $(this).data('id_probabilitas_pakar');
            let url = $(this).attr('href');
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    const {
                        row
                    } = data;

                    $('input[name="id_probabilitas_pakar"]').val(row.id_probabilitas_pakar);
                    $('select[name="gejala_id"]').val(row.gejala_id);
                    $('select[name="penyakit_id"]').val(row.penyakit_id);
                    $('input[name="bobot_probabilitas_pakar"]').val(row.bobot_probabilitas_pakar);

                    $('#modalForm').modal().show();
                    $('input[name="page"]').val('edit');
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })

        function resetForm() {
            $('#error_modal').html('');
            $('.form-submit').trigger("reset");
            $('select[name="gejala_id"] option').attr('selected', false);
            $('select[name="penyakit_id"] option').attr('selected', false);
        }
        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            var form = $('.form-submit')[0];
            var data = new FormData(form);
            $.ajax({
                url: '<?= base_url('Admin/ProbabilitasPakar/process') ?>',
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 'error') {
                        var output = ``;
                        $.each(data.output, function(index, value) {
                            output += `
                            <div class="alert alert-danger alert-dismissible fade show mb-1" role="alert">
                                <strong>Fail!</strong>${value}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            `;
                        })
                        $('#error_modal').html(output);
                    }

                    if (data.status_db == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Successfully',
                            text: data.output,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        $('#modalForm').modal('hide');
                        table.ajax.reload();
                        resetForm();
                        $('#modalForm').modal('hide');
                    }

                    if (data.status_db == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: data.output,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        $('#modalForm').modal('hide');
                        table.ajax.reload();
                    }
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            });
        })
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_probabilitas_pakar = $(this).data("id_probabilitas_pakar");
            let url = $(this).attr('href');

            Swal.fire({
                title: 'Deleted',
                text: "Yakin ingin menghapus item ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        type: 'post',
                        data: {
                            id_probabilitas_pakar
                        },
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
                                    'success'
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