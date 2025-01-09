<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {

    public function get_all_kategori() {
        return $this->db->get('kategori')->result();
    }

    public function add_kategori($data) {
        return $this->db->insert('kategori', $data);
    }

    public function get_kategori_by_id($id) {
        return $this->db->get_where('kategori', ['id' => $id])->row();
    }

        public function update_kategori($id, $nama, $keterangan) {
            $data = array(
                'nama' => $nama,
                'keterangan' => $keterangan
            );
    
            $this->db->where('id', $id);
            return $this->db->update('kategori', $data); // Ganti 'categories' dengan 'kategori'
        }

    public function delete_kategori($id) {
        $this->db->where('id', $id);
        return $this->db->delete('kategori');
    }
}