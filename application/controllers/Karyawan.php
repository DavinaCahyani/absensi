<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
	
    function __construct()
    {
        parent::  __construct();
        $this->load->model('m_model');
        $this->load->helper('my_helper');;
        $this->load->helper('html');
        $this->load->library('upload');
        if($this->session->userdata('logged_in')!=true || $this->session->userdata('role') != 'karyawan') {
            redirect(base_url().'auth');
}
    }

    public function karyawan()
{
    $id_karyawan = $this->session->userdata('id');
    $data['absen'] = $this->m_model->get_absensi_by_karyawan($id_karyawan);
    $data['absensi_count'] = count($data['absen']);
    
    // Hitung total absensi dan izin dengan benar
    $data['total_absen'] = $this->m_model->count_total_absensi($id_karyawan);
    $data['total_izin'] = $this->m_model->count_total_izin($id_karyawan);

    $this->load->view('karyawan/karyawan', $data);
}

    public function history_karyawan() {
        $id_karyawan = $this->session->userdata('id');
        $data['absen'] = $this->m_model->get_absensi_by_karyawan($id_karyawan);
        $data['absensi_count'] = count($data['absen']);

    // Memuat tampilan dan mengirimkan data
    $this->load->view('karyawan/history_karyawan', $data);
    }

    public function menu_absen()
    {
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
        'jam_izin' => '-',
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
    $jam = date('H:i:s', strtotime($current_datetime));
 
    $keterangan = $this->input->post('keterangan_izin'); 
    $data = [ 
        'id_karyawan' => $id_karyawan, 
        'kegiatan' => '-', 
        'date' => $tanggal, // Mengisi tanggal saat ini 
        'jam_masuk' => '', // Mengosongkan jam masuk 
        'jam_pulang' => '', // Mengosongkan jam pulang 
        'jam_izin' => $jam,  
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


   

public function aksi_ubah_profil() {
    // Mengambil input dari formulir
    $email = $this->input->post('email');
    $username = $this->input->post('username');
    $nama_depan = $this->input->post('nama_depan');
    $nama_belakang = $this->input->post('nama_belakang');
    $password_baru = $this->input->post('password_baru');
    $konfirmasi_password = $this->input->post('konfirmasi_password');
    $password_lama = $this->input->post('password_lama'); // Tambahkan input password lama

    // Mengambil data pengguna dari database berdasarkan ID pengguna yang disimpan dalam sesi
    $user_data = $this->m_model->getwhere('user', array('id' => $this->session->userdata('id')))->row_array();

    // Validasi password lama
    if (md5($password_lama) !== $user_data['password']) {
        $error_password_lama = '*Password lama salah' ; // Pesan kesalahan
        $this->session->set_flashdata('error_password_lama','*Password lama salah');

        redirect(base_url('karyawan/profil'));
    }

    // Buat data yang akan diubah
    $data = array(
        'email' => $email,
        'username' => $username,
        'nama_depan' => $nama_depan,
        'nama_belakang' => $nama_belakang
    );

    // Jika ada password baru
    if (!empty($password_baru)) {
        // Pastikan password baru dan konfirmasi password sama
        if ($password_baru === $konfirmasi_password) {
            // Hash password baru
            $data['password'] = md5($password_baru);
        } else {
            $this->session->set_flashdata('error_konfirmasi_password','*Password baru dan konfirmasi password harus sama');
        }
    }

    $this->session->set_userdata($data);
    $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));

    if ($update_result) {
        redirect(base_url('karyawan/profil'));
    } else {
        echo 'error';
        // redirect(base_url('karyawan/profil'));
    }
}
// Upload image
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
    public function aksi_image()
    {
        $foto = $this->upload_image_karyawan('foto');
        if($foto[0]!==false)
        {
            $data = array
            (
                'image' => $foto[1]
            );
            $masuk = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));
        if ($masuk)
        {
            $this->session->set_flashdata('sukses', 'berhasil');
            redirect(base_url('karyawan/profil'));
        }
        else
        {
            $this->session->set_flashdata('error', 'gagal..');
            redirect(base_url('karyawan/profil'));
        }
        }
    }

}
    
?>