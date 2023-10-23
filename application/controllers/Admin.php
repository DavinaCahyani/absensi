<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Admin extends CI_Controller {
    function __construct()
    {
        parent::  __construct();
  $this->load->model('m_model');
  $this->load->helper('my_helper');;
  $this->load->helper('html');
  $this->load->library('upload');


  if($this->session->userdata('logged_in')!=true || $this->session->userdata('role') != 'admin') {
    redirect(base_url().'auth');
}
    }
    // Metode ini digunakan untuk menampilkan halaman profil admin.
    public function profil()
	{
		$data['user'] = $this->m_model->get_by_id('user', 'id', $this->session->userdata('id'))->result();
		$this->load->view('admin/profil', $data);
	}
	// Metode ini digunakan untuk menampilkan rekap keseluruhan data absensi karyawan.
	public function rekap_keseluruhan()
	{
        $data['absen'] = $this->m_model->getHistoriKaryawan();

		$this->load->view('admin/rekap_keseluruhan', $data);
	}
    // Metode ini digunakan untuk menampilkan data karyawan.
	public function data_karyawan()
	{
        $data['user'] = $this->m_model->getDataKaryawan();

		$this->load->view('admin/data_karyawan', $data);
	}
    // Metode ini digunakan untuk menampilkan rekap bulanan data absensi karyawan berdasarkan bulan yang dipilih.
    public function rekap_bulanan() {
        $bulan = $this->input->post('bulan'); // Mengambil bulan dari input form
        $data['absen'] = $this->m_model->get_bulanan($bulan); // menyeseuaikan dengan fungsi yang sesuai
        $this->session->set_flashdata('bulan', $bulan);
        $this->load->view('admin/rekap_bulanan', $data);
    }
    // Metode ini digunakan untuk menampilkan rekap harian data absensi karyawan berdasarkan tanggal yang dipilih.
    public function rekap_harian() {
        $tanggal = $this->input->get('tanggal'); // Mengambil tanggal dari formulir
        $data['absen'] = $this->m_model->getRekapHarian($tanggal); // Mengambil data berdasarkan tanggal
        $this->session->set_flashdata('tanggal', $tanggal);
         $this->load->view('admin/rekap_harian', $data);
    }
    // Metode ini digunakan untuk menampilkan rekap mingguan data absensi karyawan dalam 7 hari terakhir.
	public function rekap_mingguan() {
        $data['absen'] = $this->m_model->getAbsensiLast7Days();        
        $this->load->view('admin/rekap_mingguan', $data);
    }
    // Metode ini digunakan untuk mengubah profil admin, termasuk mengganti email, username, nama, dan password.
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
            $this->session->set_flashdata('error_password_lama', '*Password lama salah');
            redirect(base_url('admin/profil'));
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
                $this->session->set_flashdata('konfirmasi_password', '*Password baru dan konfirmasi password harus sama');
                redirect(base_url('admin/profil'));
            }
        }
    
        $this->session->set_userdata($data);
        $update_result = $this->m_model->ubah_data('user', $data, array('id' => $this->session->userdata('id')));
    
        if ($update_result) {
            redirect(base_url('admin/profil'));
        } else {
            echo 'error';
            // redirect(base_url('admin/profil'));
        }
    }
    
public function hapus_karyawan($id)
{
   $this->m_model->delete('user', 'id', $id);
    redirect(base_url('admin/data_karyawan'));
}
public function hapus_absen($id)
{ 
    $this->m_model->delete('absen', 'id_karyawan', $id); 
    switch($this->uri->segment(2)){
        case 'rekap_keseluruhan':
            redirect(base_url('admin/rekap_keseluruhan')); 
        case 'rekap_harian':
            redirect(base_url('admin/rekap_harian')); 
        case 'rekap_mingguan':
            redirect(base_url('admin/rekap_mingguan'));
        default:
        redirect(base_url('admin/rekap_mingguan')); 
    }
}

