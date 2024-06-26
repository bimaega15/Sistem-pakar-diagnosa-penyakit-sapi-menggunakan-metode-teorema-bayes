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
                <?php
                $teorema = $teorema_bayes;
                ?>
                <div class="mb-3">
                    <a href="<?= base_url('Admin/Diagnosa/submitPost') ?>" class="btn btn-primary btn-submit">
                        <i class="fas fa-paper-plane"></i> Submit
                    </a>
                </div>
                <?php
                $this->view('session');
                ?>
                <div class="card">
                    <div class="card-header">
                        Gejala yang diberikan kepada pasien
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($teorema['put_diagnosa'] as $key => $value) {
                                        echo '
                                        <tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . $value->kode_gejala . '</td>
                                            <td>' . $value->nama_gejala . '</td>
                                        </tr>
                                        ';
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Mendefinisikan terlebih dahulu nilai probabilitas dari tiap evidence untuk tiap hipotesis
                    </div>
                    <div class="card-body">
                        <?php
                        $no = 1;
                        foreach ($teorema['getGejala'] as $penyakit_id => $v_gejala) {
                            echo '
                            <div class="mb-1">
                            <strong>' . check_penyakit_id($penyakit_id)->nama_penyakit . '</strong>
                            <div class="table-responsive">
                                <table class="table" id="datatable-getGejala-' . $penyakit_id . '">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Nilai probabilitas</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            foreach ($v_gejala as $index => $value) {
                                echo '
                                        <tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . $value->kode_gejala . '</td>
                                            <td>' . $value->nama_gejala . '</td>
                                            <td>' . $value->bobot_probabilitas_pakar . '</td>
                                        </tr>
                                        ';
                            }
                            echo '</tbody>
                                </table>
                            </div>
                        </div>
                            
                            ';
                        }
                        ?>

                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Menjumlahkan nilai probabilitas dari tiap evidence untuk masing-masing hipotesis
                    </div>
                    <div class="card-body">
                        <?php
                        echo '
                            <div class="table-responsive">
                                <table class="table" id="datatable-nProbPerEvidence">
                                    <thead>
                                        <tr>
                                            <th>Penyakit</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        foreach ($teorema['nProbPerEvidence'] as $penyakit_id => $value) {
                            echo ' <tr>
                                            <td>' . check_penyakit_id($penyakit_id)->nama_penyakit . '</td>
                                            <td>' . $value . '</td>
                                        </tr>';
                        }
                        echo '
                                    </tbody>
                                </table>
                            </div>                            
                            ';
                        ?>

                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Mencari nilai probabilitas hipotesis H tanpa memandang evidence
                    </div>
                    <div class="card-body">
                        <?php
                        $no = 1;
                        foreach ($teorema['nProbHnotEvidence'] as $penyakit_id => $v_gejala) {
                            echo '
                            <div class="mb-1">
                            <strong>' . check_penyakit_id($penyakit_id)->nama_penyakit . '</strong>
                            <div class="table-responsive">
                                <table class="table" id="datatable-nProbHnotEvidence-' . $penyakit_id . '">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            foreach ($v_gejala as $id_gejala => $value) {
                                $gejala = check_gejala_id($id_gejala);

                                echo '
                                        <tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . $gejala->kode_gejala . '</td>
                                            <td>' . $gejala->nama_gejala . '</td>
                                            <td>' . round($value, 3) . '</td>
                                        </tr>
                                        ';
                            }
                            echo '</tbody>
                                </table>
                            </div>
                        </div>
                            
                            ';
                        }
                        ?>

                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Mencari nilai probabilitas hipotesis memandang evidence
                    </div>
                    <div class="card-body">
                        <?php
                        $no = 1;

                        echo '
                            <div class="table-responsive">
                                <table class="table" id="datatable-nProbAwalHnotEvidence">
                                    <thead>
                                        <tr>
                                            <th>Penyakit</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        foreach ($teorema['nProbAwalHnotEvidence'] as $penyakit_id => $value) {
                            echo ' <tr>
                                            <td>' . check_penyakit_id($penyakit_id)->nama_penyakit . '</td>
                                            <td>' . round($value, 3) . '</td>
                                        </tr>';
                        }
                        echo '
                                    </tbody>
                                </table>
                            </div>                            
                            ';
                        ?>

                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Mencari nilai probabilitas hipotesis H tanpa memandang evidence
                    </div>
                    <div class="card-body">
                        <?php
                        $no = 1;
                        foreach ($teorema['probHBenarWithE'] as $penyakit_id => $v_gejala) {
                            echo '
                            <div class="mb-1">
                            <strong>' . check_penyakit_id($penyakit_id)->nama_penyakit . '</strong>
                            <div class="table-responsive">
                                <table class="table" id="datatable-probHBenarWithE-' . $penyakit_id . '">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            foreach ($v_gejala as $id_gejala => $value) {
                                $gejala = check_gejala_id($id_gejala);

                                echo '
                                        <tr>
                                            <td>' . $no++ . '</td>
                                            <td>' . $gejala->kode_gejala . '</td>
                                            <td>' . $gejala->nama_gejala . '</td>
                                            <td>' . round($value, 3) . '</td>
                                        </tr>
                                        ';
                            }
                            echo '</tbody>
                                </table>
                            </div>
                        </div>
                            
                            ';
                        }
                        ?>

                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Mencari nilai probabilitas hipotesis memandang evidence
                    </div>
                    <div class="card-body">
                        <?php
                        $no = 1;

                        echo '
                            <div class="table-responsive">
                                <table class="table" id="datatable-kesimpulanNProb">
                                    <thead>
                                        <tr>
                                            <th>Penyakit</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                        foreach ($teorema['kesimpulanNProb'] as $penyakit_id => $value) {
                            echo ' <tr>
                                            <td>' . check_penyakit_id($penyakit_id)->nama_penyakit . '</td>
                                            <td>' . (round($value, 3) * 100) . ' % </td>
                                        </tr>';
                        }
                        echo '
                                    </tbody>
                                </table>
                            </div>                            
                            ';
                        ?>

                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-header">
                        Hasil diagnosa
                    </div>
                    <div class="card-body">
                        <?php
                        $no = 1;

                        echo '
                            <div class="table-responsive">
                                <table class="table" id="datatable-hasil">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Penyakit</th>
                                            <th>Nilai keyakinan</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>' . $hasil_penyakit->kode_penyakit . '</td>
                                            <td>' . $hasil_penyakit->nama_penyakit . '</td>
                                            <td> <strong> ' . (round($teorema['kesimpulanNProb'][$hasil_penyakit->id_penyakit], 3) * 100) . ' % </strong></td>
                                            <td>
                                                <img src="' . base_url('public/image/penyakit/' . $hasil_penyakit->gambar_penyakit) . '" width="100px;" class="img-thumbnail rounded"></img>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                            
                            ';

                        ?>
                        <h4>Solusi</h4>
                        <p>
                            <?php
                            foreach ($solusi as $key => $v_solusi) {
                                echo ' <h4>
                                - ' . $v_solusi->kode_solusi . ' ' . $v_solusi->keterangan_solusi . '
                                </h4>
                                ';
                            }
                            ?>
                        </p>
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
        let penyakit_id = '';
        <?php
        foreach ($teorema['getGejala'] as $penyakit_id => $v_gejala) { ?>
            penyakit_id = "<?= $penyakit_id ?>";
            $('#datatable-getGejala-' + penyakit_id).DataTable();
            $('#datatable-nProbHnotEvidence-' + penyakit_id).DataTable();
            $('#datatable-probHBenarWithE-' + penyakit_id).DataTable();

        <?php
        }
        ?>

        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            let url = $(this).attr('href');

            Swal.fire({
                title: 'Submit',
                text: "Apakah anda yakin ingin submit hasil diagnosa ?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, confirmed'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            })
        })
    })
</script>