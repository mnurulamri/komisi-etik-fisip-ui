<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set("display_errors", 1);
class Pengajuan extends CI_Controller {

	private $id_user;
	private $nama_user;

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('tanggal_helper');
		$this->load->helper('tombol_aksi_helper');
		$this->load->helper('catatan_helper');
		$this->load->helper('menu_helper');
		$this->load->helper('cek_output_helper');
		$this->load->model('PengajuanModel');
		$this->load->model('UploadModel');
		$this->load->library('form_validation');
		$this->load->library('session');

		$this->id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$array_identitas = $this->PengajuanModel->getIdentitas($this->id_user);
		foreach ($array_identitas as $row) {
			$this->nama_user = $row['nama'];
		}
	}

	public function form()
	{
		//$data['script'] = $this->load->view('script/test', null, null);
		//$this->load->view('layout/header');
		//$this->load->view('layout/sidebar');
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$data['identitas'] = $this->PengajuanModel->getIdentitas($id_user);
		$this->load->view('form/pengajuan', $data);
		//$this->load->view('layout/footer');
	}

	public function tambah()
	{

		//$post = $this->input->post(); 
		//$data['message'] = $this->PengajuanModel->tambah();
		//print_r($post);



		//$array_tgl_penelitian = explode(" ", $tgl_penelitian_temp);
		//$tgl_penelitian = tanggalToDb($tgl_penelitian_temp);
		//$tgl_penelitian = $tgl_penelitian_temp();
		
		// jika isian form masih kosong maka tidak diproses
        $this->form_validation->set_rules('judul_bhs_ind', 'Judul Penelitian (Bhs. Indonesia)', 'required');
        $this->form_validation->set_rules('judul_bhs_eng', 'Judul Penelitian (Bhs. Inggris)', 'required');
        $this->form_validation->set_rules('subjek_penelitian', 'Subjek Penelitian (Bhs. Indonesia)', 'required');
        $this->form_validation->set_rules('subjek_penelitian_eng', 'Subjek Penelitian (Bhs. Inggris)', 'required');
        $this->form_validation->set_rules('peneliti_utama', 'Peneliti Utama', 'required');
        $this->form_validation->set_rules('tempat_penelitian', 'Tempat Penelitian', 'required');
        $this->form_validation->set_rules('tgl_penelitian_awal', 'Tanggal Penelitian Awal', 'required');
        $this->form_validation->set_rules('tgl_penelitian_akhir', 'Tanggal Penelitian Akhir', 'required');
        $this->form_validation->set_rules('nama_lembaga_pengusul', 'Nama Lembaga Pengusul', 'required');
        $this->form_validation->set_rules('unit_lembaga_pengusul', 'Unit Lembaga Pengusul', 'required');
        $this->form_validation->set_rules('sumber_dana', 'LSumber Dana', 'required');
        $this->form_validation->set_rules('total_sumber_dana', 'Jumlah Sumber Dana', 'required');
        $this->form_validation->set_message('required', '{field} tidak boleh kosong!');

        if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
            //echo json_encode(['validasi_error'=>$errors]);
            //echo json_encode($errors);
            $json = array(
                'judul_bhs_ind' => form_error('judul_bhs_ind', '<p class="mt-3 text-danger">', '</p>'),
                'judul_bhs_eng' => form_error('judul_bhs_eng', '<p class="mt-3 text-danger">', '</p>'),
                'subjek_penelitian' => form_error('subjek_penelitian', '<p class="mt-3 text-danger">', '</p>'),
                'subjek_penelitian_eng' => form_error('subjek_penelitian_eng', '<p class="mt-3 text-danger">', '</p>'),
                'peneliti_utama' => form_error('peneliti_utama', '<p class="mt-3 text-danger">', '</p>'),
                'tempat_penelitian' => form_error('tempat_penelitian', '<p class="mt-3 text-danger">', '</p>'),
                'tgl_penelitian_awal' => form_error('tgl_penelitian_awal', '<p class="mt-3 text-danger">', '</p>'),
                'tgl_penelitian_akhir' => form_error('tgl_penelitian_akhir', '<p class="mt-3 text-danger">', '</p>'),
                'nama_lembaga_pengusul' => form_error('nama_lembaga_pengusul', '<p class="mt-3 text-danger">', '</p>'),
                'unit_lembaga_pengusul' => form_error('unit_lembaga_pengusul', '<p class="mt-3 text-danger">', '</p>'),
                'sumber_dana' => form_error('sumber_dana', '<p class="mt-3 text-danger">', '</p>'),
                'total_sumber_dana' => form_error('total_sumber_dana', '<p class="mt-3 text-danger">', '</p>')
            );
			$data_error = ['validasi_error' => $json];
			echo json_encode($data_error);
			//echo json_encode($json);
			//echo json_encode(array('error' => $json));
        } else {
			
			# set variabel
			//$kd_pengajuan = $this->PengajuanModel->createKode();
			
			$a = $this->input; 
			$id_user = $a->post('id_user');
			$tgl_input = date('Y-m-d');
			$judul_bhs_ind = $a->post('judul_bhs_ind');
			$judul_bhs_eng = $a->post('judul_bhs_eng');
			$subjek_penelitian = $a->post('subjek_penelitian');
			$subjek_penelitian_eng = $a->post('subjek_penelitian_eng');
			$peneliti_utama = $a->post('peneliti_utama');
			$peneliti_anggota = $a->post('peneliti_anggota');
			//$multi_senter = $a->post('multi_senter');
			//$tempat_multi_senter = $a->post('tempat_multi_senter');
			//$persetujuan_etik_lain = $a->post('persetujuan_etik_lain');
			$tempat_penelitian = $a->post('tempat_penelitian');
			$tgl_penelitian_awal = tanggalToDb($a->post('tgl_penelitian_awal'));
			$tgl_penelitian_akhir = tanggalToDb($a->post('tgl_penelitian_akhir'));
			$nama_lembaga_pengusul = $a->post('nama_lembaga_pengusul');
			$unit_lembaga_pengusul = $a->post('unit_lembaga_pengusul');
			$sumber_dana = $a->post('sumber_dana');
			$total_sumber_dana = $a->post('total_sumber_dana');        	
			$total_sumber_dana = str_replace(",", "", $total_sumber_dana);

			# set array data untuk proses ke database
			$data = array(
				//'kd_pengajuan' => $kd_pengajuan,
				'id_user' => $id_user,
				'tgl_input' => $tgl_input,
				'judul_bhs_ind' => addslashes($judul_bhs_ind),
				'judul_bhs_eng' => addslashes($judul_bhs_eng),
				'subjek_penelitian' => addslashes($subjek_penelitian),
				'subjek_penelitian_eng' => addslashes($subjek_penelitian_eng),
				'peneliti_utama' => addslashes($peneliti_utama),
				'peneliti_anggota' => addslashes($peneliti_anggota),
				//'multi_senter' => $multi_senter,
				//'tempat_multi_senter' => addslashes($tempat_multi_senter),
				//'persetujuan_etik_lain' => $persetujuan_etik_lain,
				'tempat_penelitian' => $tempat_penelitian,
				'tgl_penelitian_awal' => $tgl_penelitian_awal,
				'tgl_penelitian_akhir' => $tgl_penelitian_akhir,
				'status' => 0,
				'nama_lembaga_pengusul' => $nama_lembaga_pengusul,
				'unit_lembaga_pengusul' => $unit_lembaga_pengusul,
				'sumber_dana' => $sumber_dana,
				'total_sumber_dana' => $total_sumber_dana
				
			);
			
			# set variabel kode pengajuan
			if(empty($this->input->post('kd_pengajuan'))){
				# jika kosong maka buat kode baru
				$kd_pengajuan = $this->PengajuanModel->createKode();
				$data['kd_pengajuan'] = $kd_pengajuan;
				$this->PengajuanModel->tambah($data);
			} else {
				# jika ada maka pake kode yang sebelumnya sudah diinput
				$kd_pengajuan = $this->input->post('kd_pengajuan');
				$data['kd_pengajuan'] = $kd_pengajuan;
				$this->PengajuanModel->edit($kd_pengajuan, $data);
			}

			$json = array(
				'success'=>'Record added successfully.',
				'kd_pengajuan'=> $kd_pengajuan
			);
			
			echo json_encode(['validasi_ok'=>$json]);
        }
	}

	public function edit()
	{
		$this->form_validation->set_rules('judul_bhs_ind', 'Judul Penelitian (Bhs. Indonesia)', 'required');
        $this->form_validation->set_rules('judul_bhs_eng', 'Judul Penelitian (Bhs. Inggris)', 'required');
        $this->form_validation->set_rules('subjek_penelitian', 'Subjek Penelitian (Bhs. Indonesia)', 'required');
        $this->form_validation->set_rules('subjek_penelitian_eng', 'Subjek Penelitian (Bhs. Inggris)', 'required');
        $this->form_validation->set_rules('peneliti_utama', 'Peneliti Utama', 'required');
        $this->form_validation->set_rules('tempat_penelitian', 'Tempat Penelitian', 'required');
        $this->form_validation->set_rules('tgl_penelitian_awal', 'Tanggal Penelitian Awal', 'required');
        $this->form_validation->set_rules('tgl_penelitian_akhir', 'Tanggal Penelitian Akhir', 'required');
        $this->form_validation->set_rules('nama_lembaga_pengusul', 'Nama Lembaga Pengusul', 'required');
        $this->form_validation->set_rules('unit_lembaga_pengusul', 'Unit Lembaga Pengusul', 'required');
        $this->form_validation->set_rules('sumber_dana', 'LSumber Dana', 'required');
        $this->form_validation->set_rules('total_sumber_dana', 'Jumlah Sumber Dana', 'required');
        $this->form_validation->set_message('required', '{field} tidak boleh kosong!');

        if ($this->form_validation->run() == FALSE){
            //$errors = validation_errors();
            //echo json_encode(['error'=>$errors]);
            $json = array(
                'judul_bhs_ind' => form_error('judul_bhs_ind', '<p class="mt-3 text-danger">', '</p>'),
                'judul_bhs_eng' => form_error('judul_bhs_eng', '<p class="mt-3 text-danger">', '</p>'),
                'subjek_penelitian' => form_error('subjek_penelitian', '<p class="mt-3 text-danger">', '</p>'),
                'subjek_penelitian_eng' => form_error('subjek_penelitian_eng', '<p class="mt-3 text-danger">', '</p>'),
                'peneliti_utama' => form_error('peneliti_utama', '<p class="mt-3 text-danger">', '</p>'),
                'tempat_penelitian' => form_error('tempat_penelitian', '<p class="mt-3 text-danger">', '</p>'),
                'tgl_penelitian_awal' => form_error('tgl_penelitian_awal', '<p class="mt-3 text-danger">', '</p>'),
                'tgl_penelitian_akhir' => form_error('tgl_penelitian_akhir', '<p class="mt-3 text-danger">', '</p>'),
                'nama_lembaga_pengusul' => form_error('nama_lembaga_pengusul', '<p class="mt-3 text-danger">', '</p>'),
                'unit_lembaga_pengusul' => form_error('unit_lembaga_pengusul', '<p class="mt-3 text-danger">', '</p>'),
                'sumber_dana' => form_error('sumber_dana', '<p class="mt-3 text-danger">', '</p>'),
                'total_sumber_dana' => form_error('total_sumber_dana', '<p class="mt-3 text-danger">', '</p>'),
            );
			echo json_encode(['error'=>$json]);
        } else {

			$a = $this->input; 
			$kd_pengajuan = $a->post('kd_pengajuan');
			$judul_bhs_ind = $a->post('judul_bhs_ind');
			$judul_bhs_eng = $a->post('judul_bhs_eng');
			$subjek_penelitian = $a->post('subjek_penelitian');
			$subjek_penelitian_eng = $a->post('subjek_penelitian_eng');
			$peneliti_utama = $a->post('peneliti_utama');
			$peneliti_anggota = $a->post('peneliti_anggota');
			//$multi_senter = $a->post('multi_senter');
			//$tempat_multi_senter = $a->post('tempat_multi_senter');
			//$persetujuan_etik_lain = $a->post('persetujuan_etik_lain');
			$tempat_penelitian = $a->post('tempat_penelitian');
			$tgl_penelitian_awal = tanggalToDb($a->post('tgl_penelitian_awal'));
			$tgl_penelitian_akhir = tanggalToDb($a->post('tgl_penelitian_akhir'));
			$nama_lembaga_pengusul = $a->post('nama_lembaga_pengusul');
			$unit_lembaga_pengusul = $a->post('unit_lembaga_pengusul');
			$sumber_dana = $a->post('sumber_dana');
			$total_sumber_dana = $a->post('total_sumber_dana');
			$total_sumber_dana = str_replace(",", "", $total_sumber_dana);

			# set array
			$data = array(
				'kd_pengajuan' => $kd_pengajuan,
				'judul_bhs_ind' => addslashes($judul_bhs_ind),
				'judul_bhs_eng' => addslashes($judul_bhs_eng),				
				'subjek_penelitian' => addslashes($subjek_penelitian),
				'subjek_penelitian_eng' => addslashes($subjek_penelitian_eng),
				'peneliti_utama' => addslashes($peneliti_utama),
				'peneliti_anggota' => addslashes($peneliti_anggota),
				//'multi_senter' => $multi_senter,
				//'tempat_multi_senter' => addslashes($tempat_multi_senter),
				//'persetujuan_etik_lain' => $persetujuan_etik_lain,
				'tempat_penelitian' => $tempat_penelitian,
				'tgl_penelitian_awal' => $tgl_penelitian_awal,
				'tgl_penelitian_akhir' => $tgl_penelitian_akhir,
				'nama_lembaga_pengusul' => $nama_lembaga_pengusul,
				'unit_lembaga_pengusul' => $unit_lembaga_pengusul,
				'sumber_dana' => $sumber_dana,
				'total_sumber_dana' => $total_sumber_dana
			);

			$this->PengajuanModel->edit($kd_pengajuan, $data);
			echo json_encode(['sukses'=>$data]);
        }
		//var_dump($data);
	}
	
	public function lihat_data()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$result = $this->PengajuanModel->getData($kd_pengajuan);
		$data['result'] = $result;
		foreach ($result as $row)
		{
			$data['kd_pengajuan'] = $row['kd_pengajuan'];
			$data['judul_bhs_ind'] = $row['judul_bhs_ind'];
			$data['judul_bhs_eng'] = $row['judul_bhs_eng'];
			$data['subjek_penelitian'] = $row['subjek_penelitian'];
			$data['subjek_penelitian_eng'] = $row['subjek_penelitian_eng'];
			$data['peneliti_utama'] = $row['peneliti_utama'];
			$data['peneliti_anggota'] = $row['peneliti_anggota'];
			//$data['multi_senter'] = $row['multi_senter'];
			//$data['tempat_multi_senter'] = $row['tempat_multi_senter'];
			//$data['persetujuan_multi_senter'] = $row['persetujuan_multi_senter'];
			$data['tempat_penelitian'] = $row['tempat_penelitian'];
			$data['tgl_penelitian_awal'] = dbToTanggal($row['tgl_penelitian_awal']);
			$data['tgl_penelitian_akhir'] = dbToTanggal($row['tgl_penelitian_akhir']);
			
			if($row['multi_senter'] == 1){
				$data['checked_multi_senter_ya'] = 'checked="checked"';
				$data['checked_multi_senter_tidak'] = '';
			} else if($row['multi_senter'] == 0){
				$data['checked_multi_senter_ya'] = '';
				$data['checked_multi_senter_tidak'] = 'checked="checked"';
			}
			
			if($row['persetujuan_etik_lain'] == 1){
				$data['checked_etik_lain_ya'] = 'checked="checked"';
				$data['checked_etik_lain_tidak'] = '';
			} else if($row['persetujuan_etik_lain'] == 0){
				$data['checked_etik_lain_ya'] = '';
				$data['checked_etik_lain_tidak'] = 'checked="checked"';
			}
			
			$data['status'] = $row['status'];
			$data['nama_lembaga_pengusul'] = $row['nama_lembaga_pengusul'];
			$data['unit_lembaga_pengusul'] = $row['unit_lembaga_pengusul'];
			$data['sumber_dana'] = $row['sumber_dana'];
			$data['total_sumber_dana'] = $row['total_sumber_dana'];
		}

		$data['dokumen_penunjang'] = $this->dokumen_penunjang($kd_pengajuan, $data['status']);

		//$this->load->view('form/pengajuan_edit', $data);
		$this->load->view('peneliti/pengajuan_edit_view', $data);
	}
	
	public function daftar()
	{
		# cek sudah teregistrasi atau belum
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		if (count($this->PengajuanModel->getIdentitas($id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');	
		} else {
			# jika sudah teregistrasi
			//$data['side_menu'] = $this->getMenu(0);
			$this->load->view('layout/header', array('nama' => $this->nama_user));
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('form/daftar_pengajuan');
			$this->load->view('layout/footer');
		}
	}
	
	public function beranda()
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
			$countPerbaikanSekretariat = $this->PengajuanModel->countPerbaikanSekretariat($id_user);
			$countPerbaikanReviewer = $this->PengajuanModel->countPerbaikanReviewer($id_user);
			$countPerbaikanSidang = $this->PengajuanModel->countPerbaikanSidang($id_user);
			$countMenungguSidangKomisi = $this->PengajuanModel->countMenungguSidangKomisi($id_user);
			$data['array_count'] = array (
				'countPerbaikanSekretariat' => $countPerbaikanSekretariat,
				'countPerbaikanReviewer' => $countPerbaikanReviewer,
				'countPerbaikanSidang' => $countPerbaikanSidang,
				'countMenungguSidangKomisi' => $countMenungguSidangKomisi
			);
			
			$this->load->view('layout/header', array('nama'=>$this->nama_user));
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('beranda', $data);
			$this->load->view('layout/footer');
		}
	}

	public function get_ajax_daftar()
	{
		$array = $this->PengajuanModel->getNamaStatus();
		foreach($array as $row){
			$status[$row['kd_status']] = $row['nm_status'];
		}
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$data['status'] = $status;
		$records = $this->PengajuanModel->getAjaxDaftar($id_user);
		$data['pengajuan'] = $records;
		$data['array_catatan'] = $this->PengajuanModel->getCatatanReviewer($id_user);

		$this->load->view('ajax/ajax_daftar_pengajuan', $data);
	}
	
	public function cek_data() 
	{
		# tampilan data sebelum menekan tombol ajukan
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$result = $this->PengajuanModel->getData($kd_pengajuan);
		$data['result'] = $result;
		foreach ($result as $row)
		{
			$data['kd_pengajuan'] = $row['kd_pengajuan'];
			$data['judul_bhs_ind'] = $row['judul_bhs_ind'];
			$data['judul_bhs_eng'] = $row['judul_bhs_eng'];
			$data['peneliti_utama'] = $row['peneliti_utama'];
			$data['peneliti_anggota'] = $row['peneliti_anggota'];
			$data['multi_senter'] = $row['multi_senter'];
			$data['tempat_multi_senter'] = $row['tempat_multi_senter'];
			$data['persetujuan_etik_lain'] = $row['persetujuan_etik_lain'];
			$data['tempat_penelitian'] = $row['tempat_penelitian'];
			$data['tgl_penelitian_awal'] = dbToTanggal($row['tgl_penelitian_awal']);
			$data['tgl_penelitian_akhir'] = dbToTanggal($row['tgl_penelitian_akhir']);
			$data['status'] = $row['status'];
			$data['nama_lembaga_pengusul'] = $row['nama_lembaga_pengusul'];
			$data['unit_lembaga_pengusul'] = $row['unit_lembaga_pengusul'];
			$data['sumber_dana'] = $row['sumber_dana'];
			$data['total_sumber_dana'] = $row['total_sumber_dana'];
		}
	
		$this->load->view('form/pengajuan_cek_data', $data);
	}
	
	public function status()
	{
		# set variable
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$status = $this->input->post('status');
		
		if($status==1)
		{
			$data = array(
				'status' => $status,
				'tgl_pengajuan' => date('Y-m-d')
			);
			//print_r($data);
			echo $this->PengajuanModel->setStatus($kd_pengajuan, $data);
		}
	}

	public function delete()
	{
		# set variable
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$this->PengajuanModel->delete($kd_pengajuan);
	}

	public function dokumen_penunjang_temp()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		$status = $this->input->post('status');
		echo $this->dokumen_penunjang($kd_pengajuan, $status);
	}
	
	public function dokumen_penunjang($kd_pengajuan, $status)
	{
		# set parameter
		/*$kd_pengajuan = ($this->input->post('kd_pengajuan')=='' or $this->input->post('kd_pengajuan')=='') ? $kd_pengajuan : $this->input->post('kd_pengajuan');
		$status = ($this->input->post('status')=='' or $this->input->post('status')=='') ? $status : $this->input->post('status');

		if ( empty($kd_pengajuan) or $kd_pengajuan == '' ) {
			$this->input->post('kd_pengajuan');
		}
		
		if ( empty($status)  or $status == '') {
			$this->input->post('status');
		}*/

		$array = $this->UploadModel->get_dokumen($kd_pengajuan);

		$html = '
		<table class="table table-bordered">
			<tr style="background:#aaa;">
				<th>Nama Dokumen</th>
				<th>File</th>
				<th></th>
			</tr>';


		if ($array['num_rows'] == 1)
		{
			foreach ($array['result'] as $row)
			{
				$html.= '
				<tr>
					<td>'.$row['view_name'].'</td>
					<td>
						<i class="view-dok fa fa-file-o" data-id="'.$kd_pengajuan.'" data-nama_dok="'.$row['file_name'].'" data-ext="'.$row['file_ext'].'"></i>
					</td>';
					# jika status = 0 maka tampilkan tombol upload
					if ($status == 0){
						$html.='<td> <button id="upload" name="upload" data-id="surat_pengantar" data-view_name="1. Surat Pengantar" class="btn btn-xs btn-info upload">upload</button> </td>';
					} else {
						$html.= '<td></td>';
					}
					
				$html.= '</tr>';
				
			}
			$html.='
			<tr>
				<td>2. Bukti Transfer</td>
				<td></td>
				<td> <button id="upload" name="upload" data-id="bukti_transfer" data-view_name="2. Bukti Transfer" class="btn btn-xs btn-info upload">upload</button> </td>
			</tr>
			';
		} else {
			# jika data penunjang masih kosong
			$html.= '
			<tr>
				<td>1. Surat Pengantar</td>
				<td></td>
				<td> <button id="upload" name="upload" data-id="surat_pengantar" data-view_name="1. Surat Pengantar" class="btn btn-xs btn-info upload">upload</button> </td>
			</tr>
			<tr>
				<td>2. Bukti Transfer</td>
				<td></td>
				<td> <button id="upload" name="upload" data-id="bukti_transfer" data-view_name="2. Bukti Transfer" class="btn btn-xs btn-info upload">upload</button> </td>
			</tr>';
		}

		$html .= '</table>';
		return $html;
		//var_dump($array['num_rows']);
	}

	function view_dokumen()
	{
		$kd_pengajuan = $this->input->post('kd_pengajuan');
    	$ext_file = $this->input->post('ext_file');
    	$nama_dok = $this->input->post('nama_dok');
		$nama_file = $kd_pengajuan.'_'.$nama_dok.$ext_file;
    	echo $nama_file;
		if ($ext_file == '.jpg' or $ext_file == '.jpeg' or $ext_file == '.png' or $ext_file == '.gif' or $ext_file == '.bmp') 
		{
			echo '<img src="'.base_url().'dokumen/penunjang/'.$nama_file.'" height="100%" width="100%">';
		} else if($ext_file == '.pdf'){	
			echo '
			<div style="text-align:center">
				<embed src="'.base_url().'assets/pdf_viewer/web/viewer.html?file='.base_url().'dokumen/penunjang/'.$nama_file.'" width="898" height="800">
			</div>';
			echo base_url().'assets/pdf_viewer/web/viewer.html?file='.base_url().'dokumen/penunjang/'.$nama_file;
		} else {
			echo 'not supported file';
		}
    }

    public function data_peneliti()
    {
		$nama_status = $this->uri->segment(3);

		if($nama_status == ''){
			$kd_status = '(0,1,2,3,4,5,6,7,8,9,10,11)';
		} else if($nama_status == 'belum_diajukan'){
			$kd_status = '(0)';
		} else if($nama_status == 'menunggu_konfirmasi'){
			$kd_status = '(1)';
		} else if($nama_status == 'penugasan_reviewer'){
			$kd_status = '(10)';
		} else if($nama_status == 'menunggu_penilaian'){
			$kd_status = '(3)';
		} else if($nama_status == 'perlu_perbaikan'){
			$kd_status = '(2,4,7)';
		} else if($nama_status == 'menunggu_sidang_komisi'){
			$kd_status = '(6)';
		} else if($nama_status == 'tidak_lolos'){
			$kd_status = '(5,8)';
		} else if($nama_status == 'lolos'){
			$kd_status = '(9)';
		} else if($nama_status == 'tidak dilanjutkan'){
			$kd_status = '(11)';
		}

		$data['kd_status'] = $kd_status;

        $this->load->view('layout/header', array('nama'=>$this->nama_user));
        $this->load->view('layout/sidebar');
        $this->load->view('peneliti/daftar', $data);
        $this->load->view('layout/footer');
    }

    public function ajax_daftar_peneliti()
    {
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		$kd_status = $this->input->post('kd_status');
		
        # buat array status untuk menentukan nama status
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;

        $records = $this->PengajuanModel->ajaxDaftarPeneliti($kd_status, $id_user);
        $data['pengajuan'] = $records;
        $data['array_catatan'] = $this->PengajuanModel->getCatatanReviewerAll();
        $this->load->view('peneliti/ajax_daftar_peneliti', $data);
    }

    /*
	public function getMenu($parent) 
    {

        //global $con;
        //$role = '`'.$this->session->userdata('role_id').'`';      
        $role = '`'.'1'.'`';
        
        $sql = "SELECT * FROM menu where $role = 1 and parent = '$parent' ORDER BY sort";
        $query = $this->db->query($sql);
        $menu='';
        $i=0;
        foreach ($query->result_array() as $row)
        {
        	if($row['link'] != "#"){
        		$menu.= '
        		<li> <a href="'.site_url().$row['link'].'"><span>'.$row['label'].'</span></a> </li>';
        	} else {
        		$menu.= '
        		<li class="treeview"> 
        			<a href="#"><i class="fa fa-link"></i> <span>'.$row['label'].'</span>
						<span class="pull-right-container">
							<i class="fa fa-angle-left pull-right"></i>
						</span>
					</a>
        			<ul class="treeview-menu">
        				'.$this->getMenu($row['id']).' 
        			</ul> 
        		</li>';
        	}  
        }
        return $menu; 
    }
    */

	/* untuk pengajuan baru */
	public function pengajuan_baru()
	{
		# cek sudah teregistrasi atau belum
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		if (count($this->PengajuanModel->getIdentitas($id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');	
		} else {

			/************************************************
				Lakukan proses jika sudah teregistrasi:
				cek dulu apakah sudah ada data pengajuan yang sudah disampaikan sebelumnya
				jika sudah ada maka berikan notif bahwa pengajuan berikutnya tidak bisa dilakukan sampai
				sekretariat memberikan penolakan atau perbaikan
				algoritma:
				- cek username
				- cek kode pengajuan -> masukkan ke dalam array
				- jika salah satu diantara nilai array ada yang bernilai true maka input data pengajuan baru tidak bisa dilakukan -> arahkan ke halaman notifikasi
			************************************************/ 			

			$sql = "SELECT kd_pengajuan, judul_bhs_ind, status FROM pengajuan WHERE id_user = '$id_user' AND status <> 9";
			$query = $this->db->query($sql);
			$num_rows = $query->num_rows();
			$result = $query->result_array();
			foreach($result as $row){
				$array['kd_pengajuan'] = $row['kd_pengajuan'];
				$array['judul_bhs_ind'] = $row['judul_bhs_ind'];
				$array['status'] = $row['status'];
			}
			# jika ada sejumlah data yang statusnya mengandung selain status lolos maka tandanya sudah ada data yang diajukan
			//echo '<pre>';print($num_rows);echo '</pre>';
						
			$this->load->view('layout/header', array('nama' => $this->nama_user));
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			/*if($num_rows > 0){
				$this->load->view('peneliti/pengajuan_blok_view', $array);
			} else {
				$this->load->view('peneliti/pengajuan_baru_view');
			}*/
			$this->load->view('peneliti/pengajuan_baru_view');  //testing
			$this->load->view('layout/footer');
			
			/*
			$this->load->view('layout/header', array('nama' => $this->nama_user));
			$this->load->view('layout/sidebar'); //$this->load->view('layout/sidebar', $data);
			$this->load->view('peneliti/pengajuan_baru_view');
			$this->load->view('layout/footer');
			*/
		}
	}

	public function form_pengajuan_protokol()
	{
		# cek sudah teregistrasi atau belum
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
		if (count($this->PengajuanModel->getIdentitas($id_user)) == 0) {
			# jika belum teriegistrasi bawa ke halaman registrasi
			redirect('autentikasi/registrasi');	
		} else {
			# jika sudah teregistrasi
			$data['identitas'] = $this->PengajuanModel->getIdentitas($id_user);
			$this->load->view('peneliti/pengajuan-protokol', $data);
		}
	}

	/* testing */
	

	public function tesTambah()
	{

		$post = $this->input->post(); 
		//$data['message'] = $this->PengajuanModel->tambah();
		//print_r(json_encode($post)); exit();



		//$array_tgl_penelitian = explode(" ", $tgl_penelitian_temp);
		//$tgl_penelitian = tanggalToDb($tgl_penelitian_temp);
		//$tgl_penelitian = $tgl_penelitian_temp();
		
		// jika isian form masih kosong maka tidak diproses
        $this->form_validation->set_rules('judul_bhs_ind', 'Judul Penelitian (Bhs. Indonesia)', 'required');
        $this->form_validation->set_rules('judul_bhs_eng', 'Judul Penelitian (Bhs. Inggris)', 'required');
        $this->form_validation->set_rules('subjek_penelitian', 'Subjek Penelitian (Bhs. Indonesia)', 'required');
        $this->form_validation->set_rules('subjek_penelitian_eng', 'Subjek Penelitian (Bhs. Inggris)', 'required');
        $this->form_validation->set_rules('peneliti_utama', 'Peneliti Utama', 'required');
        $this->form_validation->set_rules('tempat_penelitian', 'Tempat Penelitian', 'required');
        $this->form_validation->set_rules('tgl_penelitian_awal', 'Tanggal Penelitian Awal', 'required');
        $this->form_validation->set_rules('tgl_penelitian_akhir', 'Tanggal Penelitian Akhir', 'required');
        $this->form_validation->set_rules('nama_lembaga_pengusul', 'Nama Lembaga Pengusul', 'required');
        $this->form_validation->set_rules('unit_lembaga_pengusul', 'Unit Lembaga Pengusul', 'required');
        $this->form_validation->set_rules('sumber_dana', 'LSumber Dana', 'required');
        $this->form_validation->set_rules('total_sumber_dana', 'Jumlah Sumber Dana', 'required');
        $this->form_validation->set_message('required', '{field} tidak boleh kosong!');

        if ($this->form_validation->run() == FALSE){
            $errors = validation_errors();
            //echo json_encode(['validasi_error'=>$errors]);
            //echo json_encode($errors);
            $json = array(
                'judul_bhs_ind' => form_error('judul_bhs_ind', '<p class="mt-3 text-danger">', '</p>'),
                'judul_bhs_eng' => form_error('judul_bhs_eng', '<p class="mt-3 text-danger">', '</p>'),
                'subjek_penelitian' => form_error('subjek_penelitian', '<p class="mt-3 text-danger">', '</p>'),
                'subjek_penelitian_eng' => form_error('subjek_penelitian_eng', '<p class="mt-3 text-danger">', '</p>'),
                'peneliti_utama' => form_error('peneliti_utama', '<p class="mt-3 text-danger">', '</p>'),
                'tempat_penelitian' => form_error('tempat_penelitian', '<p class="mt-3 text-danger">', '</p>'),
                'tgl_penelitian_awal' => form_error('tgl_penelitian_awal', '<p class="mt-3 text-danger">', '</p>'),
                'tgl_penelitian_akhir' => form_error('tgl_penelitian_akhir', '<p class="mt-3 text-danger">', '</p>'),
                'nama_lembaga_pengusul' => form_error('nama_lembaga_pengusul', '<p class="mt-3 text-danger">', '</p>'),
                'unit_lembaga_pengusul' => form_error('unit_lembaga_pengusul', '<p class="mt-3 text-danger">', '</p>'),
                'sumber_dana' => form_error('sumber_dana', '<p class="mt-3 text-danger">', '</p>'),
                'total_sumber_dana' => form_error('total_sumber_dana', '<p class="mt-3 text-danger">', '</p>')
            );
			$data_error = ['validasi_error' => $json];
			echo json_encode($data_error);
			//echo json_encode($json);
			//echo json_encode(array('error' => $json));
        } else {
						
			$a = $this->input; 
			$id_user = $a->post('id_user');
			$tgl_input = date('Y-m-d');
			$judul_bhs_ind = $a->post('judul_bhs_ind');
			$judul_bhs_eng = $a->post('judul_bhs_eng');
			$subjek_penelitian = $a->post('subjek_penelitian');
			$subjek_penelitian_eng = $a->post('subjek_penelitian_eng');
			$peneliti_utama = $a->post('peneliti_utama');
			$peneliti_anggota = $a->post('peneliti_anggota');
			//$multi_senter = $a->post('multi_senter');
			//$tempat_multi_senter = $a->post('tempat_multi_senter');
			//$persetujuan_etik_lain = $a->post('persetujuan_etik_lain');
			$tempat_penelitian = $a->post('tempat_penelitian');
			$tgl_penelitian_awal = tanggalToDb($a->post('tgl_penelitian_awal'));
			$tgl_penelitian_akhir = tanggalToDb($a->post('tgl_penelitian_akhir'));
			$nama_lembaga_pengusul = $a->post('nama_lembaga_pengusul');
			$unit_lembaga_pengusul = $a->post('unit_lembaga_pengusul');
			$sumber_dana = $a->post('sumber_dana');
			$total_sumber_dana = $a->post('total_sumber_dana');        	
			$total_sumber_dana = str_replace(",", "", $total_sumber_dana);

			# set array
			$data = array(
				//'kd_pengajuan' => $kd_pengajuan,
				'id_user' => $id_user,
				'tgl_input' => $tgl_input,
				'judul_bhs_ind' => addslashes($judul_bhs_ind),
				'judul_bhs_eng' => addslashes($judul_bhs_eng),
				'subjek_penelitian' => addslashes($subjek_penelitian),
				'subjek_penelitian_eng' => addslashes($subjek_penelitian_eng),
				'peneliti_utama' => addslashes($peneliti_utama),
				'peneliti_anggota' => addslashes($peneliti_anggota),
				//'multi_senter' => $multi_senter,
				//'tempat_multi_senter' => addslashes($tempat_multi_senter),
				//'persetujuan_etik_lain' => $persetujuan_etik_lain,
				'tempat_penelitian' => $tempat_penelitian,
				'tgl_penelitian_awal' => $tgl_penelitian_awal,
				'tgl_penelitian_akhir' => $tgl_penelitian_akhir,
				'status' => 0,
				'nama_lembaga_pengusul' => $nama_lembaga_pengusul,
				'unit_lembaga_pengusul' => $unit_lembaga_pengusul,
				'sumber_dana' => $sumber_dana,
				'total_sumber_dana' => $total_sumber_dana				
			);

			# set variabel kode pengajuan
			if(empty($this->input->post('kd_pengajuan'))){
				# jika kosong maka buat kode baru
				$kd_pengajuan = $this->PengajuanModel->createKode();
				$data['kd_pengajuan'] = $kd_pengajuan;
				$proses = 'tambah data';
				$sql = "INSERT INTO pengajuan (kd_pengajuan, judul_bhs_ind) VALUES ('$kd_pengajuan', '$proses')";
				//$this->db->query($sql);
				$this->PengajuanModel->tambah($data);
			} else {
				# jika ada maka pake kode yang sebelumnya sudah diinput
				$kd_pengajuan = $this->input->post('kd_pengajuan');
				$data['kd_pengajuan'] = $kd_pengajuan;
				$this->PengajuanModel->edit($kd_pengajuan, $data);

				# cek recordnya dulu
				$sql = "SELECT id FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
				//$result = $this->db->query($sql);
				//$num_rows = $result->num_rows();
				
				//if($num_rows > 0){
				//	$proses = 'edit data';
				//	$sql = "UPDATE pengajuan SET judul_bhs_ind = '$proses' WHERE kd_pengajuan = '$kd_pengajuan'";
				//	$this->db->query($sql);
				//}
			}		

			
			#set nama field
			foreach($data as $k => $v){
				$field[] = $k;
			}
			
			#set nilai
			foreach($data as $k => $v){
				$value[] = $v;
			}
			
			#rekatkan nama field dan nilai
			$fields = implode(", ",$field);
			$values = "'".implode("', '",$value)."'";
			
			$json = array(
				'success'=>'Record added successfully.',
				'kd_pengajuan'=> $kd_pengajuan,
				'sql'=>$sql,
				'data'=>$data
			);
			echo json_encode(['validasi_ok'=>$json]);
			# tambahkan ke tabel pengajuan
			# cek data sebelumnya sudah ada atau tidak
			/*$kd_pengajuan = $data['kd_pengajuan'];
			$temp='';
			$sql = "SELECT id FROM pengajuan WHERE kd_pengajuan = '$kd_pengajuan'";
			$result = $this->db->query($sql);
			$num_rows =$result->num_rows();
			
			if($num_rows==0){
				$proses = 'tambah data';
				$sql = "INSERT INTO pengajuan (kd_pengajuan, judul_bhs_ind) VALUES ('$kd_pengajuan', '$proses')";
				$this->db->query($sql);
			} else {
				$proses = 'edit data';
				$sql = "UPDATE pengajuan SET judul_bhs_ind = '$proses'";
				$this->db->query($sql);
			}
			
			
			echo json_encode(['validasi_ok'=>$json]);
			*/
			/*echo $kd_pengajuan;
			var_dump($test);
			
			$post = array();
			foreach ( $_POST as $key => $value )
			{
			    $post[$key] = $this->input->post($key);
			}
           echo json_encode(['success'=>'Record added successfully.']);
			*/
        }
	}
}