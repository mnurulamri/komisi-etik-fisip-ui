<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("display_errors", 1);
class Beranda extends CI_Controller
{
	private $id_user;
	private $data;
	/*private $countPerbaikanSekretariat;
	private $countPerbaikanReviewer;
	private $countPerbaikanSidang;*/
	private $countMenungguSidangKomisi;
	private $nama_user;

	public function __construct(){
		parent::__construct();
		//$this->load->database();
		//$this->load->helper('url');
		$this->load->helper('menu_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('cek_output_helper');
		$this->load->helper('asesmen_kelengkapan_berkas_helper');
		//$this->load->helper('keterangan_dashboard_helper');
		$this->load->library('session');
		$this->load->model('BerandaModel');
		$this->load->model('PengajuanModel');

		$this->id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		/*$this->countPerbaikanSekretariat = $this->PengajuanModel->countPerbaikanSekretariat($this->id_user);
		$this->countPerbaikanReviewer = $this->PengajuanModel->countPerbaikanReviewer($this->id_user);
		$this->countPerbaikanSidang = $this->PengajuanModel->countPerbaikanSidang($this->id_user);*/
		$this->countMenungguSidangKomisi = $this->PengajuanModel->countMenungguSidangKomisi($this->id_user);

		$this->id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$array_identitas = $this->PengajuanModel->getIdentitas($this->id_user);
		foreach ($array_identitas as $row) {
			$this->nama_user = $row['nama'];
		}

	}

	public function peneliti()
	{
		# cek sudah teregistrasi atau belum
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		if (count($this->PengajuanModel->getIdentitas($id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');
		} else {
			# jika sudah teregistrasi
			//$data['side_menu'] = $this->getMenu(0);

			$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];

			$countBelumDiajukan = $this->BerandaModel->countStatus($id_user, '0');
			$countPerluPerbaikan = $this->BerandaModel->countStatus($id_user, '2,4,7');
			$countMenungguKonfirmasi = $this->BerandaModel->countStatus($id_user, '1');
			$countPenugasanReviewer = $this->BerandaModel->countStatus($id_user, '10');
			$countMenungguPenilaian = $this->BerandaModel->countStatus($id_user, '3');
			$countMenungguSidangKomisi = $this->BerandaModel->countStatus($id_user, '6');
			$countLolos = $this->BerandaModel->countStatus($id_user, '9');
			$countTidakLolos = $this->BerandaModel->countStatus($id_user, '5,8');

			if (empty($countBelumDiajukan) or $countBelumDiajukan=='') { $countBelumDiajukan = 0; }
			if (empty($countPerluPerbaikan) or $countPerluPerbaikan=='') { $countPerluPerbaikan = 0; }
			if (empty($countMenungguKonfirmasi) or $countMenungguKonfirmasi=='') { $countMenungguKonfirmasi = 0; }
			if (empty($countPenugasanReviewer) or $countPenugasanReviewer=='') { $countPenugasanReviewer = 0; }
			if (empty($countMenungguPenilaian) or $countMenungguPenilaian=='') { $countMenungguPenilaian = 0; }
			if (empty($countMenungguSidangKomisi) or $countMenungguSidangKomisi=='') { $countMenungguSidangKomisi = 0; }
			if (empty($countLolos) or $countLolos=='') { $countLolos = 0; }


			$data['array_count'] = array (
				'countBelumDiajukan' => $countBelumDiajukan,
				'countPerluPerbaikan' => $countPerluPerbaikan,
				'countMenungguKonfirmasi' => $countMenungguKonfirmasi,
				'countPenugasanReviewer' => $countPenugasanReviewer,
				'countMenungguPenilaian' => $countMenungguPenilaian,
				'countMenungguSidangKomisi' => $countMenungguSidangKomisi,
				'countTidakLolos' => $countTidakLolos,
				'countLolos' => $countLolos
			);

			/*$countBelumDiajukan = $this->BerandaModel->countBelumDiajukan($id_user);
			$countPerluPerbaikan = $this->BerandaModel->countPerluPerbaikan($id_user);
			$countmenungguKonfirmasi = $this->BerandaModel->countmenungguKonfirmasi($id_user);
			$countMenungguSidangKomisi = $this->BerandaModel->countMenungguSidangKomisi($id_user);
			$countLolos = $this->BerandaModel->countLolos($id_user);*/

			/*
			$countPerbaikanSekretariat = $this->BerandaModel->countPerbaikanSekretariat($id_user);
			$countPerbaikanReviewer = $this->BerandaModel->countPerbaikanReviewer($id_user);
			$countPerbaikanSidang = $this->BerandaModel->countPerbaikanSidang($id_user);

			$data['array_count'] = array (
				'countBelumDiajukan' => $countBelumDiajukan,
				'countPerluPerbaikan' => $countPerluPerbaikan,
				'countmenungguKonfirmasi' => $countmenungguKonfirmasi,
				'countPerbaikanSekretariat' => $countPerbaikanSekretariat,
				'countPerbaikanReviewer' => $countPerbaikanReviewer,
				'countPerbaikanSidang' => $countPerbaikanSidang,
				'countMenungguSidangKomisi' => $countMenungguSidangKomisi,
				'countLolos' => $countLolos
			);*/

			//get data pengajuan
			$sql = "SELECT * FROM pengajuan
					WHERE status not in ('5, 8, 9') AND id_user = '$id_user'
					LIMIT 1";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			$data['result'] = $result;
			$data['sql'] = $sql;

			//get data status
			$sql = "SELECT * FROM status ";
			$query = $this->db->query($sql);
			$result_status = $query->result_array();
			foreach($result_status as $row){
				$array_status[$row['kd_status']] = $row['nm_status'];
			}
			$data['array_status'] = $array_status;

			$this->load->view('layout/header', array('nama'=>$this->nama_user));
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('beranda/beranda_peneliti_view', $data);
			$this->load->view('layout/footer');
		}
	}

	public function sekretariat()
	{
		# cek sudah teregistrasi atau belum
		if (count($this->PengajuanModel->getIdentitas($this->id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');
		} else {

			# jika sudah teregistrasi
			$countPengajuan = $this->BerandaModel->countpengajuan();
			$countLolosAdministratif = $this->BerandaModel->countStatusAll('3,4,6,7,8,9,10');
			$countMenungguKonfirmasi = $this->BerandaModel->countStatusAll('1');
			$countPenugasanReviewer = $this->BerandaModel->countStatusAll('10');
			$countMenungguPenilaian = $this->BerandaModel->countStatusAll('3');
			$countPerluPerbaikan = $this->BerandaModel->countStatusAll('2,4,7');
			$countMenungguSidangKomisi = $this->BerandaModel->countStatusAll('6');
			$countLolos = $this->BerandaModel->countStatusAll('9');
			$countRerataHariLolos = $this->BerandaModel->countRerataHariLolos();
			$countTidakLolos = $this->BerandaModel->countStatusAll('5,8');

			if (empty($countPengajuan) or $countPengajuan=='') { $countPengajuan = 0; }
			if (empty($countLolosAdministratif) or $countLolosAdministratif=='') { $countLolosAdministratif = 0; }
			if (empty($countRerataHariLolos) or $countRerataHariLolos=='' or is_null($countRerataHariLolos) or
				$countRerataHariLolos === NULL or !$countRerataHariLolos)
				{ $countRerataHariLolos = 0; }
			if (empty($countMenungguKonfirmasi) or $countMenungguKonfirmasi=='') { $countMenungguKonfirmasi = 0; }
			if (empty($countPenugasanReviewer) or $countPenugasanReviewer=='') { $countPenugasanReviewer = 0; }
			if (empty($countPerluPerbaikan) or $countPerluPerbaikan=='') { $countPerluPerbaikan = 0; }
			if (empty($countMenungguPenilaian) or $countMenungguPenilaian=='') { $countMenungguPenilaian = 0; }
			if (empty($countMenungguSidangKomisi) or $countMenungguSidangKomisi=='') { $countMenungguSidangKomisi = 0; }
			if (empty($countLolos) or $countLolos=='') { $countLolos = 0; }
			if (empty($countTidakLolos) or $countTidakLolos=='') { $countTidakLolos = 0; }
			$test = (!empty($countRerataHariLolos)) ? $countRerataHariLolos : 0 ;
			$data['array_count'] = array (
				'countPengajuan' => $countPengajuan,
				'countLolosAdministratif' => $countLolosAdministratif,
				'countRerataHariLolos' => $countRerataHariLolos,
				'countMenungguKonfirmasi' => $countMenungguKonfirmasi,
				'countPenugasanReviewer' => $countPenugasanReviewer,
				'countMenungguPenilaian' => $countMenungguPenilaian,
				'countPerluPerbaikan' => $countPerluPerbaikan,
				'countMenungguSidangKomisi' => $countMenungguSidangKomisi,
				'countLolos' => $countLolos,
				'countTidakLolos' => $countTidakLolos
			);
			$data['test'] = $test;

			$data['array_beban_kerja'] = $this->BerandaModel->bebanKerja();

			$this->load->view('layout/header');
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('beranda/beranda_sekretariat_view', $data);
			$this->load->view('layout/footer');
		}
	}

	public function reviewer()
	{
		# cek sudah teregistrasi atau belum
		if (count($this->PengajuanModel->getIdentitas($this->id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');
		} else {
			# jika sudah teregistrasi
			$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
			$countPengajuan = $this->BerandaModel->countStatusReviewer($id_user, '1,2,3,4,5,6,7,8,9,10');
			$countMenungguPenilaian = $this->BerandaModel->countStatusReviewer($id_user, '3');
			$countPerluPerbaikan = $this->BerandaModel->countStatusReviewer($id_user, '4,7');
			$countMenungguSidangKomisi = $this->BerandaModel->countStatusReviewer($id_user, '6');
			$countLolos = $this->BerandaModel->countStatusReviewer($id_user, '9');
			$countTidakLolos = $this->BerandaModel->countStatusReviewer($id_user, '5,8');

			if (empty($countPengajuan) or $countPengajuan=='') { $countPengajuan = 0; }
			if (empty($countPerluPerbaikan) or $countPerluPerbaikan=='') { $countPerluPerbaikan = 0; }
			if (empty($countMenungguPenilaian) or $countMenungguPenilaian=='') { $countMenungguPenilaian = 0; }
			if (empty($countMenungguSidangKomisi) or $countMenungguSidangKomisi=='') { $countMenungguSidangKomisi = 0; }
			if (empty($countLolos) or $countLolos=='') { $countLolos = 0; }
			if (empty($countTidakLolos) or $countTidakLolos=='') { $countTidakLolos = 0; }

			$data['array_count'] = array (
				'countPengajuan' => $countPengajuan,
				'countMenungguPenilaian' => $countMenungguPenilaian,
				'countPerluPerbaikan' => $countPerluPerbaikan,
				'countMenungguSidangKomisi' => $countMenungguSidangKomisi,
				'countLolos' => $countLolos,
				'countTidakLolos' => $countTidakLolos
			);

			$data['array_beban_kerja'] = $this->BerandaModel->bebanKerja();

			// get distinct nama reviewer diambil dari tabel reviewer
			$sql = "SELECT DISTINCT id_user, nama FROM user_role WHERE role_id = 3";
			$query = $this->db->query($sql);
			$result = $query->result_array();
			$data['array_reviewer'] = $result;

			$this->load->view('layout/header');
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('beranda/beranda_reviewer_view', $data);
			$this->load->view('layout/footer');
		}
	}

	public function ketua_tim()
	{
		# cek sudah teregistrasi atau belum
		if (count($this->PengajuanModel->getIdentitas($this->id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');
		} else {

			# jika sudah teregistrasi
			$countPengajuan = $this->BerandaModel->countpengajuan();
			$countLolosAdministratif = $this->BerandaModel->countStatusAll('3,4,6,7,8,9,10');

			$countMenungguKonfirmasi = $this->BerandaModel->countStatusAll('1');
			$countMenungguPenilaian = $this->BerandaModel->countStatusAll('3');
			$countPerluPerbaikan = $this->BerandaModel->countStatusAll('2,4,7');
			$countMenungguSidangKomisi = $this->BerandaModel->countStatusAll('6');
			$countLolos = $this->BerandaModel->countStatusAll('9');
			$countRerataHariLolos = $this->BerandaModel->countRerataHariLolos();
			$countTidakLolos = $this->BerandaModel->countStatusAll('5,8');
			$countPenugasanReviewer = $this->BerandaModel->countStatusAll('10');

			if (empty($countPengajuan) or $countPengajuan=='') { $countPengajuan = 0; }
			if (empty($countLolosAdministratif) or $countLolosAdministratif=='') { $countLolosAdministratif = 0; }
			if (empty($countPerluPerbaikan) or $countPerluPerbaikan=='') { $countPerluPerbaikan = 0; }
			if (empty($countMenungguPenilaian) or $countMenungguPenilaian=='') { $countMenungguPenilaian = 0; }
			if (empty($countMenungguSidangKomisi) or $countMenungguSidangKomisi=='') { $countMenungguSidangKomisi = 0; }
			if (empty($countLolos) or $countLolos=='') { $countLolos = 0; }
			if (empty($countRerataHariLolos) or $countRerataHariLolos=='') { $countRerataHariLolos = 0; }
			if (empty($countTidakLolos) or $countTidakLolos=='') { $countTidakLolos = 0; }
			if (empty($countPenugasanReviewer) or $countPenugasanReviewer=='') { $countPenugasanReviewer = 0; }

			$data['array_count'] = array (
				'countPengajuan' => $countPengajuan,
				'countLolosAdministratif' => $countLolosAdministratif,
				'countRerataHariLolos' => $countRerataHariLolos,
				'countMenungguKonfirmasi' => $countMenungguKonfirmasi,
				'countMenungguPenilaian' => $countMenungguPenilaian,
				'countPerluPerbaikan' => $countPerluPerbaikan,
				'countMenungguSidangKomisi' => $countMenungguSidangKomisi,
				'countLolos' => $countLolos,
				'countTidakLolos' => $countTidakLolos,
				'countPenugasanReviewer' => $countPenugasanReviewer
			);

			$data['array_beban_kerja'] = $this->BerandaModel->bebanKerja();

			$this->load->view('layout/header');
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('beranda/beranda_ketua_tim_view', $data);
			$this->load->view('layout/footer');
		}
	}
}
