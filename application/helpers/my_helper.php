<?php

function tampil_nama_karyawan_byid($id)
{
    $ci = &get_instance();
    $ci->load->database();
    $result = $ci->db->where('id', $id)->get('user');
    foreach ($result->result() as $c) {
        $tmt = $c->nama_depan. ' ' . $c->nama_belakang;
        return $tmt;
    }
}

?>