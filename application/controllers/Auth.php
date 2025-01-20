<?php

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        // Cegah caching halaman login
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
    
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
    
        // Proses login...
        if ($this->form_validation->run() == FALSE) {
            // Tampilkan form login...
            $this->load->view('login_view');
        } else {
            // Proses login berhasil...
            $username = $this->input->post('username');
            $password = $this->input->post('password');
    
            // Cari user berdasarkan username dan password
            $user = $this->User_model->get_user($username, $password);
    
            // Perbarui last_login
            $this->User_model->update_last_login($user->id, date('Y-m-d H:i:s'));
            
            if ($user) {
                // Simpan data user ke session
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('user_id', $user->id);
                $this->session->set_userdata('username', $user->username);

                // Redirect ke dashboard
                redirect('dashboard');

            } else {
                // Tampilkan pesan error
                $this->session->set_flashdata('error', 'Username atau password salah');
                $this->load->view('auth/login_view');
            }
        }
    }

    public function validate_login() {
        $username = $this->input->post('username');
        $password = md5($this->input->post('password')); // Hash password menggunakan md5

        // Validasi pengguna
        $user = $this->User_model->validate($username, $password);
        if ($user) {
            // Set session data
            $session_data = array(
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'logged_in' => true
            );
            $this->session->set_userdata($session_data);

            // Redirect berdasarkan role
            if ($user->role == 'admin') {
                redirect('dashboard'); // Redirect ke dashboard admin
            } else {
                redirect('dashboard'); // Redirect ke dashboard user biasa
            }
        } else {
            // Jika login gagal
            $this->session->set_flashdata('error', 'Username atau password salah');
            redirect('auth/login'); // Kembali ke halaman login
        }
    }

    public function logout() {  
        // Ambil user_id dari session  
        $user_id = $this->session->userdata('user_id');  
      
        // Perbarui last_login sebelum menghapus session  
        if ($user_id) {  
            $this->User_model->update_last_login($user_id, date('Y-m-d H:i:s')); // Menggunakan waktu saat ini  
        }  
      
        // Hapus session  
        $this->session->sess_destroy();  
      
        // Redirect ke halaman login  
        redirect('auth/login');  
    }  
    
    
    
public function update_password()
{
    $user_id = $this->input->post('user_id');
    $password = $this->input->post('password');
    $confirm_password = $this->input->post('confirm_password');

    if ($password === $confirm_password) {
        $this->User_model->update_password($user_id, $password);
        $this->session->set_flashdata('message', 'Password berhasil diubah. Silakan login.');
        redirect('auth/login');
    } else {
        $this->session->set_flashdata('message', 'Password tidak cocok!');
        redirect('auth/reset_password/' . $token);
    }
}
}
?>