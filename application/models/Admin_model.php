<?php

class Admin_model extends CI_Model {
    // Validasi login admin
    public function validate($username, $password) {
        $query = $this->db->get_where('admin', ['username' => $username, 'password' => $password]);
        return $query->row();
    }

    // Ambil semua admin
    public function get_all_admins() {
        return $this->db->get('admin')->result();
    }

    // Ambil admin berdasarkan ID
    public function get_admin_by_id($admin_id) {
        $this->db->where('id', $admin_id);
        return $this->db->get('admin')->row();
    }

    // Tambah admin baru
    public function add_admin($data) {
        return $this->db->insert('admin', $data);
    }

    // Update admin
    public function update_admin($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('admin', $data);
    }

    // Hapus admin
    public function delete_admin($id) {
        $this->db->where('id', $id);
        return $this->db->delete('admin');
    }

    // Update last_login admin
    public function update_last_login($id, $last_login) {
        $this->db->where('id', $id);
        $this->db->update('admin', ['last_login' => $last_login]);
        return $this->db->affected_rows() > 0;
    }
}
