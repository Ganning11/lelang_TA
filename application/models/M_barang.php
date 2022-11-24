<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_barang extends CI_Model {

    var $foto_produk = 'abe_foto_produk';
    var $produk = 'abe_produk';

    public function save_foto($data)
    {
        $this->db->insert($this->foto_produk, $data);
        return $this->db->insert_id();
    }

    public function id_foto($id)
    {
        $this->db->from($this->foto_produk);
        $this->db->where('id_foto_produk',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function hapus_foto($id)
    {
        $this->db->where('id_foto_produk', $id);
        $this->db->delete($this->foto_produk);
    }

    public function add_barang($data)
    {
        $this->db->insert($this->produk,$data);
        return $this->db->insert_id();
    }

    public function update_foto_barang2($id, $user)
    {
        $data = array(
            'status'    => 'oke',
            'id_produk' => $id,
        );
        $sql = "UPDATE abe_foto_produk SET status='oke', id_produk='$id' WHERE status='baru' AND id_user='$user' ";
        $this->db->update($sql);
        return $this->db->affected_rows();
    }

    public function update_foto_barang($where,$data,$table)
    {
        $this->db->where($where);
        $this->db->update($table,$data);
    }   

    public function proses_lelang($where, $data)
    {
        $this->db->update('abe_produk', $data, $where);
        return $this->db->affected_rows();
    }

    public function detail_produk($id)
    {
        $param = array('id_produk' => $id);
        return $this->db->get_where('abe_produk',$param);
    }

    public function update_barang($data, $id) 
    {
        $this->db->where('id_produk', $id);
        $this->db->update('abe_produk', $data);
    }

    public function hapus_barang($id)
    {
        $this->db->where('id_produk', $id);
        $this->db->delete($this->produk);
    }

    public function hapus_foto2($id)
    {
        $this->db->where('id_produk', $id);
        $this->db->delete($this->foto_produk);
    }

    public function id_foto2($id)
    {
        $this->db->from($this->foto_produk);
        $this->db->where('id_produk',$id);
        $query = $this->db->get();
        return $query->row();
    }

    public function update_pemenang($data, $id_transaksi) 
    {
        $this->db->where('id_lelang_bidder', $id_transaksi);
        $this->db->update('abe_lelang_bidder', $data);
    }

    public function update_kalah($data2, $id_produk) 
    {
        $this->db->where('id_barang', $id_produk);
        $this->db->update('abe_lelang_bidder', $data2);
    }

    public function update_transaksi($data3, $id_produk) 
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->update('abe_produk', $data3);
    }

    public function add_invoice($data4)
    {
        $this->db->insert('abe_invoice',$data4);
        return $this->db->insert_id();
    }
}