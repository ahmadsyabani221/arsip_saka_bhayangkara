<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Cek apakah pengguna login sebagai admin
        if ($this->session->userdata('role') != 'admin') {
            redirect('auth/login');
        }
        $this->load->model('User_model'); // Memuat model pengguna
        $this->load->model('Arsip_model'); // Memuat model arsip
        $this->load->model('Kategori_model'); // Memuat Model Kategori
    }

    // Dashboard Admin
    public function index() {

        // Ambil data pengumuman dari database
        $data['announcements'] = $this->get_announcements();
        
        //data lainnya
        $data['total_users'] = $this->User_model->count_all_users(); // Menghitung total pengguna
        $data['total_arsip'] = $this->Arsip_model->count_all_arsip(); // Menghitung total arsip
        $data['recent_users'] = $this->User_model->get_recent_users(); // Mendapatkan pengguna terbaru
        $data['recent_arsip'] = $this->Arsip_model->get_recent_arsip(); // Mendapatkan arsip terbaru

        $this->load->view('admin_dashboard', $data); // Memuat tampilan dashboard admin
    }

    // Halaman Manajemen Pengguna
    public function users() {
        $data['users'] = $this->User_model->get_all_users(); // Mendapatkan semua pengguna
        $this->session->set_userdata('previous_url', current_url()); // Simpan URL saat ini di session
        $this->load->view('admin/users', $data); // Memuat tampilan pengguna
    }

    // Halaman Tambah Pengguna
    public function add_user() {
        if ($this->input->post()) {
            $data = array(
                'username' => $this->input->post('username'), // Ganti 'name' dengan 'username'
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'role' => $this->input->post('role')
            );

            // Memanggil metode add_user di User_model
            if ($this->User_model->add_user($data)) {
                redirect('admin/users'); // Redirect setelah sukses
            } else {
                $data['error'] = 'Gagal menambahkan pengguna.';
            }
        }
    
        // Memuat view untuk menambahkan pengguna
        $this->load->view('admin/add_user', isset($data) ? $data : null);
    }

    // Proses Menambah Pengguna
    public function save_user() {
        $data = array(
            'username'  => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')), // Enkripsi password dengan MD5
            'role'  => $this->input->post('role'),
        );

        $this->User_model->add_user($data); // Menyimpan pengguna baru
        redirect('admin/users'); // Mengarahkan kembali ke halaman pengguna
    }

    public function edit_user($id) {
        // Mendapatkan pengguna berdasarkan ID
        $data['user'] = $this->User_model->get_user_by_id($id);
    
        // Jika pengguna tidak ditemukan, tampilkan halaman 404
        if (empty($data['user'])) {
            show_404();
        }
    
        // Cek jika form disubmit
        if ($this->input->post()) {
            $update_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'role' => $this->input->post('role'),
            );
    
            // Hanya update password jika diisi
            if (!empty($this->input->post('password'))) {
                $update_data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT); // Enkripsi password
            }
    
            // Memperbarui pengguna
            $this->User_model->update_user($id, $update_data);
    
            // Redirect setelah berhasil
            redirect('admin/users');
        }
    
        // Memuat tampilan edit pengguna
        $this->load->view('admin/edit_user', $data);
    }
        
    // Proses Update Pengguna
    public function update_user($id) {
        $data = array(
            'username'  => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'role'  => $this->input->post('role'),
        );

        // Hanya update password jika diisi
        if ($this->input->post('password')) {
            $data['password'] = md5($this->input->post('password')); // Enkripsi password dengan MD5
        }

        $this->User_model->update_user($id, $data); // Memperbarui pengguna
        redirect('admin/users'); // Mengarahkan kembali ke halaman pengguna
    }

