<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
	
    function __construct()
    {
        parent::  __construct();
  $this->load->model('m_model');
  $this->load->helper('my_helper');;
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
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('karyawan/izin');
    }
    public function profil()
    {
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('karyawan/profil');
    }
    public function aksi_menu_absen()
    {
        $id_karyawan = $this->session->userdata('id');
        date_default_timezone_set('Asia/Jakarta');
        $current_datetime = date('Y-m-d H:i:s');
        $absen = $this->session->userdata('id'); // Ambil ID Karyawan dari sesi atau cara lain yang sesuai.

        $tanggal = date('Y-m-d', strtotime($current_datetime));
        $jam = date('H:i:s', strtotime($current_datetime));

        $data = [
            'id_karyawan' => $id_karyawan,
            'kegiatan' => $this->input->post('kegiatan'),
            'date' => $tanggal, // Mengisi tanggal saat ini
            'jam_masuk' => $jam, // Mengisi jam masuk saat ini
            'jam_pulang' => '', // Mengosongkan jam pulang awalnya
            'status' => 'Not' // Status default
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
    public function aksi_pulang()
    {
        $id_karyawan = $this->input->post('id_karyawan');
        
        // Set zona waktu ke "Asia/Jakarta"
        date_default_timezone_set('Asia/Jakarta');
        
        $current_datetime = date('Y-m-d H:i:s');
        
        list($date, $time) = explode(' ', $current_datetime);
    
        $absen = $this->m_model->getAbsenByKaryawan($id_karyawan);
        
        if ($absen->status != 'Done') {
            $data = [
                'jam_pulang' => $time, // Menggunakan waktu saat ini
                'status' => 'Done'
            ];
            $this->m_model->updateAbsen($absen->id_karyawan, $data);
        }
        
        redirect(base_url('karyawan/history_karyawan'));
    }
    public function hapus_karyawan($id)
    {
       $this->m_model->delete('absen', 'id_karyawan', $id);
        redirect(base_url('karyawan/history_karyawan'));
    }

    
    
}
?>