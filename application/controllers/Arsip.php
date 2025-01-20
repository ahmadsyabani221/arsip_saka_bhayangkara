<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arsip extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Arsip_model');
        $this->load->helper(['url', 'file', 'download']);
        
        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        // Ambil data arsip umum (untuk admin)
        $data['arsip'] = $this->Arsip_model->get_all_arsip();
        
        // Ambil data arsip berdasarkan user_id (untuk user)
        $data['arsip_user'] = $this->Arsip_model->get_arsip_by_user($user_id);
    
        // Cek role untuk menentukan tampilan
        if ($this->session->userdata('role') == 'admin') {
            $this->load->view('admin/admin_arsip_view', $data);
        } elseif ($this->session->userdata('role') == 'user') {
            $this->load->view('user_arsip_view', $data); // Kirim $data ke view
        } else {
            // Tambahkan kondisi lain jika diperlukan
            $this->load->view('default_view', $data); // Contoh
        }
    }

    public function add() {
        // Ambil data kategori dari database
        $data['kategori'] = $this->db->get('kategori')->result();
    
        // Kirim data kategori ke view
        $this->load->view('add_arsip_view', $data);
    }
    

    public function create() {
        if ($this->input->post()) {
            // Validasi input
            $this->load->library('form_validation');
            $this->form_validation->set_rules('nama_arsip', 'Nama Arsip', 'required');
            $this->form_validation->set_rules('kategori', 'Kategori', 'required');
            
            if ($this->form_validation->run() == FALSE) {
                // Tampilkan pesan error
                $this->session->set_flashdata('error', validation_errors());
                redirect('arsip/add'); // Redirect kembali ke form add arsip
            } else {
                // Ambil data dari input
                $nama_arsip = $this->input->post('nama_arsip');
                $kategori = $this->input->post('kategori');

                // Tentukan path untuk menyimpan file
                $upload_path = './uploads/';
                $file_name = basename($_FILES['file_path']['name']);
                $rand = uniqid(); // Menghasilkan ID unik
                $file_path = $upload_path . $rand . '_' . $file_name; // Menambahkan $rand ke nama file

                // Pindahkan file yang diupload
                if (move_uploaded_file($_FILES['file_path']['tmp_name'], $file_path)) {
                    // Data yang akan disimpan ke database
                    $data = [
                        'nama_arsip' => $nama_arsip,
                        'kategori' => $kategori,
                        'file_path' => $rand . '_' . $file_name, // Menyimpan nama file dengan $rand
                        'uploaded_by' => $this->session->userdata('user_id') // Mengambil ID user dari session
                    ];

                    // Menyimpan arsip ke database
                    if ($this->Arsip_model->insert_arsip($data)) {
                        $this->session->set_flashdata('success', 'Arsip berhasil ditambahkan.');
                        redirect('arsip');
                    } else {
                        $this->session->set_flashdata('error', 'Gagal menambahkan arsip ke database.');
                        redirect('arsip/add');
                    }
                } else {
                    // Jika gagal upload
                    $this->session->set_flashdata('error', 'Gagal mengupload file.');
                    redirect('arsip/add');
                }
            }
        }
    }

    public function edit($id) {
        $data['arsip'] = $this->Arsip_model->get_arsip_by_id($id);
        $data['kategori'] = $this->db->get('kategori')->result();
        $this->load->view('edit_arsip_view', $data);
    }

    public function update($id) {
        // Memuat model
        $this->load->model('Arsip_model');
        
        // Mendapatkan data arsip yang ada
        $arsip = $this->Arsip_model->get_arsip_by_id($id);
        
        $data = [
            'nama_arsip' => $this->input->post('nama_arsip'),
            'kategori' => $this->input->post('kategori'),
        ];
        
        // Tentukan path untuk menyimpan file
        $upload_path = './uploads/';
        
        // Cek apakah ada file baru yang diunggah
        if (isset($_FILES['file_path']) && $_FILES['file_path']['error'] == 0) {
            $file_name = basename($_FILES['file_path']['name']);
            $rand = uniqid(); // Menghasilkan ID unik
            $file_path = $upload_path . $rand . '_' . $file_name; // Menambahkan $rand ke nama file
    
            if (move_uploaded_file($_FILES['file_path']['tmp_name'], $file_path)) {
                // Jika ada file baru, ganti file lama
                $data['file_path'] = $rand . '_' . $file_name; // Menyimpan nama file dengan $rand
                
                // Hapus file lama dari folder jika ada
                if (!empty($arsip->file_path) && file_exists($upload_path . $arsip->file_path)) {
                    unlink($upload_path . $arsip->file_path);
                }
            } else {
                // Jika gagal upload
                $this->session->set_flashdata('error', 'Gagal mengupload file baru.');
                redirect('arsip/edit/' . $id);
                return; // Hentikan eksekusi lebih lanjut
            }
        } else {
            // Jika tidak ada file baru, tetap gunakan file lama
            $data['file_path'] = $arsip->file_path; // Pertahankan file lama
        }
        
        // Perbarui arsip di database
        if ($this->Arsip_model->update_arsip($id, $data)) {
            $this->session->set_flashdata('success', 'Arsip berhasil diperbarui.');
            redirect('arsip');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui arsip.');
            redirect('arsip/edit/' . $id);
        }
    }

    public function delete($id) {
        $arsip = $this->Arsip_model->get_arsip_by_id($id);

        // Hapus file dari folder jika ada
        if (!empty($arsip->file_path) && file_exists('./uploads/' . $arsip->file_path)) {
            unlink('./uploads/' . $arsip->file_path);
        }

        if ($this->Arsip_model->delete_arsip($id)) {
            $this->session->set_flashdata('success', 'Arsip berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus arsip.');
        }
        redirect('arsip');
    }

    // Menampilkan detail arsip
    public function view($id) {
        $data['arsip'] = $this->Arsip_model->get_arsip_by_id($id);
        if (!$data['arsip']) {
            show_404(); // Jika arsip tidak ditemukan, tampilkan halaman 404
        }
        $this->load->view('arsip_detail_view', $data);
    }

    public function kirim($arsip_id) {
        // Ambil data arsip berdasarkan ID
        $data['arsip'] = $this->Arsip_model->get_arsip_by_id($arsip_id);
    
        // Ambil semua user dari database
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
    
        // Tampilkan halaman kirim
        $this->load->view('arsip/kirim', $data);
    }

    public function pilih_user($arsip_id) {
        // Ambil semua user
        $this->load->model('User_model');
        $data['users'] = $this->User_model->get_all_users();
    
        // Ambil data arsip
        $data['arsip'] = $this->Arsip_model->get_arsip_by_id($arsip_id);
    
        // Tampilkan halaman pilih user
        $this->load->view('arsip/pilih_user', $data);
    }
    
    public function proses_kirim($arsip_id) {
        // Ambil user yang dipilih dari form
        $user_ids = $this->input->post('user_ids');
    
        if (!empty($user_ids)) {
            // Simpan relasi arsip dan user ke database
            foreach ($user_ids as $user_id) {
                $this->Arsip_model->kirim_arsip_ke_user($arsip_id, $user_id);
            }
    
            // Set pesan sukses
            $this->session->set_flashdata('success', 'Arsip berhasil dikirim ke user yang dipilih.');
        } else {
            // Set pesan gagal
            $this->session->set_flashdata('error', 'Tidak ada user yang dipilih.');
        }
    
        // Redirect kembali ke halaman kirim_arsip
        redirect('arsip/kirim/' . $arsip_id);
    }
    public function user_arsip() {
        $user_id = $this->session->userdata('user_id');

    // Ambil data arsip user
    $data['arsip_user'] = $this->Arsip_model->get_user_arsip($user_id);

        $this->load->view('user_arsip_view', $data); // Tampilkan view
    }    
}