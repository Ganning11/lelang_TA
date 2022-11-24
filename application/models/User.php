<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model{
    function __construct() {
        $this->tableName = 'users';
        $this->primaryKey = 'id';
    }
    public function checkUser($data = array()){
        $this->db->select($this->primaryKey);
        $this->db->from($this->tableName);
        $this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
        $query = $this->db->get();
        $check = $query->num_rows();
        
        if($check > 0){
            $result = $query->row_array();
            $data['modified'] = date("Y-m-d H:i:s");
            $update = $this->db->update($this->tableName,$data,array('id'=>$result['id']));
            $userID = $result['id'];
        }else{
            $data['created'] = date("Y-m-d H:i:s");
            $data['modified']= date("Y-m-d H:i:s");
            $insert = $this->db->insert($this->tableName,$data);
            $userID = $this->db->insert_id();
        }

        return $userID?$userID:false;
    }

    function email($email)
    {
        $sql = "SELECT email FROM users WHERE email = '$email'";
        $user = $this->db->query($sql)->row_array();
        return $user;
    }

    function daftar_member($data)
    {
        $this->db->insert('users',$data);
        return $this->db->insert_id();
    }

    function cekLogin2($email, $password){
        $sql = "SELECT * FROM users
                WHERE email = '$email' and password = '$password'";
        $user1 = $this->db->query($sql)->row_array();
        return $user1;
    }

    function cekLogin($email, $oauth_uid){
        $sql = "SELECT * FROM users
                WHERE email = '$email' and oauth_uid = '$oauth_uid'";
        $user1 = $this->db->query($sql)->row_array();
        return $user1;
    }

    public function update($data, $user) 
    {
        $this->db->where('id', $user);
        $this->db->update('users', $data);
    }

    public function update_deposit($where, $data)
    {
        $this->db->update('abe_deposit', $data, $where);
        return $this->db->affected_rows();
    }

    public function update_invoice($where, $data)
    {
        $this->db->update('abe_invoice', $data, $where);
        return $this->db->affected_rows();
    }

    public function add_deposit($data)
    {
        $this->db->insert('abe_deposit',$data);
        return $this->db->insert_id();
    }

    public function bayar_invoice($data, $id) 
    {
        $this->db->where('id_invoice', $id);
        $this->db->update('abe_invoice', $data);
    }

    public function bayar_invoice_deposit($data2, $id_deposit) 
    {
        $this->db->where('id_deposit', $id_deposit);
        $this->db->update('abe_deposit', $data2);
    }








    
    public function add_review($data)
    {
        $this->db->insert('abe_review',$data);
        return $this->db->insert_id();
    }
} 