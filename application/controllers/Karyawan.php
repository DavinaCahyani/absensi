<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
	
    function __construct()
    {
        parent::  __construct();
  $this->load->model('m_model');
  $this->load->helper('my_helper');;
  $this->load->helper('html');

        if ($this->session->userdata('logged_in')!=true) {
            redirect(base_url().'auth');
        }  
    }

    // public function admin()
    // {
    //     // $data['absen'] = $this->m_model->get_data('absen')->result();
    //     $this->load->view('admin/admin');
    // }
    public function karyawan()
    {
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('karyawan/karyawan');
    }
    // Contoh dalam controller Karyawan.php
    public function history_karyawan() {
    // Mengambil data histori karyawan (contoh menggunakan model)
    $data['absen'] = $this->m_model->getHistoriKaryawan();

    // Memuat tampilan dan mengirimkan data
    $this->load->view('karyawan/history_karyawan', $data);
}

    public function menu_absen()
    {
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $id_karyawan = $this->session->userdata('id');
        $this->load->view('karyawan/menu_absen');
    }
    
    public function izin()
    {
        
        $this->load->view('karyawan/izin');
    }

    
    public function profil()
	{
		$data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
		$this->load->view('karyawan/profil', $data);
	}
	public function ubah_absen($id)
{
    // Ambil data absen berdasarkan ID yang akan diubah
    $data['absen'] = $this->m_model->getAbsenById($id);
    $this->load->view('karyawan/ubah_absen', $data);
}

public function aksi_ubah_absen() { 
    $id = $this->input->post('id'); 
    $kegiatan = $this->input->post('kegiatan'); 

    $data = [
        'kegiatan' => $kegiatan,
    ];

    $this->m_model->update('absen', $data, array('id'=>$id)); 
    redirect(base_url('karyawan/history_karyawan')); 
    $this->session->set_flashdata('berhasil_ubah_absen', 'Berhasil mengubah kegiatan atau keterangan izin'); 
}
public function aksi_ubah_izin() { 
    $id = $this->input->post('id'); 
    $keterangan_izin = $this->input->post('keterangan_izin'); 

    $data = [
        'keterangan_izin' => $keterangan_izin,
    ];

    $this->m_model->update('absen', $data, array('id'=>$id)); 
    redirect(base_url('karyawan/history_karyawan')); 
    $this->session->set_flashdata('berhasil_ubah_absen', 'Berhasil mengubah kegiatan atau keterangan izin'); 
}



public function aksi_menu_absen()
{
    $id_karyawan = $this->session->userdata('id');
    date_default_timezone_set('Asia/Jakarta');
    $current_datetime = date('Y-m-d H:i:s');
    $absen = $this->session->userdata('id'); // Ambil ID Karyawan dari sesi atau cara lain yang sesuai.

    $tanggal = date('Y-m-d', strtotime($current_datetime));
    $jam = date('H:i:s', strtotime($current_datetime));

    $kegiatan = $this->input->post('kegiatan'); // Ambil jenis kegiatan dari form
    $keterangan_izin = $this->input->post('keterangan_izin'); // Ambil keterangan izin dari form

    // Jika kegiatan adalah "izin," maka setel keterangan izin sesuai input; jika tidak, setel keterangan izin menjadi "-"
    $keterangan_izin = ($kegiatan == 'izin') ? $keterangan_izin : '-';

    $data = [
        'id_karyawan' => $id_karyawan,
        'kegiatan' => $kegiatan,
        'date' => $tanggal,
        'jam_masuk' => $jam,
        'jam_pulang' => '-',
        'keterangan_izin' => $keterangan_izin, // Menyimpan keterangan izin yang diisi oleh pengguna atau "-"
        'status' => 'Not'
    ];

    // Cek apakah karyawan sudah absen pada tanggal yang sama sebelumnya
    $hasSubmittedAbsensi = $this->m_model->checkAbsensiExists($absen, date('Y-m-d'));

    if (!$hasSubmittedAbsensi) {
        $this->m_model->tambah_data('absen', $data);
    } else {
        // Karyawan sudah absen pada hari ini, Anda dapat menangani ini sesuai kebutuhan Anda
    }

    redirect(base_url('karyawan/history_karyawan'));
}

    
public function aksi_izin()
{
    $id_karyawan = $this->session->userdata('id');
    date_default_timezone_set('Asia/Jakarta');
    $current_datetime = date('Y-m-d H:i:s');
    $absen = $this->session->userdata('id'); // Ambil ID Karyawan dari sesi atau cara lain yang sesuai.

    $tanggal = date('Y-m-d', strtotime($current_datetime));

    $kegiatan = $this->input->post('kegiatan'); // Ambil jenis kegiatan dari form
    $keterangan_izin = $this->input->post('keterangan_izin'); // Ambil keterangan izin dari form

    // Inisialisasi variabel keterangan
    $keterangan = '';

    // Periksa apakah jenis kegiatan adalah "izin"
    if ($kegiatan == 'izin') {
        // Jika izin, atur kegiatan menjadi kosong dan keterangan diisi dengan "izin"
        $kegiatan = '';
        $keterangan = 'izin';
    } else {
        // Jika jenis kegiatan bukan "izin," tetapkan keterangan sesuai dengan input
        $keterangan = $keterangan_izin;
    }

    $data = [
        'id_karyawan' => $id_karyawan,
        'kegiatan' => $kegiatan,
        'date' => $tanggal, // Mengisi tanggal saat ini
        'jam_masuk' => '', // Mengosongkan jam masuk
        'jam_pulang' => '', // Mengosongkan jam pulang
        'keterangan_izin' => $keterangan, // Menyimpan keterangan izin yang diisi oleh pengguna atau "izin" jika jenis kegiatan adalah "izin"
        'status' => 'Done' // Mengubah status menjadi "Done"
    ];

    // Cek apakah karyawan sudah absen pada tanggal yang sama sebelumnya
    $hasSubmittedAbsensi = $this->m_model->checkAbsensiExists($absen, date('Y-m-d'));

    if (!$hasSubmittedAbsensi) {
        $this->m_model->tambah_data('absen', $data);
    } else {
        // Karyawan sudah absen pada hari ini, Anda dapat menangani ini sesuai kebutuhan Anda
    }

    redirect(base_url('karyawan/history_karyawan'));
}

