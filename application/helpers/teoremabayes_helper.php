<?php
class TeoremaBayes
{
    public function __construct()
    {
    }
    public function gejalaYangDitimbulkan($put_diagnosa)
    {
        $ci = &get_instance();
        $ci->load->model('Gejala/Gejala_model');
        $getPutDiagnosa = $ci->Gejala_model->get(null, $put_diagnosa)->result();
        return $getPutDiagnosa;
    }
    public function aturRule($put_diagnosa)
    {
        $getGejala = [];
        $ci = &get_instance();
        $ci->load->model('ProbabilitasPakar/ProbabilitasPakar_model');
        $getRule = $ci->ProbabilitasPakar_model->get(null, $put_diagnosa)->result();
        foreach ($getRule as $key => $vDiagnosa) {
            $getGejala[$vDiagnosa->penyakit_id][] = $vDiagnosa;
        }
        return $getGejala;
    }
    public function nProbPerEvidence($getGejala)
    {
        $nProbPerEvidence = [];
        foreach ($getGejala as $penyakit_id => $vDiagnosa) {
            $total = 0;
            foreach ($vDiagnosa as $index => $value) {
                $total += $value->bobot_probabilitas_pakar;
            }
            $nProbPerEvidence[$penyakit_id] = $total;
        }
        return $nProbPerEvidence;
    }
    public function nProbHnotEvidence($getGejala, $nProbPerEvidence)
    {
        $nProbHnotEvidence = [];
        foreach ($getGejala as $penyakit_id => $vDiagnosa) {
            foreach ($vDiagnosa as $index => $value) {
                $nProbHnotEvidence[$penyakit_id][$value->gejala_id] = $value->bobot_probabilitas_pakar / $nProbPerEvidence[$penyakit_id];
            }
        }
        return $nProbHnotEvidence;
    }
    public function nProbAwalHnotEvidence($getGejala, $nProbHnotEvidence)
    {
        $nProbAwalHnotEvidence = [];
        foreach ($getGejala as $penyakit_id => $vDiagnosa) {
            $total = 0;
            foreach ($vDiagnosa as $index => $value) {
                $hitung = $value->bobot_probabilitas_pakar * $nProbHnotEvidence[$penyakit_id][$value->gejala_id];
                $total += $hitung;
            }
            $nProbAwalHnotEvidence[$penyakit_id] = $total;
        }
        return $nProbAwalHnotEvidence;
    }
    public function probHBenarWithE($getGejala, $nProbHnotEvidence, $nProbAwalHnotEvidence)
    {
        $probHBenarWithE = [];
        foreach ($getGejala as $penyakit_id => $vDiagnosa) {
            foreach ($vDiagnosa as $index => $value) {
                $gejala = $value->bobot_probabilitas_pakar;
                $nProbNotE =  $nProbHnotEvidence[$penyakit_id][$value->gejala_id];
                $hitung = $gejala * $nProbNotE;

                $hitungHE = ($gejala * $hitung) / $nProbAwalHnotEvidence[$penyakit_id];
                $probHBenarWithE[$penyakit_id][$value->gejala_id] = $hitungHE;
            }
        }
        return $probHBenarWithE;
    }
    public function kesimpulanNProb($getGejala, $probHBenarWithE)
    {
        $kesimpulanNProb = [];
        foreach ($getGejala as $penyakit_id => $vDiagnosa) {
            $total = 0;
            foreach ($vDiagnosa as $index => $value) {
                $hitung = $value->bobot_probabilitas_pakar * $probHBenarWithE[$penyakit_id][$value->gejala_id];
                $total += $hitung;
            }
            $kesimpulanNProb[$penyakit_id] = $total;
        }
        return $kesimpulanNProb;
    }
    public function hasilPenyakit($kesimpulanNProb)
    {
        $max_hasil = max($kesimpulanNProb);
        $penyakit = array_search($max_hasil, $kesimpulanNProb);
        $hasil_penyakit = check_penyakit_id($penyakit);
        $solusi = check_solusi(null, $penyakit)->result();
        $tingkat_keyakinan = $kesimpulanNProb[$penyakit];
        return [
            'max_hasil' => $max_hasil,
            'penyakit' => $penyakit,
            'hasil_penyakit' => $hasil_penyakit,
            'solusi' => $solusi,
            'tingkat_keyakinan' => $tingkat_keyakinan,
        ];
    }
}
