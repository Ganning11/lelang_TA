<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_produk extends CI_Model {

    var $foto_produk = 'abe_foto_produk';
    var $produk = 'abe_produk';

    public function detail_produk($id)
    {
        $param = array('id_produk' => $id);
        return $this->db->get_where('abe_produk',$param);
    }

    function add_penawaran($data)
    {
        $this->db->insert('abe_lelang_bidder',$data);
        return $this->db->insert_id();
    }
    public function update_barang($data, $id) 
    {
        $this->db->where('id_produk', $id);
        $this->db->update('abe_produk', $data);
    }

    function add_klik($data)
    {
        $this->db->insert('abe_kategori_klik',$data);
        return $this->db->insert_id();
    }

    function update_klik($where, $data)
    {
        $this->db->update('abe_kategori_klik', $data, $where);
        return $this->db->affected_rows();
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