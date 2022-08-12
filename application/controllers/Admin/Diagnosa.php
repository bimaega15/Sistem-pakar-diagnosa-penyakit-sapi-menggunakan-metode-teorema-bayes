<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diagnosa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_not_login();
        if (!$this->session->has_userdata('id_users')) {
            show_404();
        }
        $this->load->model(['Gejala/Gejala_model', 'Rule/Rule_model', 'RuleDetail/RuleDetail_model', 'ProbabilitasPakar/ProbabilitasPakar_model', 'Hasil/Hasil_model', 'HasilDetail/HasilDetail_model']);
    }
    public function index()
    {
        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Diagnosa', 'Admin/Diagnosa');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
        $data['title'] = 'Diagnosa';

        $this->template->admin('admin/diagnosa/main', $data);
    }

    public function loadData()
    {
        $put_diagnosa = $this->session->userdata('put_diagnosa');
        $data = $this->Gejala_model->get()->result();
        $result = [];
        $no = 1;
        if ($data == null) {
            $result['data'] = [];
        }
        foreach ($data as $index => $v_data) {
            $checkedPutGejala = checkedPutGejala($v_data->id_gejala, $put_diagnosa);

            $result['data'][] = [
                $no++,
                $v_data->kode_gejala,
                $v_data->nama_gejala,
                '
                <div class="text-center">
                  <div class="form-group">
                    <div class="form-check">
                        <input name="gejala_id" class="form-check-input gejala_id" type="checkbox" value="1" id="gejala_id' . $v_data->id_gejala . '" data-id_gejala="' . $v_data->id_gejala . '" ' . $checkedPutGejala . '>
                        <label class="form-check-label" for="gejala_id' . $v_data->id_gejala . '">
                        </label>
                    </div>
                  </div>
                </div>
                '
            ];
        }
        echo json_encode($result);
    }
    public function saveSession()
    {
        $gejala_id = htmlspecialchars($this->input->get('gejala_id', true));
        $value = htmlspecialchars($this->input->get('value', true));

        $arrGejala = [];
        if ($this->session->has_userdata('put_diagnosa')) {
            $getGejala = $this->session->userdata('put_diagnosa');
            if (!(in_array($gejala_id, $getGejala))) {
                array_push($getGejala, $gejala_id);
                $this->session->set_userdata('put_diagnosa', $getGejala);

                $putGejala = $this->session->userdata('put_diagnosa');
                $dataGejala = [
                    'status' => 'success',
                    'output' => 'Berhasil checked gejala',
                    'result' => $putGejala
                ];
            }

            if ($value == null) {
                $search = array_search($gejala_id, $getGejala);
                unset($_SESSION['put_diagnosa'][$search]);

                $dataGejala = [
                    'status' => 'success',
                    'output' => 'Unchecked gejala'
                ];
            }
        } else {
            if ($value != null) {
                $arrGejala[0] = $gejala_id;
                $this->session->set_userdata('put_diagnosa', $arrGejala);

                $putGejala = $this->session->userdata('put_diagnosa');
                $dataGejala = [
                    'status' => 'success',
                    'output' => 'Berhasil checked gejala',
                    'result' => $putGejala
                ];
            }
        }

        if (empty($this->session->userdata('put_diagnosa'))) {
            $this->session->unset_userdata('put_diagnosa');
        }

        echo json_encode($dataGejala);
    }
    public function submit()
    {
        $put_diagnosa = $this->session->userdata('put_diagnosa');
        if (empty($put_diagnosa)) {
            $this->session->set_flashdata('error', 'Anda belum memasukan gejala');
            return redirect(base_url('Admin/Diagnosa'));
        }


        $this->breadcrumbs->push('Home', 'Admin/Home');
        $this->breadcrumbs->push('Diagnosa', 'Admin/Diagnosa');
        $this->breadcrumbs->push('Submit', 'Admin/Submit');
        // output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
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
        $this->template->admin('admin/diagnosa/submit', $data);
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
            return redirect(base_url('Admin/Hasil'));
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpaan data hasil');
            return redirect(base_url('Admin/Hasil'));
        }
    }
}
