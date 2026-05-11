<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('menu_helper');
		$this->load->helper('tanggal_helper');
		$this->load->helper('cek_output_helper');
		$this->load->model('PertanyaanModel');
		$this->load->model('PenilaianModel');
		$this->load->model('PengajuanModel');
		$this->load->model('DaftarPeriksaModel');
		$this->load->library('session');
	}

	/*public function form()
	{
		$data['pertanyaan_waktu'] = $this->PertanyaanModel->getPertanyaanWaktu();
		$data['pertanyaan_persetujuan'] = $this->PertanyaanModel->getPertanyaanPersetujuan();
		$data['pertanyaan_kerahasiaan'] = $this->PertanyaanModel->getPertanyaanKerahasiaan();
		$data['pertanyaan_keamanan'] = $this->PertanyaanModel->getPertanyaanKeamanan();
		$data['pertanyaan_manfaat'] = $this->PertanyaanModel->getPertanyaanManfaat();
		$data['pertanyaan_integritas'] = $this->PertanyaanModel->getPertanyaanIntegritas();
		$data['pertanyaan_respons'] = $this->PertanyaanModel->getPertanyaanRespons();
		//$this->load->view('layout/header');
		//$this->load->view('layout/sidebar');
		$this->load->view('form/penilaian', $data);
		//$this->load->view('layout/footer');
	}*/

	public function form()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$data['kd_pengajuan'] = $this->input->post('kd_pengajuan');
		$data['komponen'] = $this->PertanyaanModel->komponen();
		$data['waktu'] = $this->PertanyaanModel->waktu();
		$data['persetujuan'] = $this->PertanyaanModel->persetujuan();
		$data['kerahasiaan'] = $this->PertanyaanModel->kerahasiaan();
		$data['keamanan'] = $this->PertanyaanModel->keamanan();
		$data['manfaat'] = $this->PertanyaanModel->manfaat();
		$data['integritas'] = $this->PertanyaanModel->integritas();
		$data['respon'] = $this->PertanyaanModel->respon();
		$data['relasi'] = $this->PertanyaanModel->relasi();
		$data['jawaban'] = $this->PertanyaanModel->getJawaban($this->input->post('kd_pengajuan'));
		$data['array_id_pertanyaan'] = $this->PertanyaanModel->getIdPertanyaan();

		$sql = "SELECT status FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$result = $query->result_array();
		foreach ($result as $row) {
			$data['status'] = $row['status'];
		}
		$this->load->view('form/pertanyaan_etik', $data);
		
	}

	public function simpan()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$id_pertanyaan = $this->input->post('id');
		$jawaban = $this->input->post('jawaban');
		$data = [
			'id' => '',
			'kd_pengajuan' => $kd_pengajuan,
			'id_pertanyaan' => $id_pertanyaan,
			'jawaban' => $jawaban
		];
		$cek = $this->PertanyaanModel->simpanJawaban($data);
		//cek_output($cek);
	}

	public function lihat_data()
	{
		$data['kd_pengajuan'] = $this->input->post('kd_pengajuan'); 
		$data['pertanyaan_waktu'] = $this->PertanyaanModel->getPertanyaanWaktu();
		$data['pertanyaan_persetujuan'] = $this->PertanyaanModel->getPertanyaanPersetujuan();
		$data['pertanyaan_kerahasiaan'] = $this->PertanyaanModel->getPertanyaanKerahasiaan();
		$data['pertanyaan_keamanan'] = $this->PertanyaanModel->getPertanyaanKeamanan();
		$data['pertanyaan_manfaat'] = $this->PertanyaanModel->getPertanyaanManfaat();
		$data['pertanyaan_integritas'] = $this->PertanyaanModel->getPertanyaanIntegritas();
		$data['pertanyaan_respons'] = $this->PertanyaanModel->getPertanyaanRespons();
		//$this->load->view('layout/header');
		//$this->load->view('layout/sidebar');
		$this->load->view('form/penilaian', $data);
		//$this->load->view('layout/footer');
	}

	public function lembar_penilaian()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');

		# tentukan nama reviewer melalui id_user berdasarkan login
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$sql = "SELECT DISTINCT id_user, nama, tgl_penugasan, tgl_penilaian FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);
		$result_reviewer = $query->result_array();
		$data['result_reviewer'] = $result_reviewer;

		# tentukan permohonan masuk, nama peneliti dan judul
		$data['pengajuan'] = $this->PengajuanModel->getData($kd_pengajuan);

		$data['kd_pengajuan'] = $this->input->post('kd_pengajuan');
		$data['komponen'] = $this->PertanyaanModel->komponen();
		$data['pertanyaan'] = $this->PertanyaanModel->getPertanyaanAll();
		$data['jawaban'] = $this->PertanyaanModel->getJawaban($this->input->post('kd_pengajuan'));
		$data['array_id_pertanyaan'] = $this->PertanyaanModel->getIdPertanyaan();

		$sql = "SELECT status FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$result = $query->result_array();
		foreach ($result as $row) {
			$data['status'] = $row['status'];
		}

		$sql = "SELECT id_pertanyaan, asesmen FROM asesmen_etik WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$data['array_asesmen'] = $query->result_array();

		$sql = "SELECT * FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$data['array_hasil_asesmen'] = $query->result_array();

		$this->load->view('form/lembar_penilaian', $data);
	}

	public function lembar_penilaian_sidang()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');

		# tentukan nama reviewer melalui id_user berdasarkan login
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$sql = "SELECT DISTINCT id_user, nama, tgl_penugasan, tgl_penilaian FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);
		$result_reviewer = $query->result_array();
		$data['result_reviewer'] = $result_reviewer;

		# tentukan permohonan masuk, nama peneliti dan judul
		$data['pengajuan'] = $this->PengajuanModel->getData($kd_pengajuan);

		$data['kd_pengajuan'] = $this->input->post('kd_pengajuan');
		$data['komponen'] = $this->PertanyaanModel->komponen();
		$data['pertanyaan'] = $this->PertanyaanModel->getPertanyaanAll();
		$data['jawaban'] = $this->PertanyaanModel->getJawaban($this->input->post('kd_pengajuan'));
		$data['array_id_pertanyaan'] = $this->PertanyaanModel->getIdPertanyaan();

		$sql = "SELECT status FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$result = $query->result_array();
		foreach ($result as $row) {
			$data['status'] = $row['status'];
		}

		$sql = "SELECT id_pertanyaan, asesmen FROM asesmen_etik WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$data['array_asesmen'] = $query->result_array();

		$sql = "SELECT hasil_asesmen, catatan, sidang FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$data['array_hasil_asesmen'] = $query->result_array();

		//$this->load->view('form/lembar_penilaian_sidang', $data);
		$this->load->view('sidang_komisi/sidang_komisi_lembar_penilaian', $data);
	}

	public function simpan_asesmen()
	{
		
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$id_user = $this->input->post('id_user');
		$array_id_pertanyaan = $this->PertanyaanModel->getIdPertanyaan();
		
		# cek dulu datanya
		$sql = "SELECT id FROM asesmen_etik WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$num_rows = $query->num_rows();
		
		# jika tidak maka insert jika ada maka edit
		if ($num_rows == 0){
			# insert data
			# buat array label
			foreach ($array_id_pertanyaan as $row){
				# biar nggak error
				if(empty($_POST[$row->id_pertanyaan]) or $_POST[$row->id_pertanyaan]==''){
					$value = 0;
				} else {
					$value = $_POST[$row->id_pertanyaan];
				}
				$data = [
					'id' => '',
					'kd_pengajuan' => $kd_pengajuan,
					'id_user' => $id_user,
					'id_pertanyaan' => $row->id_pertanyaan,
					'asesmen' => $value
				];

				$this->db->insert('asesmen_etik', $data);
			}
			
		} else {

			# edit data
			$i = 0;
			foreach ($_POST as $key => $value){
				# ambil array ketiga dimana tidak meng-iclude-kan kd_pengajuan dan id_user
				if ($i>1)
				{
					$where = [
						'kd_pengajuan' => $kd_pengajuan,
						'id_user' => $id_user,
						'id_pertanyaan' => $key
					];
					
					$data = [
						'asesmen' => $value
					];
					cek_output($where);cek_output($data);
					$this->db->update('asesmen_etik', $data, $where);
				}
				$i++;
			}
		}
	}

	public function simpan_hasil_asesmen()
	{
		$kd_pengajuan = $this->input->post('_kd_pengajuan');
		$id_user = $this->input->post('_id_user');
		$hasil_asesmen = $this->input->post('hasil_asesmen');

		# karena datanya sudah ada maka hanya tinggal edit		
		$where = [
			'kd_pengajuan' => $kd_pengajuan,
			'id_user' => $id_user
		];
		$data = [
			'tgl_penilaian' => date("Y-m-d"),
			'hasil_asesmen' => $hasil_asesmen
		];
		$this->db->update('reviewer', $data, $where);

		/* 
			untuk menghasilkan status secara otomatis, ketika reviewer menentukan lolos, perbaikan atau tidak lolos
			jika semua reviewer menentukan lolos maka status akan secara otomatis berubah menjadi lolos
			jika semua reviewer menentukan perbaikan maka status akan secara otomatis berubah menjadi perbaikan
			jika semua reviewer menentukan tidak lolos status akan berubah menjadi tidak lolos
			selainnya terjadi dispute statusnya berubah menjadi "Menunggu Sidang Komite" 
			?untuk menentukan status lolos maka rumusnya adalah penjumlahan angka hasil_asesmen dibagi 1 yang hasilnya adalah jumlah reviewer
			?untuk menentukan status perbaikan maka rumusnya adalah penjumlahan angka hasil_asesmen dibagi 2 yang hasilnya adalah jumlah reviewer
			?untuk menentukan status tidak lolos maka rumusnya adalah penjumlahan angka hasil_asesmen dibagi 3 yang hasilnya adalah jumlah reviewer
		*/
/*
		# set jumlah reviewer dan total angka hasil asesmen
		$sql = "SELECT COUNT(id_user) as jumlah_reviewer, SUM(hasil_asesmen) as total_hasil_asesmen 
				FROM reviewer 
				WHERE kd_pengajuan = '$kd_pengajuan'";		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		foreach ($result as $row) {
			$jumlah_reviewer = $row['jumlah_reviewer'];
			$total_hasil_asesmen = $row['total_hasil_asesmen'];
		}

		# cek apakah masih ada nilai 0
		$sql = "SELECT hasil_asesmen
				FROM reviewer 
				WHERE kd_pengajuan = '$kd_pengajuan'";		
		$query = $this->db->query($sql);
		$result = $query->result_array();

		# buat dulu data arraynya
		foreach ($result as $row) {
			$cek_nilai[] = $row['hasil_asesmen'];
		}


		if (in_array("0", $cek_nilai)) {
			# bernilai 'true' => masih ada reviewer yang belum memberikan penilaian

		} else {
			# bernilai 'false' => semua reviewer sudah memberikan penilaian			
			
			# cek nilai beda => untuk memastikan semua reviewer memberikan nilai yang sama
			$i = 0;
			$flag_nilai_beda = 0;
			foreach ($cek_nilai as $row) 
			{
				if ($cek_nilai[0] == $cek_nilai[$i]) {
					# jika reviewer pertama memberikan nilai yang sama dengan reviewer berikutnya
					$flag_nilai_beda += 0;
				} else {
					# jika reviewer pertama memberikan nilai yang tidak sama dengan reviewer berikutnya
					$flag_nilai_beda += 1;
				}
				$i++;
			}

			if ($flag_nilai_beda == 0) {
				# jika semua reviewer memberikan nilai yang sama
				# set total angka hasil nilai asesmen di bagi dengan jumlah reviewer
				$cek_hasil = $total_hasil_asesmen / $jumlah_reviewer;
				if ($cek_hasil == 1) {
				 	# status lolos
				 	$tgl_lolos = date('Y-m-d H:i:s');
					$sql = "UPDATE pengajuan SET status = 9, tgl_periksa_reviewer_2 = '$tgl_lolos' WHERE kd_pengajuan = '$kd_pengajuan'";
				}  else if ($cek_hasil == 2){
				 	# status perbaikan
				 	$sql = "UPDATE pengajuan SET status = 4, flag_perbaikan = 1 WHERE kd_pengajuan = '$kd_pengajuan'";
				} else if ($cek_hasil == 3){
				 	# status tidak lolos
				 	$sql = "UPDATE pengajuan SET status = 5 WHERE kd_pengajuan = '$kd_pengajuan'";
				}				
			} else {
				# jika ada salah satu atau beberapa reviewer memberikan nilai berbeda
				# menunggu sidang komisi
			 	$sql = "UPDATE pengajuan SET status = 6, flag_sidang = 1 WHERE kd_pengajuan = '$kd_pengajuan'";
			}

			 $query = $this->db->query($sql);				
		}		*/
	}

	public function simpan_hasil_asesmen_sidang()
	{
		$kd_pengajuan = $this->input->post('_kd_pengajuan');
		$id_user = $this->input->post('_id_user');
		$hasil_asesmen = $this->input->post('hasil_asesmen');

		# karena datanya sudah ada maka hanya tinggal edit		
		$where = [
			'kd_pengajuan' => $kd_pengajuan,
			'id_user' => $id_user
		];
		$data = [
			'tgl_penilaian' => date("Y-m-d"),
			'hasil_asesmen' => $hasil_asesmen
		];
		$this->db->update('reviewer', $data, $where);

		/* 
			untuk menghasilkan status secara otomatis, ketika reviewer menentukan lolos, perbaikan atau tidak lolos
			jika semua reviewer menentukan lolos maka status akan secara otomatis berubah menjadi lolos
			jika semua reviewer menentukan perbaikan maka status akan secara otomatis berubah menjadi perbaikan
			jika semua reviewer menentukan tidak lolos status akan berubah menjadi tidak lolos
			selainnya terjadi dispute statusnya berubah menjadi "Menunggu Sidang Komite" 
			?untuk menentukan status lolos maka rumusnya adalah penjumlahan angka hasil_asesmen dibagi 1 yang hasilnya adalah jumlah reviewer
			?untuk menentukan status perbaikan maka rumusnya adalah penjumlahan angka hasil_asesmen dibagi 2 yang hasilnya adalah jumlah reviewer
			?untuk menentukan status tidak lolos maka rumusnya adalah penjumlahan angka hasil_asesmen dibagi 3 yang hasilnya adalah jumlah reviewer
		*/
/*
		# set jumlah reviewer dan total angka hasil asesmen
		$sql = "SELECT COUNT(id_user) as jumlah_reviewer, SUM(hasil_asesmen) as total_hasil_asesmen 
				FROM reviewer 
				WHERE kd_pengajuan = '$kd_pengajuan'";		
		$query = $this->db->query($sql);
		$result = $query->result_array();
		foreach ($result as $row) {
			$jumlah_reviewer = $row['jumlah_reviewer'];
			$total_hasil_asesmen = $row['total_hasil_asesmen'];
		}

		# cek apakah masih ada nilai 0
		$sql = "SELECT hasil_asesmen
				FROM reviewer 
				WHERE kd_pengajuan = '$kd_pengajuan'";		
		$query = $this->db->query($sql);
		$result = $query->result_array();

		# buat dulu data arraynya
		foreach ($result as $row) {
			$cek_nilai[] = $row['hasil_asesmen'];
		}


		if (in_array("0", $cek_nilai)) {
			# bernilai 'true' => masih ada reviewer yang belum memberikan penilaian

		} else {
			# bernilai 'false' => semua reviewer sudah memberikan penilaian			
			
			# cek nilai beda => untuk memastikan semua reviewer memberikan nilai yang sama
			$i = 0;
			$flag_nilai_beda = 0;
			foreach ($cek_nilai as $row) 
			{
				if ($cek_nilai[0] == $cek_nilai[$i]) {
					# jika reviewer pertama memberikan nilai yang sama dengan reviewer berikutnya
					$flag_nilai_beda += 0;
				} else {
					# jika reviewer pertama memberikan nilai yang tidak sama dengan reviewer berikutnya
					$flag_nilai_beda += 1;
				}
				$i++;
			}

			if ($flag_nilai_beda == 0) {
				# jika semua reviewer memberikan nilai yang sama
				# set total angka hasil nilai asesmen di bagi dengan jumlah reviewer
				$cek_hasil = $total_hasil_asesmen / $jumlah_reviewer;
				if ($cek_hasil == 1) {
				 	# status lolos
					$sql = "UPDATE pengajuan SET status = 9 WHERE kd_pengajuan = '$kd_pengajuan'";
				}  else if ($cek_hasil == 2){
				 	# status perbaikan
				 	$sql = "UPDATE pengajuan SET status = 7, flag_perbaikan = 1 WHERE kd_pengajuan = '$kd_pengajuan'";
				} else if ($cek_hasil == 3){
				 	# status tidak lolos
				 	$sql = "UPDATE pengajuan SET status = 8 WHERE kd_pengajuan = '$kd_pengajuan'";
				}				
			} else {
				# jika ada salah satu atau beberapa reviewer memberikan nilai berbeda
				# set status menjadi menunggu sidang komisi dan tandai si pengaju bahwa sudah pernah mengikuti sidang komisi dengan menset flag_sidang menjadi 1
			 	$sql = "UPDATE pengajuan SET status = 6, flag_sidang = 1 WHERE kd_pengajuan = '$kd_pengajuan'";
			}

			 $query = $this->db->query($sql);			
		}		*/
	}

	public function simpan_catatan_asesmen()
	{
		$kd_pengajuan = $this->input->post('catatan_kd_pengajuan');
		$id_user = $this->input->post('catatan_id_user');
		$tgl_catatan = $this->input->post('tgl_catatan');
		$catatan = $this->input->post('catatan');

		# karena datanya sudah ada maka hanya tinggal edit		
		$where = [
			'kd_pengajuan' => $kd_pengajuan,
			'id_user' => $id_user
		];
		$data = [
			'tgl_catatan' => tanggalToDb($tgl_catatan),
			'catatan' => $catatan
		];
		$this->db->update('reviewer', $data, $where);
		cek_output($where);cek_output($data);
		cek_output($_POST);
	}

	public function simpan_catatan_asesmen_2()
	{
		$kd_pengajuan = $this->input->post('catatan_kd_pengajuan');
		$id_user = $this->input->post('catatan_id_user');
		$tgl_catatan = $this->input->post('tgl_catatan_2');
		$catatan = $this->input->post('catatan_2');

		# karena datanya sudah ada maka hanya tinggal edit		
		$where = [
			'kd_pengajuan' => $kd_pengajuan,
			'id_user' => $id_user
		];
		$data = [
			'tgl_catatan_2' => tanggalToDb($tgl_catatan),
			'catatan_2' => $catatan
		];
		$this->db->update('reviewer', $data, $where);
	}

	public function simpan_catatan_asesmen_3()
	{
		$kd_pengajuan = $this->input->post('catatan_kd_pengajuan');
		$id_user = $this->input->post('catatan_id_user');
		$tgl_catatan = $this->input->post('tgl_catatan_3');
		$catatan = $this->input->post('catatan_3');

		# karena datanya sudah ada maka hanya tinggal edit		
		$where = [
			'kd_pengajuan' => $kd_pengajuan,
			'id_user' => $id_user
		];
		$data = [
			'tgl_catatan_3' => tanggalToDb($tgl_catatan),
			'catatan_3' => $catatan
		];
		$this->db->update('reviewer', $data, $where);
	}

	public function simpan_catatan_asesmen_sidang()
	{
		$kd_pengajuan = $this->input->post('catatan_kd_pengajuan');
		$id_user = $this->input->post('catatan_id_user');
		$catatan = $this->input->post('catatan');

		# karena datanya sudah ada maka hanya tinggal edit		
		$where = [
			'kd_pengajuan' => $kd_pengajuan,
			'id_user' => $id_user
		];
		$data = [
			'catatan_sidang' => $catatan
		];
		$this->db->update('reviewer', $data, $where);
		cek_output($where);cek_output($data);
		cek_output($_POST);
	}

	public function hasil_asesmen_peneliti()
	{
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];

		# asesmen kelengkapan berkas
		$array = $this->DaftarPeriksaModel->getPemeriksa($id_user);
		foreach ($array as $row){
			$data['nm_pemeriksa_sekre'] = $row['nama'];
		}
		$data['id_user'] = $id_user;
		$data['test'] = $this->DaftarPeriksaModel->getPemeriksa($id_user);
        $data['kd_pengajuan'] = $this->input->post('kd_pengajuan'); 
        $kd_pengajuan = $this->input->post('kd_pengajuan'); 
        $data['result_kelengkapan_berkas'] = $this->DaftarPeriksaModel->getKelengkapanBerkas($kd_pengajuan);

        foreach ($this->PengajuanModel->getData($kd_pengajuan) as $row)
        {
            $data['nm_pemeriksa_sekre'] = $row['nm_pemeriksa_sekre'];
            $data['catatan_perbaikan_sekre'] = $row['catatan_perbaikan_sekre'];
            $data['judul_penelitian'] = $row['judul_bhs_ind'];
            $data['peneliti_utama'] = $row['peneliti_utama'];
        }

        # hasil asesmen dari reviewer
		$sql = "SELECT DISTINCT id_user, nama, tgl_penugasan, tgl_penilaian FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' ";
		$query = $this->db->query($sql);
		$result_reviewer = $query->result_array();

		$arrays_catatan = $this->DaftarPeriksaModel->getHasilAsesmen($kd_pengajuan);
		$array_catatan = array();
		$array_catatan_reviewer = $arrays_catatan;
		
		foreach($arrays_catatan as $row){
			$array_catatan[$row['nama']] = [ 'catatan'=> $row['catatan'], 'catatan_sidang'=> $row['catatan_sidang'] ];
		}

		# set flag sidang untuk menentukan header catatan dari peneliti -> jika flag_sidang terset 1 maka kolom header tambahkan catatan sidang
		$sql = "SELECT status, flag_sidang FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$result = $query->result_array();
		foreach ($result as $row) {
			$data['status'] = $row['status'];
			$data['flag_sidang'] = $row['flag_sidang'];
		}

		$data['result_reviewer'] = $result_reviewer;
		$data['array_catatan'] = $array_catatan;
		$data['array_catatan_reviewer'] = $array_catatan_reviewer;
        $this->load->view('peneliti/hasil_asesmen_peneliti_view', $data);
	}

	function lembar_penilaian_peneliti_per_reviewer() 
	{
		$id_user = $this->input->post('id_user');
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		# tentukan permohonan masuk, nama peneliti dan judul
		$data['pengajuan'] = $this->PengajuanModel->getData($kd_pengajuan);
		$data['id_user'] = $id_user;
		$data['kd_pengajuan'] = $this->input->post('kd_pengajuan');
		$data['komponen'] = $this->PertanyaanModel->komponen();
		$data['pertanyaan'] = $this->PertanyaanModel->getPertanyaanAll();
		$data['jawaban'] = $this->PertanyaanModel->getJawaban($this->input->post('kd_pengajuan'));
		$data['array_id_pertanyaan'] = $this->PertanyaanModel->getIdPertanyaan();

		$sql = "SELECT status, flag_sidang FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$result = $query->result_array();
		foreach ($result as $row) {
			$data['status'] = $row['status'];
			$data['flag_sidang'] = $row['flag_sidang'];
		}

		$sql = "SELECT id_pertanyaan, asesmen FROM asesmen_etik WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$data['array_asesmen'] = $query->result_array();
		
		$sql = "SELECT * FROM reviewer WHERE kd_pengajuan = '$kd_pengajuan' AND id_user = '$id_user' ";
		$query = $this->db->query($sql);  //untuk mendisable tombol simpan 
		$data['array_hasil_asesmen'] = $query->result_array();
		$this->load->view('peneliti/ajax_lembar_penilaian_peneliti_per_reviewer', $data);
		//cek_output($data);
	}
}