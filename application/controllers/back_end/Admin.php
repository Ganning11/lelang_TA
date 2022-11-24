<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        //chekAksesModule();
        $this->load->model('M_admin');
        if($this->session->userdata('id_user') == '' OR $this->session->userdata('hak_akses') == 'bidder'){
            redirect('dashboard');
        }
    }

    public function index()
    {
         
        $this->template->load('template_back','dashboard/admin/data_admin');
    }

    public function add_admin()
    {
        $nama       = $this->input->post('nama');
        $password   = ($this->input->post('password'));
        $email      = $this->input->post('email');
        $hak_akses  = $this->input->post('hak_akses');
        $date       = date('Y:m:d');

        $cek_email = $this->M_admin->email($email);
        if ($cek_email > 0){
            $this->session->set_flashdata('gagal','Mohon maaf<br>Email anda sudah terdaftar<br>mohon periksa kembali email anda<br>terimakasih');
            redirect('back_end/admin');
         
        }else {            
            //memasukan ke array
            $data = array(
                'nama_lengkap'=> $nama,
                'password'  => $password,
                'email'     => $email,
                'status'    => 'non aktif',
                'hak_akses' => $hak_akses,
                'foto'      => 'user.png',
                'tgl_daftar'    => $date
            );
            //tambahkan akun ke database
            $this->M_admin->add_admin($data);
            $this->session->set_flashdata('sukses','Data Admin berhasil di tambahkan<br>Terimakasih');
            redirect('back_end/admin');
        } 
    }

    public function edit_admin()
    {
        $password = $this->input->post('password');
        if($password == ''){
            $data = array(
                'nama_lengkap'  => $this->input->post('nama'),
                'email'         => $this->input->post('email'),
                'hak_akses'     => $this->input->post('hak_akses'),
            );
        }else{
            $data = array(
                'nama_lengkap'  => $this->input->post('nama'),
                'password'      => MD5($password),
                'email'         => $this->input->post('email'),
                'hak_akses'     => $this->input->post('hak_akses'),
            );
        }
        
        $update = $this->M_admin->update_admin(array('id_user' => $this->input->post('id')), $data);
        $this->session->set_flashdata('sukses','Data Admin berhasil di ubah<br>Terimakasih');
        redirect('back_end/admin');
    }

    public function hapus()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'non aktif');
        $update = $this->M_admin->update_admin(array('id_user' => $id), $data);
        $this->session->set_flashdata('gagal','Data Admin berhasil di non aktifkan<br>Terimakasih');
        redirect('back_end/admin');
    }

    public function aktifkan()
    {
        $id = $this->uri->segment(4);
        $data = array('status'  => 'aktif');
        $update = $this->M_admin->update_admin(array('id_user' => $id), $data);
        $this->session->set_flashdata('sukses','Data Admin berhasil di aktifkan kembali<br>Terimakasih');
        redirect('back_end/admin');
    }

    public function hapus_permanent()
    {
        $id = $this->uri->segment(4);
        $hapus = $this->M_admin->hapus_admin($id);
        $this->session->set_flashdata('gagal','Data Admin berhasil di hapus<br>Terimakasih');
        redirect('back_end/admin');
    }
}
