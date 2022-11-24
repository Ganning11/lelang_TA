<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
    
    function __construct(){
        parent::__construct();
        //chekAksesModule();
        $this->load->model('M_barang');
        if($this->session->userdata('id_user') == '' OR $this->session->userdata('hak_akses') == 'bidder'){
            redirect('dashboard');
        }
    }

    public function index()
    {
        $this->template->load('template_back','dashboard/pelelang/data_barang');
    }

    public function admin_baru()
    {
        $this->template->load('template_back','dashboard/admin/data_barang_baru');
    }

    public function admin_aktif()
    {
        $this->template->load('template_back','dashboard/admin/data_barang_lelang');
    }

    public function admin_laku()
    {
        $this->template->load('template_back','dashboard/admin/data_barang_sold');
    }

    public function add_produk()
    {
        $this->template->load('template_back','dashboard/pelelang/form_tambah_barang');
    }

    public function dataFoto(){
        //$id_user    = $this->session->userdata('id_user');
        $id_produk  = $_GET['id_produk'];
        echo "<table class='table table-bordered table-striped' >
                <thead>
                  <tr>
                    <th width='10%'>No</th>
                    <th>Foto</th>
                    <th width='35%'>Nama Foto</th>
                    <th width='15%'>Aksi</th>
                  </tr>
                </thead>";
            $sql_foto   = "SELECT * FROM abe_foto_produk WHERE id_produk = '$id_produk'";
            //$sql_rapat      = "SELECT status, no_rapat FROM abe_rapat_new WHERE no_rapat = '$no_rapat'";
            $foto = $this->db->query($sql_foto)->result();
            //$rapat = $this->db->query($sql_rapat)->row_array();
            if(empty($foto)){
                echo "<tr><td colspan='4'><center>Belum ada Foto Produk</center></td></tr>";
            }else{
                $no = 1;
                foreach ($foto as $row) {
                    echo "<tr><td>$no</td>
                            <td><img src='".base_url('assets/foto_produk/')."$row->file_foto' height='100'></td>
                            <td>$row->nama_foto</td>
                          <td><button onclick='delete_foto($row->id_foto_produk)' class='btn btn-xs btn-danger' title='hapus foto'><i class='fa fa-trash'></i></button>
                          </td></tr>";
                    $no++;
                }
            }
        echo "</table>";
    }

    public function add_foto()
    {
        $id_user = $this->session->userdata('id_user');
        $data = array(
                'nama_foto'  => $this->input->post('nama_foto'),
                'status'     => $this->input->post('status'),
                'id_produk'  => $this->input->post('id_produk'),
                'id_user'    => $id_user,
            );
        if(!empty($_FILES['file_foto']['name']))
            {
                $upload = $this->_do_upload();
                $data['file_foto'] = $upload;
            }
        $insert = $this->M_barang->save_foto($data);
        echo json_encode(array("status" => TRUE));
    }

    public function _do_upload()
    {
        $config['upload_path']          = 'assets/foto_produk';
        $config['allowed_types']        = 'jpg|png|jpeg|pdf';
        $config['max_size']             = 4000; //set max size allowed in Kilobyte
       // $config['max_width']            = 1000; // set max width image allowed
       // $config['max_height']           = 1000; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if(!$this->upload->do_upload('file_foto')) //upload and validate
        {
            $data['inputerror'][] = 'file_foto';
            $data['error_string'][] = 'Upload error : '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }

    public function hapus_foto($id)
    {
        $lampiran = $this->M_barang->id_foto($id);
        if(file_exists('assets/foto_produk/'.$lampiran->file_foto) && $lampiran->file_foto)
            unlink('assets/foto_produk/'.$lampiran->file_foto);
        $this->M_barang->hapus_foto($id);
        echo json_encode(array("status" => TRUE));
    }

    public function save_produk()
    {
        $kategori   = $this->input->post('kategori');
        $nama       = $this->input->post('nama');
        $harga      = preg_replace("/[^0-9]/", "", $this->input->post('harga'));
        $max_harga  = preg_replace("/[^0-9]/", "", $this->input->post('max_harga'));
        $jumlah     = $this->input->post('jumlah');
        $deskripsi  = $this->input->post('keterangan');
        $user       = $this->session->userdata('id_user');
        $data = array(
            'nama_produk'   => $nama,
            'harga_produk'  => $harga,
            'max_harga'  => $max_harga,
            'jumlah_produk' => $jumlah,
            'id_kategori'   => $kategori,
            'id_pelelang'   => $user,
            'status'        => 'ready',
            'deskripsi'     => $deskripsi,
        );
        //tambahkan akun ke database
        $this->M_barang->add_barang($data);
        $sql_barang = "SELECT id_produk, id_pelelang FROM abe_produk WHERE id_pelelang = '$user' ORDER BY id_produk DESC LIMIT 1";
        $sql        = $this->db->query($sql_barang)->row_array();
        $id         = $sql['id_produk'];

        $data2 = array
        (
            'status' => 'oke',
            'id_produk' => $id
        );
 
        $where = array(
            'status' => 'baru',
            'id_user' => $user
        );
        $this->M_barang->update_foto_barang($where, $data2, 'abe_foto_produk');
        $this->session->set_flashdata('sukses','Data Barang berhasil di tambahkan<br>Terimakasih');
        redirect('back_end/barang');
    }

    public function update_produk()
    {
        $kategori   = $this->input->post('kategori');
        $nama       = $this->input->post('nama');
        $harga      = preg_replace("/[^0-9]/", "", $this->input->post('harga'));
        $max_harga  = preg_replace("/[^0-9]/", "", $this->input->post('max_harga'));
        $jumlah     = $this->input->post('jumlah');
        $deskripsi  = $this->input->post('keterangan');
        $user       = $this->session->userdata('id_user');
        $data = array(
            'nama_produk'   => $nama,
            'harga_produk'  => $harga,
            'max_harga'  => $max_harga,
            'jumlah_produk' => $jumlah,
            'id_kategori'   => $kategori,
            'id_pelelang'   => $user,
            'status'        => 'ready',
            'deskripsi'     => $deskripsi,
        );
        //update data ke database
        $id = $this->input->post('id_produk');
        $this->M_barang->update_barang($data, $id);
        $this->session->set_flashdata('sukses','Data Produk berhasil di ubah<br>Terimakasih');
        redirect('back_end/barang');
    }

    public function hapus($id)
    {
        $this->M_barang->hapus_barang($id);
        $lampiran = $this->M_barang->id_foto2($id);
        if(file_exists('assets/foto_produk/'.$lampiran->file_foto) && $lampiran->file_foto)
            unlink('assets/foto_produk/'.$lampiran->file_foto);
        $this->M_barang->hapus_foto2($id);
        echo json_encode(array("status" => TRUE));
    }

    public function proses_lelang()
    {
        $tgl_buka = date('Y-m-d');
        $tgl_tutup = date('Y-m-d', strtotime($this->input->post('tgl_akhir')));
        $data = array(
            'tgl_buka'      => $tgl_buka,
            'tgl_tutup'     => $tgl_tutup,
            'keterangan'    => $this->input->post('keterangan'),
            'status'        => 'lelang',
        );
        
        $update = $this->M_barang->proses_lelang(array('id_produk' => $this->input->post('id')), $data);
        $this->session->set_flashdata('sukses','Data Produk berhasil di upload ke Dashboard Lelang<br>Terimakasih');
        redirect('back_end/transaksi');
    }

    public function edit()
    {
        $id = $this->uri->segment(4);
        $data['record'] = $this->M_barang->detail_produk($id)->row_array();
        $this->template->load('template_back','dashboard/pelelang/form_edit_barang',$data);
    }


}