// Upload image
// Metode ini digunakan untuk mengunggah gambar profil admin.
public function upload_image_admin($value)
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
// Metode ini digunakan untuk menghandle aksi pengunggahan gambar profil admin.
public function aksi_image()
{
    $foto = $this->upload_image_admin('foto');
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
        redirect(base_url('admin/profil'));
    }
    else
    {
        $this->session->set_flashdata('error', 'gagal..');
        redirect(base_url('admin/profil'));
    }
    }
}
// Metode ini digunakan untuk mengekspor data karyawan ke dalam format Excel (XLSX).
    public function export_data_karyawan()
	{
		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
            ];
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $sheet->setCellValue('A1', "DATA KARYAWAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "NAMA");
        $sheet->setCellValue('C3', "EMAIL");

       
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);

        $data= $this->m_model->getDataKaryawan();
      
        $no= 1;
        $numrow = 4;
        foreach($data as $data) {
            
        $sheet->setCellValue('A'.$numrow,$no);
        $sheet->setCellValue('B'.$numrow,$data->username);
        $sheet->setCellValue('C'.$numrow,$data->email); 

        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);

        $no++;
        $numrow++;

        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);


        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->SetTitle("LAPORAN DATA KARYAWAN");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DATA KARYAWAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
	}
    // Metode ini digunakan untuk mengekspor rekap bulanan data absensi karyawan ke dalam format Excel (XLSX).
    public function export_rekap_bulanan()
    {
        // Ambil data rekap bulanan dari model sesuai bulan yang dipilih
        $bulan = $this->session->flashdata('bulan');
        $data = $this->m_model->get_bulanan($bulan);
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
            ];
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $sheet->setCellValue('A1', "REKAP BULANAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "KEGIATAN");
        $sheet->setCellValue('C3', "TANGGAL");
        $sheet->setCellValue('D3', "JAM MASUK");
        $sheet->setCellValue('E3', "JAM PULANG");
        $sheet->setCellValue('F3', "KETERANGAN");
        $sheet->setCellValue('G3', "STATUS");

       
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        $data = $this->m_model->get_bulanan($bulan);

      
        $no= 1;
        $numrow = 4;
        foreach($data as $data) {
            
        $sheet->setCellValue('A'.$numrow,$no);
        $sheet->setCellValue('B'.$numrow,$data->kegiatan);
        $sheet->setCellValue('C'.$numrow,$data->date); 
        $sheet->setCellValue('D'.$numrow,$data->jam_masuk); 
        $sheet->setCellValue('E'.$numrow,$data->jam_pulang); 
        $sheet->setCellValue('F'.$numrow,$data->keterangan_izin); 
        $sheet->setCellValue('G'.$numrow,$data->status); 

        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);

        $no++;
        $numrow++;

        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(35);
        $sheet->getColumnDimension('F')->setWidth(35);
        $sheet->getColumnDimension('G')->setWidth(40);


        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->SetTitle("LAPORAN REKAP BULANAN");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="REKAP BULANAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    // Metode ini digunakan untuk mengekspor rekap harian data absensi karyawan ke dalam format Excel (XLSX).
    public function export_rekap_harian()
    {
        // Ambil data rekap bulanan dari model sesuai bulan yang dipilih
        $tanggal = $this->session->flashdata('tanggal');
        $data = $this->m_model->getRekapHarian($tanggal);
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
            ];
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $sheet->setCellValue('A1', "REKAP HARIAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "KEGIATAN");
        $sheet->setCellValue('C3', "TANGGAL");
        $sheet->setCellValue('D3', "JAM MASUK");
        $sheet->setCellValue('E3', "JAM PULANG");
        $sheet->setCellValue('F3', "KETERANGAN");
        $sheet->setCellValue('G3', "STATUS");

       
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        $data = $this->m_model->getRekapHarian($tanggal);

      
        $no= 1;
        $numrow = 4;
        foreach($data as $data) {
            
        $sheet->setCellValue('A'.$numrow,$no);
        $sheet->setCellValue('B'.$numrow,$data->kegiatan);
        $sheet->setCellValue('C'.$numrow,$data->date); 
        $sheet->setCellValue('D'.$numrow,$data->jam_masuk); 
        $sheet->setCellValue('E'.$numrow,$data->jam_pulang); 
        $sheet->setCellValue('F'.$numrow,$data->keterangan_izin); 
        $sheet->setCellValue('G'.$numrow,$data->status); 

        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);

        $no++;
        $numrow++;

        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(45);
        $sheet->getColumnDimension('G')->setWidth(50);


        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->SetTitle("LAPORAN REKAP HARIAN");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="REKAP HARIAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    // Metode ini digunakan untuk mengekspor rekap mingguan data absensi karyawan ke dalam format Excel (XLSX).
    public function export_rekap_mingguan()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $style_row = [
            'font' => ['bold' => true],
            'alignment' => [
                'vertical' =>
                    \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' =>
                        \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet->setCellValue('A1', 'REKAP MINGGUAN');
        $sheet->mergeCells('A1:G1');
        $sheet
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);

        $sheet->setCellValue('A3', 'NO');
        $sheet->setCellValue('B3', 'KEGIATAN');
        $sheet->setCellValue('C3', 'TANGGAL');
        $sheet->setCellValue('D3', 'JAM MASUK');
        $sheet->setCellValue('E3', 'JAM PULANG');
        $sheet->setCellValue('F3', 'KETERANGAN');
        $sheet->setCellValue('G3', 'STATUS');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        $data = $this->m_model->getAbsensiLast7Days();

        $no = 1;
        $numrow = 4;
        foreach ($data as $row) {
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $row->kegiatan);
            $sheet->setCellValue('C' . $numrow, $row->date);
            $sheet->setCellValue('D' . $numrow, $row->jam_masuk);
            $sheet->setCellValue('E' . $numrow, $row->jam_pulang);
            $sheet->setCellValue('F' . $numrow, $row->keterangan_izin);
            $sheet->setCellValue('G' . $numrow, $row->status);

            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('F' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('G' . $numrow)->applyFromArray($style_row);

            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(35);

        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet
            ->getPageSetup()
            ->setOrientation(
                \PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE
            );

        $sheet->setTitle('REKAP MINGGUAN');

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );
        header('Content-Disposition: attachment; filename="REKAP MINGGUAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    } 
    // Metode ini digunakan untuk mengekspor rekap keseluruhan data absensi karyawan ke dalam format Excel (XLSX).
    public function export_rekap_keseluruhan()
    {
        // Ambil data rekap bulanan dari model sesuai bulan yang dipilih
        $data = $this->m_model->getHistoriKaryawan();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
            ];
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ]
        ];

        $sheet->setCellValue('A1', "REKAP KESELURUHAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "KEGIATAN");
        $sheet->setCellValue('C3', "TANGGAL");
        $sheet->setCellValue('D3', "JAM MASUK");
        $sheet->setCellValue('E3', "JAM PULANG");
        $sheet->setCellValue('F3', "KETERANGAN");
        $sheet->setCellValue('G3', "STATUS");

       
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);

        $data = $this->m_model->getHistoriKaryawan();

      
        $no= 1;
        $numrow = 4;
        foreach($data as $data) {
            
        $sheet->setCellValue('A'.$numrow,$no);
        $sheet->setCellValue('B'.$numrow,$data->kegiatan);
        $sheet->setCellValue('C'.$numrow,$data->date); 
        $sheet->setCellValue('D'.$numrow,$data->jam_masuk); 
        $sheet->setCellValue('E'.$numrow,$data->jam_pulang); 
        $sheet->setCellValue('F'.$numrow,$data->keterangan_izin); 
        $sheet->setCellValue('G'.$numrow,$data->status); 

        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);

        $no++;
        $numrow++;

        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(45);
        $sheet->getColumnDimension('G')->setWidth(50);


        $sheet->getDefaultRowDimension()->setRowHeight(-1);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        $sheet->SetTitle("LAPORAN REKAP KESELURUHAN");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="REKAP KESELURUHAN.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    
}
?>