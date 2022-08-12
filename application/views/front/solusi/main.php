<section class="section pt-5" id="how-it-work">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="title-box text-center">
                    <h3 class="title-heading mt-4">Data Solusi
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
                                <th>Penyakit</th>
                                <th width="10%;">Gambar</th>
                                <th>Kode Solusi</th>
                                <th>Solusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($solusi as $key => $value) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $value->nama_penyakit; ?></td>
                                    <td>
                                        <img src="<?= base_url('public/image/penyakit/' . $value->gambar_penyakit) ?>" class="img-thumbnail" alt="Gambar penyakit">
                                    </td>
                                    <td><?= $value->kode_solusi; ?></td>
                                    <td><?= $value->keterangan_solusi; ?></td>
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