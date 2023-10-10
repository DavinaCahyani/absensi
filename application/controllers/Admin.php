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
}