// Hapus Pengguna
public function delete_user($id) {
    // Menghapus pengguna berdasarkan ID
    $this->db->where('user_id', $id);
    $this->db->delete('arsip_user');
    
    $this->User_model->delete_user($id); 
    
    // Kembali ke halaman managemen pengguna
    redirect('admin/users');
}

    // Halaman Manajemen Arsip
    public function arsip() {
        $data['arsip'] = $this->Arsip_model->get_all_arsip(); // Mendapatkan semua arsip
        $data['users'] = $this->User_model->get_all_users(); // Mendapatkan semua pengguna
        $this->load->view('admin/arsip', $data); // Memuat tampilan arsip
    }

    // Halaman Tambah Arsip
    public function add_arsip() {
        $this->load->view('arsip/add_arsip'); // Memuat tampilan tambah arsip
    }

    // Proses Menambah Arsip
    public function save_arsip() {
        $data = array(
            'nama_arsip' => $this->input->post('nama_arsip'),
            'file_path'  => $this->input->post('file_path'), // Pastikan Anda mengatur upload file
        );

        $this->Arsip_model->add_arsip($data); // Menyimpan arsip baru
        redirect('admin/arsip'); // Mengarahkan kembali ke halaman arsip
    }

    // Halaman Edit Arsip
    public function edit_arsip($id) {
        $data['arsip'] = $this->Arsip_model->get_arsip_by_id($id); // Mendapatkan arsip berdasarkan ID
        if (empty($data['arsip'])) {
            show_404(); // Menampilkan halaman 404 jika arsip tidak ditemukan
        }
        $this->load->view('admin/edit_arsip', $data); // Memuat tampilan edit arsip
    }

    // Proses Update Arsip
    public function update_arsip($id) {
        $data = array(
            'nama_arsip' => $this->input->post('nama_arsip'),
            'file_path'  => $this->input->post('file_path'), // Pastikan Anda mengatur upload file
        );

        $this->Arsip_model->update_arsip($id, $data); // Memperbarui arsip
        redirect('admin/arsip'); // Mengarahkan kembali ke halaman arsip
    }

    // Hapus Arsip
    public function delete_arsip($id) {
        $this->Arsip_model->delete_arsip($id); // Menghapus arsip berdasarkan ID
        redirect('admin/arsip'); // Mengarahkan kembali ke halaman arsip
    }

        // Halaman Manajemen Kategori
        public function kategori() {
            $data['categories'] = $this->Kategori_model->get_all_kategori(); // Mendapatkan semua kategori
            $this->load->view('kategori/index', $data); // Memuat tampilan kategori
        }
    
        // Halaman Tambah Kategori
        public function add_category() {
            if ($this->input->post()) {
                $data = [
                    'nama' => $this->input->post('nama'),
                    'keterangan' => $this->input->post('keterangan') // Menyimpan keterangan
                ];
                $this->Kategori_model->add_kategori($data);
                redirect('admin/kategori'); // Redirect setelah sukses
            }
            $this->load->view('kategori/add'); // Memuat view untuk menambahkan kategori
        }
    
        // Halaman Edit Kategori
        public function edit_category($id) {
        // Ambil data kategori berdasarkan ID
        $data['category'] = $this->Kategori_model->get_kategori_by_id($id);
    
        // Jika kategori tidak ditemukan, tampilkan halaman 404
        if (empty($data['category'])) {
            show_404();
        }

        // Cek jika form disubmit
        if ($this->input->post()) {
        // Ambil data dari form
        $nama = $this->input->post('nama');
        $keterangan = $this->input->post('keterangan');
        
        // Update kategori di database
        $this->Kategori_model->update_kategori($id, $nama, $keterangan); // Memanggil dengan tiga argumen
        
        // Mengarahkan kembali ke halaman kategori setelah sukses
        redirect('admin/kategori');
        }

        // Memuat tampilan edit kategori
            $this->load->view('kategori/edit', $data);
    }
    
        // Hapus Kategori
        public function delete_category($id) {
            $this->Kategori_model->delete_kategori($id); // Menghapus kategori berdasarkan ID
            redirect('admin/kategori'); // Mengarahkan kembali ke halaman kategori
        }

        public function add_announcement()
        {
            $announcement = $this->input->post('announcement');
            if (!empty($announcement)) {
                $this->db->insert('announcements', ['text' => $announcement]);
                $this->session->set_flashdata('success', 'Pengumuman berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Pengumuman tidak boleh kosong.');
            }
            redirect('dashboard');
        }
        
        public function delete_announcement($id)
        {
            $this->db->delete('announcements', ['id' => $id]);
            $this->session->set_flashdata('success', 'Pengumuman berhasil dihapus.');
            redirect('dashboard');
        }
        
    
}