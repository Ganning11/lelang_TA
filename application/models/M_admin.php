<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

    function email($email)
    {
        $sql = "SELECT email FROM abe_admin WHERE email = '$email'";
        $user = $this->db->query($sql)->row_array();
        return $user;
    }

    function add_admin($data)
    {
        $this->db->insert('abe_admin',$data);
        return $this->db->insert_id();
    }

    function update_admin($where, $data)
    {
        $this->db->update('abe_admin', $data, $where);
        return $this->db->affected_rows();
    }

    function hapus_admin($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('abe_admin');
    }

    function update_pelelang($where, $data)
    {
        $this->db->update('abe_pelelang', $data, $where);
        return $this->db->affected_rows();
    }

    function update_bidder($where, $data)
    {
        $this->db->update('users', $data, $where);
        return $this->db->affected_rows();
    }

    public function detail_pelelang($id)
    {
        $param = array('id_user' => $id);
        return $this->db->get_where('abe_pelelang',$param);
    }
}