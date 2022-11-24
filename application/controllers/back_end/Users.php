<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('M_admin','User'));
        if($this->session->userdata('id_user') == '' OR $this->session->userdata('hak_akses') == 'bidder'){
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->template->load('template_back','dashboard/pelelang/data_barang');
    }

    public function pelelang_baru()
    {
        $this->template->load('template_back','dashboard/admin/data_pelelang_baru');
    }

    public function pelelang_aktif()
    {
        $this->template->load('template_back','dashboard/admin/data_pelelang_aktif');
    }

    public function pelelang_blokir()
    {
        $this->template->load('template_back','dashboard/admin/data_pelelang_blokir');
    }

    public function bidder_baru()
    {
        $this->template->load('template_back','dashboard/admin/data_bidder_baru');
    }

    public function bidder_aktif()
    {
        $this->template->load('template_back','dashboard/admin/data_bidder_aktif');
    }

    public function bidder_blokir()
    {
        $this->template->load('template_back','dashboard/admin/data_bidder_blokir');
    }

    public function aktifkan_pelelang()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'aktif');
        $update = $this->M_admin->update_pelelang(array('id_user' => $id), $data);
        $this->session->set_flashdata('sukses','Data Pelelang berhasil di aktifkan<br>Terimakasih');
        redirect('back_end/users/pelelang_aktif');
    }

    public function blokir_pelelang()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'blokir');
        $update = $this->M_admin->update_pelelang(array('id_user' => $id), $data);
        $this->session->set_flashdata('sukses','Data Pelelang berhasil di Blokir<br>Terimakasih');
        redirect('back_end/users/pelelang_blokir');
    }

    public function detail_pelelang()
    {
        $id = $this->uri->segment(4);
        $data['record'] = $this->M_admin->detail_pelelang($id)->row_array();
        $this->template->load('template_back','dashboard/admin/detail_pelelang',$data);
    }

    public function aktifkan_bidder()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'aktif');
        $update = $this->M_admin->update_bidder(array('id' => $id), $data);
        $this->session->set_flashdata('sukses','Data Bidder berhasil di aktifkan<br>Terimakasih');
        redirect('back_end/users/bidder_aktif');
    }

    public function blokir_bidder()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'blokir');
        $update = $this->M_admin->update_bidder(array('id' => $id), $data);
        $this->session->set_flashdata('sukses','Data Bidder berhasil di Blokir<br>Terimakasih');
        redirect('back_end/users/bidder_blokir');
    }

    public function review()
    {
        $this->template->load('template_back','dashboard/admin/data_review');
    }

    public function kategori_klik()
    {
        $this->template->load('template_back','dashboard/admin/data_kategori_klik');
    }

    public function kategori_bid()
    {
        $this->template->load('template_back','dashboard/admin/data_kategori_bid');
    }
}
