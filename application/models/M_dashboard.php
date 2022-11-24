<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	//var $table = 'tbl_user';
    function email($email)
    {
        $sql = "SELECT email FROM abe_pelelang WHERE email = '$email'";
        $user = $this->db->query($sql)->row_array();
        return $user;
    }

    function daftar_member($data)
    {
        $this->db->insert('abe_pelelang',$data);
        return $this->db->insert_id();
    }

    function verifikasi($key)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $data = array(
            'status' => 'aktif',
            'tgl_aktif' => $date,
        );
        $this->db->where('md5(id_user)', $key);
        $this->db->update('abe_pelelang', $data);
        return true;
    }

	function cekLogin($email, $password){
		$sql = "SELECT * FROM abe_pelelang
				WHERE email = '$email' and password = '$password'";
		$user1 = $this->db->query($sql)->row_array();
		return $user1;
	}

    function cekLogin2($email, $password){
        $sql = "SELECT * FROM abe_pelelang
                WHERE email = '$email' and password = '$password' and status = 'aktif'";
        $user2 = $this->db->query($sql)->row_array();
        return $user2;
    }

    function cekLogin_admin($email, $password){
        $sql = "SELECT * FROM abe_admin
                WHERE email = '$email' and password = '$password'";
        $user1 = $this->db->query($sql)->row_array();
        return $user1;
    }

    function cekLogin2_admin($email, $password){
        $sql = "SELECT * FROM abe_admin
                WHERE email = '$email' and password = '$password' and status = 'aktif'";
        $user2 = $this->db->query($sql)->row_array();
        return $user2;
    }

    function reset($email, $password)
    {
        $data = array('password' => $password);
        $this->db->where('email', $email);
        $this->db->update('abe_pelelang', $data);
        return true;
    }
    
    public function profile_pelelang($id)
    {
        $param = array('id_user' => $id);
        return $this->db->get_where('abe_pelelang',$param);
    }

    public function update_pelelang($data, $user) 
    {
        $this->db->where('id_user', $user);
        $this->db->update('abe_pelelang', $data);
    }

    public function id_foto($user)
    {
        $this->db->from('abe_pelelang');
        $this->db->where('foto',$user);
        $query = $this->db->get();
        return $query->row();
    }

    public function hapus_foto($data, $user) 
    {
        $this->db->where('id_user', $user);
        $this->db->update('abe_pelelang', $data);
    }
}