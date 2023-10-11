<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	
    function __construct()
    {
        parent::  __construct();
  $this->load->model('m_model');
  $this->load->helper('my_helper');;
        if ($this->session->userdata('logged_in')!=true) {
            redirect(base_url().'auth');
        }  
    }

    public function admin()
    {
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('admin/admin');
    }
    public function karyawan()
    {
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('admin/karyawan');
    }
    public function history_karyawan()
    {
        $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('admin/history_karyawan');
    }
    public function menu_absen()
    {
        // $data['absen'] = $this->m_model->get_data('absen')->result();
        $this->load->view('admin/menu_absen');
    }
    public function aksi_menu_absen()
    {
        $data=[
            'id_karyawan' => $this->input->post('nama_karyawan'),
            'kegiatan' => $this->input->post('kegiatan'),
            'date' => $this->input->post('date'),
            'jam_masuk' => $this->input->post('jam_masuk'),
            'jam_pulang' => $this->input->post('jam_pulang'),
            'keterangan_izin' => $this->input->post('keterangan_izin'),
            'status' => $this->input->post('status'),
        ];
        $this->m_model->tambah_data('absen', $data);
        redirect(base_url('admin/history_karyawan'));
    }
}
?>