public function aksi_pulang($id)
{
    date_default_timezone_set('Asia/Jakarta');
    $waktu_sekarang = date('Y-m-d H:i:s');
    
    // Pisahkan tanggal dan waktu
    list($date, $waktu) = explode(' ', $waktu_sekarang);

    $data = [
        'date' => $date, // Menggunakan tanggal yang telah dipisahkan
        'jam_pulang' => $waktu, // Menggunakan waktu yang telah dipisahkan
        'status' => 'Done'
    ];

    $this->m_model->update('absen', $data, array('id'=> $id));
    redirect(base_url('karyawan/history_karyawan'));
}


    public function hapus_karyawan($id)
    {
       $this->m_model->delete('absen', 'id_karyawan', $id);
        redirect(base_url('karyawan/history_karyawan'));
    }

    public function aksi_ubah_profil() {
        // Mengambil data pengguna dari sesi
        $user = $this->session->userdata('user');

        if ($user) {
            // Mengambil input dari formulir
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $nama_depan = $this->input->post('nama_depan');
            $nama_belakang = $this->input->post('nama_belakang');
            $password_baru = $this->input->post('password_baru');
            $konfirmasi_password = $this->input->post('konfirmasi_password');

            // Mengganti data pengguna sesuai input
            $user['email'] = $email;
            $user['username'] = $username;
            $user['nama_depan'] = $nama_depan;
            $user['nama_belakang'] = $nama_belakang;
            $user['password_baru'] = $password_baru;
            $user['konfirmasi_password'] = $konfirmasi_password;

            // Mengganti password jika ada input password baru
            if (!empty($password_baru)) {
                // Pastikan password baru dan konfirmasi password sama
                if ($password_baru === $konfirmasi_password) {
                    // Hash password baru (gunakan algoritma yang sesuai)
                    $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
                    $user['password_baru'] = $hashed_password;
                } else {
                    $this->session->set_flashdata('message', 'Password baru dan konfirmasi password harus sama');
                    redirect(base_url('karyawan/profil'));
                }
            }

            // Menyimpan data pengguna yang telah diubah kembali ke sesi
            $this->session->set_userdata('user', $user);

            // Redirect ke halaman profil setelah menyimpan perubahan
            redirect(base_url('karyawan/profil'));
        } else {
            // Handle jika data pengguna tidak tersedia di sesi
            $this->session->set_flashdata('message', 'Data pengguna tidak tersedia.');
            redirect(base_url('karyawan/profil'));
        }
    }
   // Upload image
   public function upload_img($value)
   {
       $kode = round(microtime(true) * 1000);
       $config['upload_path'] = './images/siswa/';
       $config['allowed_types'] = 'jpg|png|jpeg';
       $config['max_size'] = '30000';
       $config['file_name'] = $kode;
       
       $this->load->library('upload', $config); // Load library 'upload' with config
       
       if (!$this->upload->do_upload($value)) {
           return array(false, '');
       } else {
           $fn = $this->upload->data();
           $nama = $fn['file_name'];
           return array(true, $nama);
       }
   }

    public function upload_image_karyawan($value)
    {
        $kode = round(microtime(true) * 1000);
        $config['upload_path'] = './images/karyawan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 30000;
        $config['file_name'] = $kode;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($value)) {
            return [false, ''];
        } else {
            $fn = $this->upload->data();
            $nama = $fn['file_name'];
            return [true, $nama];
        }
    }

}
    
?>