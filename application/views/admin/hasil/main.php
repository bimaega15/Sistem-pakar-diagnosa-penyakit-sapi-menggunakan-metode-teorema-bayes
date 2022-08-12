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
                        <a href="<?= base_url('Admin/Diagnosa') ?>" class="btn btn-primary btn-add"><i class="fas fa-plus-circle"></i> Tambah Data</a>
                        <div class="table-responsive mt-3">
                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode</th>
                                        <th>Penyakit</th>
                                        <th>Keyakinan</th>
                                        <th>Users</th>
                                        <th>Gambar Penyakit</th>
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="modalFormHasil" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormHasil"> Form Hasil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="post" class="form-submit">
                <input type="hidden" name="page" value="">
                <div class="modal-body">
                    <div id="error_modal"></div>
                    <span id="load_gejala"></span>
                    <span id="load_solusi"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-check"></i> OK</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('Qovex_v1.0.0/Admin/Vertical/dist/') ?>assets/libs/jquery/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "ajax": "<?= base_url('Admin/Hasil/loadData') ?>",
        });


        $(document).on('click', '.btn-detail', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');
            $('#modalForm').modal('show');
            $.ajax({
                url: url,
                method: 'get',
                dataType: 'json',
                success: function(data) {
                    let gejala = data.gejala;
                    let solusi = data.solusi;

                    let output_gejala = '';
                    $.each(gejala, function(i, v) {
                        output_gejala += `
                        <p>
                            Kode gejala: ${v.kode_gejala} <br>
                            Gejala: ${v.nama_gejala} <br>
                        </p>
                        `;
                    })

                    let output_solusi = '';
                    $.each(solusi, function(i, v) {
                        output_solusi += `
                        <hr style="background: green;">
                        <div class="mt-3">
                        Kode solusi: ${v.kode_solusi} <br>
                        Keterangan: ${v.keterangan_solusi} <br>
                        </div>
                        `;
                    })

                    $('#load_gejala').html(output_gejala);
                    $('#load_solusi').html(output_solusi);
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        })



        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id_hasil = $(this).data("id_hasil");
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
                            id_hasil
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