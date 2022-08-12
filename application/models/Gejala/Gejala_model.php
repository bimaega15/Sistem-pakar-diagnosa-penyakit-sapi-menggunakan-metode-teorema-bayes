<?php
class Gejala_model extends CI_Model
{
    public function get($id = null, $arr_id = [])
    {
        $this->db->select('*');
        $this->db->from('gejala');
        if ($id != null) {
            $this->db->where('id_gejala', $id);
        }
        if (!empty($arr_id)) {
            $this->db->where_in('id_gejala', $arr_id);
        }
        return $this->db->get();
    }
    public function update($data, $id_gejala)
    {
        $this->db->where('id_gejala', $id_gejala);
        $this->db->update('gejala', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('gejala', $data);
        return $this->db->insert_id();
    }

    public function delete($id_gejala)
    {
        $this->db->delete('gejala', ['id_gejala' => $id_gejala]);
        return $this->db->affected_rows();
    }
    public function maxKode()
    {
        $this->db->select('max(kode_gejala) as max_kode_gejala');
        $this->db->from('gejala');
        return $this->db->get();
    }
}
