<!-- END HOME -->
<?php
$this->view('front/home/partial/home');
?>
<!-- END HOME -->

<!-- START HOW IT WORK -->
<?php
$this->view('front/home/partial/somepenyakit', [
    'penyakit' => $penyakit,
    'dataProbabilitas' => $dataProbabilitas,
    'getConvertDataProb' => $getConvertDataProb,
]);
?>
<!-- END HOE IT WORK -->


<!-- START TESTIMONIAL -->
<!-- <section class="section bg-testimonial" id="testimonial">
        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <div class="title-box text-center">
                        <h6 class="title-sub-title mb-0 text-primary f-17">Testimonial</h6>
                        <h3 class="title-heading mt-4">Apa yang mereka katakan</h3>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-lg-10">
                    <div class="testi-carousel">

                        <div class="testimonial-box text-center p-4">
                            <div class="testi-img-user">
                                <img src="<?= base_url('public/frontend/HTML/') ?>images/users/img-1.jpg" alt="" class="rounded-circle testi-user mx-auto d-block">
                            </div>
                            <img src="<?= base_url('public/frontend/HTML/') ?>images/client-quote.png" class="mt-4 pt-2" alt="">

                            <h4 class="font-italic mt-4 pt-2">The European languages are members of the same family
                                Their
                                separate existence is a myth For science, music, sport, etc, europe their Eopean
                                languages common the theory of popular words.</h4>

                            <div class="testi-border mt-4"></div>
                            <p class="text-uppercase text-muted mb-0 mt-4 f-14">Developer</p>
                            <h5 class="mt-2">Jeremiah Eskew</h5>
                        </div>

                        <div class="testimonial-box text-center p-4">
                            <div class="testi-img-user">
                                <img src="<?= base_url('public/frontend/HTML/') ?>images/users/img-2.jpg" alt="" class="rounded-circle testi-user mx-auto d-block">
                            </div>
                            <img src="<?= base_url('public/frontend/HTML/') ?>images/client-quote.png" class="mt-4 pt-2" alt="">

                            <h4 class="font-italic mt-4 pt-2">The European languages are members of the same family
                                Their
                                separate existence is a myth For science, music, sport, etc, europe their Eopean
                                languages common the theory of popular words.</h4>

                            <div class="testi-border mt-4"></div>
                            <p class="text-uppercase text-muted mb-0 mt-4 f-14">Designer</p>
                            <h5 class="mt-2">Cameron Green</h5>
                        </div>

                        <div class="testimonial-box text-center p-4">
                            <div class="testi-img-user">
                                <img src="<?= base_url('public/frontend/HTML/') ?>images/users/img-3.jpg" alt="" class="rounded-circle testi-user mx-auto d-block">
                            </div>
                            <img src="<?= base_url('public/frontend/HTML/') ?>images/client-quote.png" class="mt-4 pt-2" alt="">

                            <h4 class="font-italic mt-4 pt-2">The European languages are members of the same family
                                Their
                                separate existence is a myth For science, music, sport, etc, europe their Eopean
                                languages common the theory of popular words.</h4>

                            <div class="testi-border mt-4"></div>
                            <p class="text-uppercase text-muted mb-0 mt-4 f-14">Manager</p>
                            <h5 class="mt-2">Sammy Randolph</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section> -->
<!-- END TESTIMONIAL -->


<!-- START CONTACT -->
<?php
$this->view('front/home/partial/kontak');
?>
<!-- END CONTACT -->



<!-- javascript -->
<script src="<?= base_url('public/frontend/HTML/') ?>js/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        loadWork();

        function loadWork(page = "<?= $getPage ?>") {
            $.ajax({
                url: "<?= base_url('Home') ?>",
                dataType: 'json',
                type: 'get',
                data: {
                    per_page: page,
                },
                success: function(data) {

                    // output interface
                    let output = ``;
                    let root = "<?= base_url() ?>";
                    $.each(data.output, function(i, v) {

                        let dPenyakit = v[0];
                        output += `
                    <div class= "col-lg-4">
                        <div class="work-box text-center p-3">
                            <div class="work-icon">
                                <img src="${root}/public/image/penyakit/${dPenyakit.gambar_penyakit}" alt="Gambar penyakit" class="rounded-circle">
                                <h5 class="mt-4">${dPenyakit.nama_penyakit}</h5>
                            </div>
                            <h5 class="mt-4"></h5>
                            <div class="accordion" id="card-gejala-${dPenyakit.id_penyakit}">
                                <div class="card">
                                    <div class="card-header p-0" id="gejala-${dPenyakit.id_penyakit}" style="background-color: #007bff;">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#gejala-${dPenyakit.id_penyakit}">
                                                Beberapa gejala diantaranya
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="gejala-${dPenyakit.id_penyakit}" class="collapse show" aria-labelledby="gejala-${dPenyakit.id_penyakit}" data-parent="#card-gejala-${dPenyakit.id_penyakit}">
                                        <div class="card-body" style="text-align: left;">
                                        `;
                        $.each(v, function(i2, v2) {
                            output += `
                                    <p class="p-0 m-0">
                                        <strong>.</strong>${v2.kode_gejala} - ${v2.nama_gejala}
                                    </p>`;
                        })

                        output += `
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="accordion" id="accorionSolusi-${dPenyakit.id_penyakit}">
                                    <div class="card">
                                        <div class="card-header p-0 m-0" id="heading-${dPenyakit.id_penyakit}" style="background-color: #007bff;">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapse-solusi-${dPenyakit.id_penyakit}" aria-expanded="true" aria-controls="collapse-solusi-${dPenyakit.id_penyakit}">
                                                    Solusi:
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapse-solusi-${dPenyakit.id_penyakit}" class="collapse show" aria-labelledby="heading-${dPenyakit.id_penyakit}" data-parent="#accorionSolusi-${dPenyakit.id_penyakit}">
                                            <div class="card-body">`;
                        let getSolusi = data.solusi[i];
                        $.each(getSolusi, function(i3, v3) {
                            output += `
                                <p class="text-left m-0 p-0">
                                    - ${v3.kode_solusi} ${v3.keterangan_solusi}
                                </p>
                                `;
                        })
                        output += ` </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                            `;
                    })

                    // output interface
                    $('#interface_work').html(`
                        <div class="row mt-5">
                        ${output}
                        </div>`);

                    // output button
                    $('#button_work').html(data.pagination_link);
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            })
        }

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).data('ci-pagination-page');
            loadWork(page);
        })

        $(document).on('click', '.btn-submit', function(e) {
            e.preventDefault();
            var form = $('.form-submit')[0];
            var action = $('.form-submit').attr('action');
            var data = new FormData(form);
            $.ajax({
                url: action,
                type: "POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false, // Important!
                contentType: false,
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#loading_image').removeClass('d-none');
                },
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
                        resetForm();
                    }

                    if (data.status_db == 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: data.output,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                complete: function() {
                    $('#loading_image').addClass('d-none');
                },
                error: function(x, t, m) {
                    console.log(x.responseText);
                }
            });
        })

        function resetForm() {
            $('#error_modal').html('');
            $('.form-submit').trigger("reset");
        }
    })
</script>