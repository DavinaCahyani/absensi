<?php
class M_model extends CI_Model {
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

}
?>