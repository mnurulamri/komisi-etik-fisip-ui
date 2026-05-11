<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penugasan extends CI_Controller 
{

	public function __construct()
    {
		parent::__construct();
		$this->load->database();
		$this->other_db = $this->load->database('remunerasi', TRUE);
		$this->load->helper('url');
        $this->load->helper('tanggal_helper');
        $this->load->helper('tombol_aksi_helper');
		$this->load->helper('catatan_helper');
        $this->load->helper('menu_helper');
		$this->load->helper('cek_output_helper');
        $this->load->library('session');
        $this->load->model('PengajuanModel');
        $this->load->model('ProtokolModel');
        $this->load->model('DaftarPeriksaModel');
		//$this->load->model('PertanyaanModel');
	}

    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('form/penugasan_reviewer');
        $this->load->view('layout/footer');
    }

    public function get_ajax_penugasan()
    {
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;
        $records = $this->DaftarPeriksaModel->getAjaxPenugasan();
        $data['pengajuan'] = $records;
        $this->load->view('ajax/ajax_penugasan', $data);
    }

    public function cari_nama()
    {
		$kata = $this->input->post('kata');
		if (empty($kata) or $kata==''){
			echo '';
		} else {
			$sql = "SELECT nip, nama_bergelar 
					FROM master_employee 
					WHERE kategori = 'Lecturer' AND nama LIKE '%$kata%'
					LIMIT 10";
			$query = $this->other_db->query($sql);
			$result = $query->result_array();
			//cek_output($result);
			echo '
			<table class="autocomplete" cellpadding="0" cellspacing="0">
				<tr>
					<th>ID USER</th>
					<th>NAMA</th>
					<!--<th></th>-->
				</tr>';
				foreach($result as $row){
					echo '
			
					<tr class="isi" id="'.$row['nip'].'">
						<td class="id_user">'.$row['nip'].'</td>
						<td class="nama_reviewer">'.$row['nama_bergelar'].'</td>
						<!--<td><button class="btn btn-default btn-xs"><i class="tambah fa fa-plus  text-success" aria-hidden="true"></i></button></td>-->
					</tr>';
				}
			echo '
				</table>';
		}
    }

	public function tambah_nama()
    {
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$id_user = $this->input->post('id_user');
		$nama = $this->input->post('nama');
		$tgl_penugasan = tanggalToDb($this->input->post('tgl_penugasan'));
		
		# tambahkan nama ke dalam database
		$sql = "INSERT INTO reviewer (kd_pengajuan, id_user, nama, tgl_penugasan)
				VALUES ('$kd_pengajuan', '$id_user', '$nama', '$tgl_penugasan')";
		$this->db->query($sql);

		/*# rubah status menjadi menunggu penilaian reviewer
		$sql = "UPDATE pengajuan SET status = 3 WHERE kd_pengajuan = '$kd_pengajuan'";
		$this->db->query($sql);*/

		$sql = "SELECT * FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);
		$result_nama = $query->result_array();
		
		$data['result_nama'] = $result_nama;
		$this->load->view('ajax/ajax_penugasan_set', $data);
	}

	public function get_nama()
    {
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		
		$sql = "SELECT * FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);
		$result_nama = $query->result_array();
		$data['result_nama'] = $result_nama;
		$this->load->view('ajax/ajax_penugasan_set', $data);
		
	}

	public function delete_nama()
    {
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$id_user = $this->input->post('id_user');

		$sql = "DELETE FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user'";
		$this->db->query($sql);

		$sql = "SELECT * FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);

		$result_nama = $query->result_array();
		$data['result_nama'] = $result_nama;
		$this->load->view('ajax/ajax_penugasan_set', $data);
		
	}

	public function reviewer_ok()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		
		# rubah status menjadi menunggu penilaian reviewer
		$sql = "UPDATE pengajuan SET status = 3 WHERE kd_pengajuan = '$kd_pengajuan'";
		$this->db->query($sql);
	}
}