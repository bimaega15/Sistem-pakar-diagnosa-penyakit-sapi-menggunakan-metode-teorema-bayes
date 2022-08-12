<?php
class Hasil_model extends CI_Model
{
    public function get($id = null, $users_id = null)
    {
        $this->db->select('*');
        $this->db->from('hasil h');
        $this->db->join('penyakit p', 'p.id_penyakit = h.penyakit_id');
        $this->db->join('users u', 'u.id_users = h.users_id');
        $this->db->join('profile pf', 'pf.users_id = u.id_users');
        if ($id != null) {
            $this->db->where('h.id_hasil', $id);
        }
        if ($users_id != null) {
            $this->db->where('u.id_users', $users_id);
        }
        return $this->db->get();
    }
    public function update($data, $id_hasil)
    {
        $this->db->where('id_hasil', $id_hasil);
        $this->db->update('hasil', $data);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('hasil', $data);
        return $this->db->insert_id();
    }

    public function delete($id_hasil)
    {
        $this->db->delete('hasil', ['id_hasil' => $id_hasil]);
        return $this->db->affected_rows();
    }
}
