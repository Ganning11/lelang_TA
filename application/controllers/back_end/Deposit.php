<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model(array('M_admin','User'));
        if($this->session->userdata('id_user') == '' OR $this->session->userdata('hak_akses') == 'bidder'){
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->template->load('template_back','dashboard/admin/data_deposit');
    }

    public function konfirmasi()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'oke');
        $update = $this->User->update_deposit(array('id_deposit' => $id), $data);
        $this->session->set_flashdata('sukses','Data Deposit berhasil di aktifkan<br>Terimakasih');
        redirect('back_end/deposit');
    }

    public function invoice()
    {
        $this->template->load('template_back','dashboard/admin/data_invoice');
    }

    public function konfirmasi_invoice()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'lunas');
        $update = $this->User->update_invoice(array('id_invoice' => $id), $data);
        $this->session->set_flashdata('sukses','Data Invoice berhasil di aktifkan<br>Terimakasih');
        redirect('back_end/deposit/invoice');
    }
}
