<?php

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Arsip_model');
        
        // Cek apakah pengguna sudah login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        // Ambil data pengguna dari session
        $data['user'] = $this->session->userdata();
    
        // Ambil username dan role dari session
        $data['username'] = $data['user']['username']; // Pastikan 'username' ada di session
        $data['role'] = $data['user']['role']; // Pastikan 'role' ada di session
    
        // Ambil total arsip
        $data['total_arsip'] = $this->Arsip_model->count_total_arsip();
    
        // Ambil total pengguna
        $data['total_users'] = $this->User_model->count_all_users();
       
        // Ambil data last logins
        $data['last_logins'] = $this->User_model->get_last_logins();
    
        if ($data['role'] == 'admin') {
            // Admin Dashboard
            $data['announcements'] = $this->db->get('announcements')->result_array();
            $data['arsip'] = $this->Arsip_model->get_all_arsip();
            $data['users'] = $this->User_model->get_all_users();
            $this->load->view('admin/admin_dashboard', $data);
        } else {
            // User Dashboard
            $data['announcements'] = $this->db->get('announcements')->result_array();
            $data['arsip'] = $this->Arsip_model->get_all_arsip();
            $this->load->view('user_dashboard', $data);
        }
    }
    
}