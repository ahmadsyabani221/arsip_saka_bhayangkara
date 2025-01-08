<?php
class Arsip_model extends CI_Model {
    
    // Menghitung total arsip
    public function count_total_arsip() {
        return $this->db->count_all('arsip'); // Menghitung total arsip dari tabel 'arsip'
    }

    // Mengambil semua arsip
    public function get_all_arsip() {
        return $this->db->get('arsip')->result();
    }

    // Mengambil arsip berdasarkan ID
    public function get_arsip_by_id($id) {
        return $this->db->get_where('arsip', array('id' => $id))->row();
    }

    // Model Arsip_model
public function get_arsip_by_user($user_id) {
    $this->db->select('arsip_user.*, arsip.nama_arsip, arsip.kategori, arsip.file_path, arsip.created_at');
    $this->db->from('arsip_user');
    $this->db->join('arsip', 'arsip_user.arsip_id = arsip.id'); // Join dengan tabel arsip
    $this->db->where('arsip_user.user_id', $user_id); // Filter berdasarkan user_id
    $query = $this->db->get();
    return $query->result();
}
    // Mengambil Data arsip terbaru
    public function get_arsip_terbaru() {
        $this->db->order_by('id', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get('arsip');
        return $query->result();
    }

    // Menambah arsip baru
    public function insert_arsip($data) {
        // Tambahkan created_at saat menambah arsip baru
        $data['created_at'] = date('Y-m-d H:i:s'); // Set timestamp saat menambahkan arsip
        return $this->db->insert('arsip', $data);
    }

    // Memperbarui data arsip
    public function update_arsip($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('arsip', $data);
    }

    // Menghapus arsip
    public function delete_arsip($id) {
        $this->db->where('id', $id);
        $this->db->delete('arsip');
    }

    // Mengambil arsip berdasarkan nama
    public function get_arsip_by_name($nama_arsip) {
        $this->db->like('nama_arsip', $nama_arsip);
        return $this->db->get('arsip')->result();
    }

    // Memeriksa apakah ada arsip yang diupload oleh user tertentu
    public function is_uploaded_by_exists($user_id) {
        $this->db->where('uploaded_by', $user_id);
        $query = $this->db->get('arsip');
        return $query->num_rows() > 0; // Mengembalikan true jika ada arsip yang diupload
    }

    // Mengambil arsip terbaru
    public function get_latest_arsip($limit = 5) {
        $this->db->order_by('created_at', 'DESC'); // Urutkan berdasarkan created_at
        $this->db->limit($limit); // Batasi jumlah arsip yang diambil
        return $this->db->get('arsip')->result(); // Mengembalikan arsip terbaru
    }

    // Update status arsip
    public function update_status($id, $status) {
        $this->db->set('status', $status);
        $this->db->where('id', $id);
        return $this->db->update('arsip'); // Ganti 'arsip' dengan nama tabel yang sesuai
    }

    // Mengambil arsip berdasarkan status
    public function get_arsip_by_status($status) {
        $this->db->where('status', $status);
        return $this->db->get('arsip')->result();
    }

    // Mengambil arsip dengan pagination
    public function get_arsip_paginated($limit, $offset) {
        $this->db->limit($limit, $offset);
        return $this->db->get('arsip')->result();
    }

    // Mengambil arsip berdasarkan kategori
    public function get_arsip_by_kategori($kategori) {
        $this->db->where('kategori', $kategori);
        return $this->db->get('arsip')->result();
    }
    public function kirim_arsip_ke_user($arsip_id, $user_id) {
        $data = [
            'arsip_id' => $arsip_id,
            'user_id' => $user_id
        ];
        return $this->db->insert('arsip_user', $data);
    }
    
    public function get_user_arsip($user_id) {
        // Select semua kolom dari arsip dan tambahkan informasi tambahan jika diperlukan
        $this->db->select('arsip.*, 
                           users.nama as nama_pengirim, 
                           arsip_user.created_at as tanggal_diterima');
        $this->db->from('arsip_user');
        
        // Join dengan tabel arsip
        $this->db->join('arsip', 'arsip_user.arsip_id = arsip.id');
        
        // Optional: Join dengan tabel users untuk mendapatkan nama pengirim
        $this->db->join('users', 'arsip.uploaded_by = users.id', 'left');
        
        // Filter berdasarkan user_id
        $this->db->where('arsip_user.user_id', $user_id);
        
        // Optional: Tambahkan order by
        $this->db->order_by('arsip_user.created_at', 'DESC');
        
        // Eksekusi query dan kembalikan hasilnya
        return $this->db->get()->result();
    }
}