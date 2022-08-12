<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konsultasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!($this->session->has_userdata('id_users'))) {
            $this->session->set_flashdata('error', 'Silahkan login terlebih dahulu');
            return redirect(base_url('Front/Login'));
        } else {
            $profile = check_profile();
            if ($profile->level == 'admin') {
                $this->session->set_flashdata('error', 'Anda tidak dapat mengakses sebagai admin');
                return redirect(base_url('Front/Login'));
            }
        }
        $this->load->model(['Gejala/Gejala_model', 'Hasil/Hasil_model', 'HasilDetail/HasilDetail_model']);
    }

    public function index()
    {
        $result = $this->Gejala_model->get()->result();

        $arr_data = [];
        $index_terbagi = 0;
        $index_terbagi_tambah = 0;
        foreach ($result as $key => $v_result) {
            if ($index_terbagi >= 5) {
                $index_terbagi = 0;
                $index_terbagi_tambah++;
            }
            $arr_data[$index_terbagi_tambah][$index_terbagi] = $v_result;

            $index_terbagi++;
        }
        $data['gejala'] = $arr_data;
        $data['title'] = 'Data Probabilitas Pakar';
        $data['konfigurasi'] = konfigurasi();
        $this->load->view('front/konsultasi/main', $data);
    }
    public function process()
    {
        $put_diagnosa = $this->input->post('gejala_id', true);
        if (empty($put_diagnosa)) {
            $this->session->set_flashdata('error', 'Anda belum memasukan gejala');
            return redirect(base_url('Front/Konsultasi'));
        }

        // output
        $data['title'] = 'Submit Diagnosa';
        $save_array = [];
        $teorema = new TeoremaBayes();

        // gejala yang ditimbulkan
        $getPutDiagnosa = $teorema->gejalaYangDitimbulkan($put_diagnosa);
        $save_array['put_diagnosa'] = $getPutDiagnosa;

        // atur rule
        $getGejala = [];
        $getGejala = $teorema->aturRule($put_diagnosa);
        $save_array['getGejala'] = $getGejala;

        // nilai probabilitas dari tiap evidence
        $nProbPerEvidence = [];
        $nProbPerEvidence = $teorema->nProbPerEvidence($getGejala);
        $save_array['nProbPerEvidence'] = $nProbPerEvidence;


        // mencari nilai probabilitas hipotesis H tanpa memandang evidence apapun
        $nProbHnotEvidence = [];
        $nProbHnotEvidence = $teorema->nProbHnotEvidence($getGejala, $nProbPerEvidence);
        $save_array['nProbHnotEvidence'] = $nProbHnotEvidence;


        // mengalikan nilai probabilitas evidence awal dengan nilai probabilitas hipotesis tanpa memandang evidence
        $nProbAwalHnotEvidence = [];
        $nProbAwalHnotEvidence = $teorema->nProbAwalHnotEvidence($getGejala, $nProbHnotEvidence);
        $save_array['nProbAwalHnotEvidence'] = $nProbAwalHnotEvidence;

        // probabilitas hipotesis Hi benar jika diberikan evidence e
        $probHBenarWithE = [];
        $probHBenarWithE = $teorema->probHBenarWithE($getGejala, $nProbHnotEvidence, $nProbAwalHnotEvidence);
        $save_array['probHBenarWithE'] = $probHBenarWithE;

        // nilai kesimpulan dari Teorema Bayes dengan cara mengalikan nilai probabilitas
        $kesimpulanNProb = [];
        $kesimpulanNProb = $teorema->kesimpulanNProb($getGejala, $probHBenarWithE);
        $save_array['kesimpulanNProb'] = $kesimpulanNProb;
        $data['teorema_bayes'] = $save_array;

        // hasil penyakit
        $max_hasil = $teorema->hasilPenyakit($kesimpulanNProb)['max_hasil'];
        $penyakit = $teorema->hasilPenyakit($kesimpulanNProb)['penyakit'];
        $hasil_penyakit = $teorema->hasilPenyakit($kesimpulanNProb)['hasil_penyakit'];
        $solusi = $teorema->hasilPenyakit($kesimpulanNProb)['solusi'];
        $tingkat_keyakinan = $teorema->hasilPenyakit($kesimpulanNProb)['tingkat_keyakinan'];

        $data['hasil_penyakit'] = $hasil_penyakit;
        $data['solusi'] = $solusi;

        $this->session->set_userdata('teorema_bayes', [
            'put_diagnosa' => $put_diagnosa,
            'penyakit' => $penyakit,
            'tingkat_keyakinan' => $tingkat_keyakinan
        ]);
        $this->template->front('front/konsultasi/submit', $data);
    }

    public function submitPost()
    {
        $session = $this->session->userdata('teorema_bayes');
        if (empty($session)) {
            return redirect(base_url('Admin/Diagnosa'));
        }
        $data_hasil = [
            'penyakit_id' => $session['penyakit'],
            'tingkat_keyakinan_hasil' => $session['tingkat_keyakinan'],
            'users_id' => $this->session->userdata('id_users')
        ];
        $insert_hasil = $this->Hasil_model->insert($data_hasil);

        foreach ($session['put_diagnosa'] as $key => $v_diagnosa) {
            $data_hasil_detail[] = [
                'hasil_id' => $insert_hasil,
                'gejala_id' => $v_diagnosa,
            ];
        }
        $insert_hasil_detail = $this->HasilDetail_model->insertMany($data_hasil_detail);

        if ($insert_hasil || $insert_hasil_detail) {
            $this->session->unset_userdata('teorema_bayes');
            $this->session->unset_userdata('put_diagnosa');

            $this->session->set_flashdata('success', 'Berhasil menyimpaan data hasil diagnosa');
            return redirect(base_url('Front/Account/Riwayat'));
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpaan data hasil');
            return redirect(base_url('Front/Account/Riwayat'));
        }
    }
}
