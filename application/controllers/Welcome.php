<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Tidak perlu memuat model atau session di sini jika dashboard sudah terpisah
    }

    // Fungsi untuk menampilkan halaman welcome awal
    public function index()
    {
        $this->load->view('welcome_message');
    }
}
