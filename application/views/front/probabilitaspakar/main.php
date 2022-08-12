<section class="section pt-5" id="how-it-work">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="title-box text-center">
                    <h3 class="title-heading mt-4">Data Probabilitas Pakar
                    </h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gejala</th>
                                <th>Penyakit</th>
                                <th>Nilai Probabilitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($probabilitas_pakar as $key => $value) :
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <p class="m-0 p-0">Kode: <?= $value->kode_gejala ?></p>
                                        <p class="m-0 p-0">Nama: <?= $value->nama_gejala ?></p>
                                    </td>
                                    <td>
                                        <p class="m-0 p-0">Kode: <?= $value->kode_penyakit ?></p>
                                        <p class="m-0 p-0">Nama: <?= $value->nama_penyakit ?></p>
                                    </td>
                                    <td><?= $value->bobot_probabilitas_pakar; ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END HOE IT WORK -->




<!-- javascript -->
<script src="<?= base_url('public/frontend/HTML/') ?>js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    })
</script>