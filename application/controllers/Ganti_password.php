<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ganti_password extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model'); // Pastikan model ini ada
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('ganti_password');
    }

    public function proses() {
        $this->form_validation->set_rules('old_password', 'Password Lama', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password Baru', 'required|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kembali ke form
            $this->load->view('ganti_password');
        } else {
            // Ambil data dari form
            $old_password = $this->input->post('old_password');
            $new_password = $this->input->post('new_password');
            
            // Verifikasi password lama
            $user_id = $this->session->userdata('user_id');
            $user = $this->user_model->get_user_by_id($user_id);
            
            if ($user && $user->password === md5($old_password)) { // Verifikasi dengan md5
                // Update password baru dengan md5
                $update_result = $this->user_model->update_password($user_id, md5($new_password));
                
                if ($update_result) {
                    $this->session->set_flashdata('message', 'Password berhasil diubah.');
                    redirect('dashboard'); // Ganti dengan URL dashboard Anda
                } else {
                    $this->session->set_flashdata('error', 'Gagal mengubah password. Silakan coba lagi.');
                    redirect('ganti_password');
                }
            } else {
                $this->session->set_flashdata('error', 'Password lama salah.');
                redirect('ganti_password');
            }
        }
    }
}