<?php

class User_model extends CI_Model {  
    // Validasi login pengguna (user atau admin)  
    public function validate($username, $password, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
        $query = $this->db->get_where($table, ['username' => $username, 'password' => $password]);  
        return $query->row();  
    }  
  
    // Ambil semua pengguna  
    public function get_all_users($is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
        return $this->db->get($table)->result();  
    }  
  
    // Ambil pengguna berdasarkan ID  
    public function get_user_by_id($user_id, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
        $this->db->where('id', $user_id);  
        return $this->db->get($table)->row();  
    }  
  
    // Hitung total pengguna  
    public function count_all_users($is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
        return $this->db->count_all($table);  
    }  
  
    // Ambil pengguna berdasarkan login terakhir  
    public function get_last_logins($is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
        $this->db->select('username, last_login');  
        $this->db->from($table);  
        $this->db->order_by('last_login', 'DESC');  
        $this->db->limit(10); // Ambil 10 pengguna terakhir  
        return $this->db->get()->result_array();  
    }  
  
    // Update last_login hanya untuk login/logout  
    public function update_last_login($id, $last_login, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
  
        if (!$id || !$last_login) {  
            log_message('error', 'update_last_login called with invalid parameters');  
            return false;  
        }  
  
        $this->db->where('id', $id);  
        $this->db->update($table, ['last_login' => $last_login]);  
  
        if ($this->db->affected_rows() == 0) {  
            log_message('error', "Failed to update last_login for user_id: $id in table $table");  
        }  
  
        return $this->db->affected_rows() > 0; // Return true jika berhasil  
    }  
  
    // Tambah pengguna baru  
    public function add_user($data, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
  
        // Filter kolom last_login agar tidak ikut diinsert  
        unset($data['last_login']);  
  
        // Filter kolom yang diperbolehkan di-insert  
        $allowed_columns = ['username', 'email', 'role', 'password', 'profile_picture'];  
        $data = array_filter(  
            $data,  
            function ($key) use ($allowed_columns) {  
                return in_array($key, $allowed_columns);  
            },  
            ARRAY_FILTER_USE_KEY  
        );  
  
        return $this->db->insert($table, $data);  
    }  
  
    // Update pengguna  
    public function update_user($id, $data, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
  
        // Filter kolom yang diperbolehkan di-update  
        $allowed_columns = ['username', 'email', 'role', 'password', 'profile_picture'];  
        $data = array_filter(  
            $data,  
            function ($key) use ($allowed_columns) {  
                return in_array($key, $allowed_columns);  
            },  
            ARRAY_FILTER_USE_KEY  
        );  
  
        if (!empty($data)) {  
            $this->db->where('id', $id);  
            return $this->db->update($table, $data);  
        }  
  
        return false; // Tidak ada kolom yang di-update  
    }  
  
    // Hapus pengguna  
    public function delete_user($id, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
        $this->db->where('id', $id);  
        return $this->db->delete($table);  
    }  
  
    // Update password dengan validasi MD5  
    public function update_password($user_id, $new_password, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
  
        $this->db->set('password', $new_password); // Hashing md5 sudah dilakukan di controller  
        $this->db->where('id', $user_id);  
        $this->db->update($table);  
  
        return $this->db->affected_rows() > 0;  
    }  
  
    // Update password dengan hashing aman  
    public function update_password_secure($user_id, $old_password, $new_password, $is_admin = false) {  
        $table = $is_admin ? 'admins' : 'users'; // Tentukan tabel berdasarkan parameter  
  
        $this->db->where('id', $user_id);  
        $user = $this->db->get($table)->row();  
  
        if ($user && password_verify($old_password, $user->password)) {  
            if (strlen($new_password) < 6) {  
                return false; // Password baru terlalu pendek  
            }  
  
            $this->db->set('password', password_hash($new_password, PASSWORD_DEFAULT));  
            $this->db->where('id', $user_id);  
            $this->db->update($table);  
            return true;  
        }  
  
        return false; // Password lama tidak cocok  
    }  
}  
