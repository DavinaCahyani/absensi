<?php
class M_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function get_data($table) {
        return $this->db->get($table);
    }
    function getwhere($table, $data)
    {
        return $this->db->get_where($table, $data);
    }
    function delete($table, $field, $id)
    {
        $data=$this->db->delete($table, array($field => $id));
        return $data;
    }
    function tambah_data($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    function get_by_id($tabel, $id_column, $id)
    {
        $data=$this->db->where($id_column, $id)->get($tabel);
        return $data;
    }
    public function ubah_data($table, $data, $where)
    {
        // Fungsi untuk mengubah data dalam tabel
        $this->db->where($where);
        return $this->db->update($table, $data);
    }
    public function get_by_column($table, $column, $value)
    {
        return $this->db->get_where($table, array($column => $value));
    }
    public function checkAbsensiExists($absen, $tanggal)
    {
        $this->db->select('id_karyawan');
        $this->db->from('absen');
        $this->db->where('id_karyawan', $absen);
        $this->db->where('DATE(date)', $tanggal);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        }
        return false;
    }
    public function getHistoriKaryawan() {
        // Gantilah 'histori_karyawan' dengan nama tabel histori karyawan Anda.
        $query = $this->db->get('absen');

        // Kembalikan data dalam bentuk array.
        return $query->result();
    }
    public function getDataKaryawan() {
        // Gantilah 'histori_karyawan' dengan nama tabel histori karyawan Anda.
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('role', 'karyawan');
        $query = $this->db->get();

        // Kembalikan data dalam bentuk array.
        return $query->result();
    }
    public function get_total_karyawan() {
        // Gantilah 'histori_karyawan' dengan nama tabel histori karyawan Anda.
        $this->db->select('COUNT(*) as total_karyawan');
        $this->db->from('user');
        $this->db->where('role', 'karyawan');
        $query = $this->db->get();
    
        // Kembalikan hasil perhitungan jumlah karyawan dalam bentuk angka.
        $result = $query->row();
        return $result->total_karyawan;
    }
    
    public function getAbsenById($absen_id)
    {
        // Fungsi untuk mengambil data absen berdasarkan ID
        $query = $this->db->get_where('absen', array('id' => $absen_id));
        return $query->row_array();
    }
    
    // Mendapatkan data absen berdasarkan ID karyawan
    public function getAbsenByKaryawan($id_karyawan) {
        return $this->db->get_where('absen', ['id_karyawan' => $id_karyawan])->row();
    }
    public function update($table, $data, $where)
    {
        $data = $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }


    // Update data absen
    public function updateAbsen($id_karyawan, $data) {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->update('absen', $data);
    }
    public function getStatusAbsen($id_karyawan, $tanggal) {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $result = $this->db->get('absen')->row();

        if ($result) {
            return $result->status;
        }

        // Jika tidak ada data absen untuk tanggal tersebut, maka karyawan belum absen
        return 'belum_absen';
    }

    public function updateStatusAbsen($id_karyawan, $tanggal, $status) {
        $data = array('status' => $status);
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('date', $tanggal);
        $this->db->update('absen', $data);
    }
    public function getbulanan($bulan) {
        $this->db->select('*');
        $this->db->from('absen');
        $this->db->where("DATE_FORMAT(absen.date, '%Y-%m') =", $bulan);
        $query = $this->db->get();
        return $query->result();
    }
    public function get_bulanan($date)
    {
        $this->db->from('absen');
        $this->db->where("DATE_FORMAT(absen.date, '%m') =", $date);
        $query = $this->db->get();
        return $query->result();
    }

    public function getRekapBulanan($bulan) {
        $this->db->select('MONTH(date) as bulan, COUNT(*) as total_absensi');
        $this->db->from('absen');
        $this->db->where('MONTH(date)', $bulan); // Menyaring data berdasarkan bulan
        $this->db->group_by('bulan');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getRekapHarian($tanggal) {
        // Gantilah 'nama_tabel' dengan nama tabel yang sesuai di database Anda
        $this->db->select('*');
        $this->db->from('absen');
        $this->db->where('date', $tanggal); // Menyaring berdasarkan tanggal

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array(); // Mengembalikan array kosong jika tidak ada data yang ditemukan
        }
    }
    public function getAbsensiLast7Days() {
        $this->load->database();
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-7 days', strtotime($end_date)));        
        $query = $this->db->select('date, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status, id_karyawan, COUNT(*) AS total_absences')
                          ->from('absen')
                          ->where('date >=', $start_date)
                          ->where('date <=', $end_date)
                          ->group_by('date, kegiatan, jam_masuk, jam_pulang, keterangan_izin, status, id_karyawan')
                          ->get();
        return $query->result();
    }
    
function get_absensi_by_karyawan($id_karyawan)
    {
        $this->db->where('id_karyawan', $id_karyawan);
        return $this->db->get('absen')->result();
    }
    public function count_total_absensi($id_karyawan) {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('keterangan_izin =', '-'); // Memeriksa kolom 'keterangan_izin' yang tidak kosong

        return $this->db->get('absen')->num_rows();
    }
    
    public function count_total_izin($id_karyawan) {
        $this->db->where('id_karyawan', $id_karyawan);
        $this->db->where('keterangan_izin !=', '-'); // Memeriksa kolom 'keterangan_izin' yang tidak kosong
        return $this->db->get('absen')->num_rows();
    }
    
    public function get_password_by_user_id($user) {
        $this->db->select('password');
        $this->db->where('id', $user);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->password;
        }

        return null; // Kembalikan null jika user_id tidak ditemukan
    }
    public function count_total_absensi_admin()
    {
        $this->db->where('keterangan_izin =', '-');

        return $this->db->get('absen')->num_rows();
    }

    public function count_total_izin_admin()
    {
        $this->db->where('keterangan_izin !=', '-');
        
        return $this->db->get('absen')->num_rows();

    }
    public function count_total_absen_izin_admin()
{
    $total_absen = $this->db->where('keterangan_izin =', '-')->get('absen')->num_rows();
    $total_izin = $this->db->where('keterangan_izin !=', '-')->get('absen')->num_rows();
    
    // Gabungkan jumlah absen dan izin untuk mendapatkan total keseluruhan
    $total_keseluruhan = $total_absen + $total_izin;
    
    return $total_keseluruhan;
}

}
?>