<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['Hasil/Hasil_model', 'HasilDetail/HasilDetail_model']);
        check_not_login_users();
    }

    public function index()
    {
        $data['title'] = 'Form Riwayat';
        $this->template->front('front/riwayat/main', $data);
    }
    public function detail($id_hasil)
    {
        $get = $this->Hasil_model->get($id_hasil)->row();
        $data = [
            'solusi' => check_solusi(null, $get->id_penyakit)->result(),
            'gejala' => $this->HasilDetail_model->get(null, $id_hasil)->result(),
        ];
        echo json_encode($data);
    }
    public function detailPerhitungan($id_hasil)
    {
        $get = $this->HasilDetail_model->get(null, $id_hasil)->result();
        $gejala_id = array_column($get, 'id_gejala');
        $put_diagnosa = $gejala_id;

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
        $this->template->front('front/riwayat/perhitungan', $data);
    }
    public function delete()
    {
        $id_hasil = htmlspecialchars($this->input->post('id_hasil', true));
        $delete = $this->Hasil_model->delete($id_hasil);
        if ($delete) {
            $data = [
                'status' => "success",
                'msg' => 'Success hapus data'
            ];
            echo json_encode($data);
        } else {
            $data = [
                'status' => "error",
                'msg' => 'Error hapus data'
            ];
            echo json_encode($data);
        }
    }
    public function loadData()
    {
        $users_id = $this->session->userdata('id_users');
        $data = $this->Hasil_model->get(null, $users_id)->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $gambar_penyakit = base_url('public/image/penyakit/' . $v_data->gambar_penyakit);
            $gambar_profile = base_url('public/image/users/' . $v_data->gambar_profile);
            $jenis_kelamin_profile = $v_data->jenis_kelamin_profile == 'L' ? 'Laki-laki' : 'Perempuan';
            $result['data'][] = [
                $no++,
                $v_data->kode_penyakit,
                $v_data->nama_penyakit,
                (round($v_data->tingkat_keyakinan_hasil, 3) * 100) . ' %',
                '<small>
                Nama profile : ' . $v_data->nama_profile . '<br>
                Jenis kelamin : ' . $jenis_kelamin_profile . '<br>
                No. HP : ' . $v_data->nohp_profile . '<br>
                Gambar : <br>
                <img src="' . $gambar_profile . '" width="100px;" class="img-thumbnail"></img> <br>
                </small>
                ',
                '<img src="' . $gambar_penyakit . '" width="100px;" class="img-thumbnail"></img>',
                '
                <div class="text-center">
                    <a href="' . base_url('Front/Account/Riwayat/detail/' . $v_data->id_hasil) . '" class="btn btn-info btn-detail" data-id_hasil="' . $v_data->id_hasil . '" title="Detail perhitungan">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="' . base_url('Front/Account/Riwayat/delete') . '" class="btn btn-danger btn-delete" data-id_hasil="' . $v_data->id_hasil . '">
                    <i class="fas fa-trash"></i>
                    </a>
                    <a href="' . base_url('Front/Account/Riwayat/detailPerhitungan/' . $v_data->id_hasil) . '" class="btn btn-primary">
                        <i class="fas fa-calculator"></i>
                    </a>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
}
