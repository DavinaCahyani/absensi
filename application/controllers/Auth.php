<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class auth extends CI_Controller {

    // function __construct()
	// {
	// parent::__construct();
	// $this->load->model('m_model');
	// $this->load->helper('my_helper');
    // }

    
	public function index()
	{
		$this->load->view('auth/login');
	}

	public function register()
	{
		$this->load->view('auth/register');
	}
	public function register_admin()
	{
		$this->load->view('auth/register_admin');
	}


	public function aksi_login()
{
    $email = $this->input->post('email', true);
    $password = $this->input->post('password', true);
    $data = [
        'email' => $email,
    ];
    $query = $this->m_model->getwhere('admin', $data);
    $result = $query->row_array();

    if (!empty($result) && md5($password) === $result['password']) {
        // Periksa apakah pengguna memiliki peran (role) 'admin'
        if ($result['role'] === 'admin') {
            $data = [
                'logged_in' => TRUE,
                'email' => $result['email'],
                'username' => $result['username'],
                'role' => $result['role'],
                'id' => $result['id'],
            ];
            $this->session->set_userdata($data);
            redirect(base_url()."admin");
        } else {
            // Tampilkan pesan kesalahan jika pengguna bukan admin
            $this->session->set_flashdata('error', 'Anda tidak memiliki izin untuk login.');
            redirect(base_url().'auth');
        }
    } else {
        // Tampilkan pesan kesalahan kepada pengguna jika login gagal
        $this->session->set_flashdata('error', 'Email atau kata sandi salah.');
        redirect(base_url().'auth');
    }
}

// public function aksi_register()
// {
//     $this->load->library('form_validation');
    
//     // Formulir masukan validasi
//     $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|is_unique[admin.username]');
//     $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
//     $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

//     if ($this->form_validation->run() == FALSE) {
//       // Jika validasi gagal, maka akan kembali formulir pendaftaran
//         $this->load->view('auth/register');
//     } else {
//         // Jika validasi berhasil, simpan data ke database
//         $username = $this->input->post('username', true);
//         $email = $this->input->post('email', true);
//         $password = md5($this->input->post('password', true));

//         // Tetapkan peran menjadi 'admin' di sini untuk pendaftaran admin
//         $role = 'admin';

//         $data = [
//             'username' => $username,
//             'email' => $email,
//             'password' => $password,
//             'role' => $role, // Tetapkan peran sebagai 'admin' di sini
//         ];

//         $this->m_model->tambah_data('admin', $data);

//       // Redirect ke halaman login atau lokasi lain yang sesuai
//         redirect(base_url('auth'));
//     }
// }


function logout() {
    $this->session->sess_destroy(); // Menggunakan sess_destroy() untuk mengakhiri sesi
    redirect(base_url('auth'));
   }  
}
?>