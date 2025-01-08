<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Pastikan pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model('User_model');
        $this->load->helper(['form', 'url']);
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');  // Ambil ID pengguna dari session
        $user = $this->User_model->get_user_by_id($user_id);  // Ambil data pengguna dari model
        if ($user) {
            $data['user'] = $user;
    
            // Cek apakah pengguna adalah admin/petugas
            if ($this->session->userdata('role') === 'admin' || $this->session->userdata('role') === 'petugas') {
                $this->load->view('admin/profile_view', $data);  // Tampilkan view untuk admin/petugas
            } else {
                $this->load->view('user_profile_view', $data);  // Tampilkan view untuk pengguna biasa
            }
        } else {
            show_404();  // Jika tidak ada pengguna, tampilkan halaman 404
        }
    }

    public function update_profile($id) {
        // Mendapatkan data pengguna yang ada
        $user = $this->User_model->get_user_by_id($id);
        
        // Jika pengguna tidak ditemukan, tampilkan 404
        if (!$user) {
            show_404();
            return;
        }
    
        // Ambil data dari input
        $data = [
            'username' => $this->input->post('username'), // Ganti 'name' dengan 'username'
            'email' => $this->input->post('email'),
        ];
    
        // Tentukan path untuk menyimpan file
        $upload_path = './uploads/profile_pics/';
    
        // Cek apakah ada file baru yang diunggah
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $file_name = basename($_FILES['profile_picture']['name']);
            $rand = uniqid();
            $file_path = $upload_path . $rand . '_' . $file_name;
    
            // Buat direktori jika belum ada
            if (!is_dir($upload_path)) {
                mkdir($upload_path, 0755, true);
            }
    
            // Pindahkan file yang diunggah
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
                $data['profile_picture'] = $rand . '_' . $file_name;
    
                // Hapus file lama dari folder jika ada
                if (!empty($user->profile_picture) && file_exists($upload_path . $user->profile_picture)) {
                    unlink($upload_path . $user->profile_picture);
                }
            } else {
                // Jika gagal upload
                $this->session->set_flashdata('error', 'Gagal mengupload foto profil baru.');
                redirect('profile/edit/' . $id);
                return; // Hentikan eksekusi lebih lanjut
            }
        } else {
            // Jika tidak ada file baru, tetap gunakan foto lama
            $data['profile_picture'] = $user->profile_picture; // Pertahankan foto lama
        }
    
        // Perbarui profil di database
        if ($this->User_model->update_user($id, $data)) {
            $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
            redirect('profile'); // Redirect ke halaman profil
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui profil.');
            redirect('profile/edit/' . $id);
        }
    }

    public function update_password() {
        $user_id = $this->session->userdata('user_id');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        // Validasi password
        if ($new_password === $confirm_password) {
            // Proses update password
            if ($this->User_model
            ->update_password($user_id, $old_password, $new_password)) {
                $this->session->set_flashdata('success', 'Password updated successfully!');
            } else {
                $this->session->set_flashdata('error', 'Old password is incorrect!');
            }
        } else {
            $this->session->set_flashdata('error', 'Passwords do not match!');
        }
        redirect('profile');
    }

    public function change_profile_picture() {
        // Proses upload foto
        $config['upload_path'] = './uploads/profile_pics/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 1024; // Maksimal ukuran file 1MB
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('profile_picture')) {
            $file_data = $this->upload->data();
            $user_id = $this->session->userdata('user_id');
            $this->User_model
            ->update_profile_picture($user_id, $file_data['file_name']);
            $this->session->set_flashdata('success', 'Profile picture updated!');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }
        redirect('profile');
    }

    public function forgot_password() {
        // Halaman untuk lupa password
        $this->load->view('forgot_password');
    }

    public function reset_password() {
        $email = $this->input->post('email');
        $user  = $this->User_model->get_user_by_email($email);

        if ($user) {
            // Proses reset password, misalnya dengan mengirim email
            // Anda dapat menambahkan logika untuk mengirim email di sini
            $this->session->set_flashdata('success', 'Password reset link sent to your email!');
        } else {
            $this->session->set_flashdata('error', 'Email not found!');
        }

        redirect('profile/forgot_password');
    }
}
?>