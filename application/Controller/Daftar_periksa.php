<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_periksa extends CI_Controller 
{

	public function __construct()
    {
		parent::__construct();
		$this->load->database();
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
        $this->load->helper('text');
		//$this->load->model('PertanyaanModel');
	}

	public function sekretariat()
	{
		$this->load->view('layout/header');
		$this->load->view('layout/sidebar');
		$this->load->view('form/daftar_periksa');
		$this->load->view('layout/footer');
	}

    public function reviewer()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('form/daftar_periksa_reviewer');
        $this->load->view('layout/footer');
    }

    public function ketua_tim()
    {
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('form/daftar_periksa_ketua_tim');
        $this->load->view('layout/footer');
    }

    public function get_ajax_daftar_periksa()
    {
        # buat array status untuk menentukan nama status
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;

        $records = $this->DaftarPeriksaModel->getAjaxDaftar();
        $data['pengajuan'] = $records;
        $data['array_catatan'] = $this->PengajuanModel->getCatatanReviewerAll();
        $this->load->view('ajax/ajax_daftar_periksa', $data);
    }
    
    public function get_ajax_daftar_periksa_reviewer()
    {
        $kd_status = $this->input->post('kd_status');
        # buat array status untuk menentukan nama status
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;

        # tarik data pengajuan agar hanya memunculkan data yang sudah diajukan dengan reviewer terkait yang telah ditunjuk
        $id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
        $records = $this->DaftarPeriksaModel->getAjaxDaftarReviewer($id_user);
        $data['pengajuan'] = $records;
        $this->load->view('ajax/ajax_daftar_periksa_reviewer', $data);

        //cek_output($records);
    }

	public function get_ajax_daftar_periksa_ketua_tim()
    {
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;
        $records = $this->DaftarPeriksaModel->getAjaxDaftarKetuaTim();
        $data['pengajuan'] = $records;
        $this->load->view('ajax/ajax_daftar_periksa_ketua_tim', $data);
    }
    
    public function pengajuan() 
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
            $data['subjek_penelitian'] = $row['subjek_penelitian'];
            $data['subjek_penelitian_eng'] = $row['subjek_penelitian_eng'];
            $data['peneliti_utama'] = $row['peneliti_utama'];
            $data['peneliti_anggota'] = $row['peneliti_anggota'];
            $data['multi_senter'] = $row['multi_senter'];
            $data['tempat_multi_senter'] = $row['tempat_multi_senter'];
            $data['persetujuan_etik_lain'] = $row['persetujuan_etik_lain'];
            $data['tempat_penelitian'] = $row['tempat_penelitian'];
            $data['tgl_penelitian_awal'] = dbToTanggal($row['tgl_penelitian_awal']);
            $data['tgl_penelitian_akhir'] = dbToTanggal($row['tgl_penelitian_akhir']);
        }
    
        $this->load->view('form/pengajuan_periksa', $data);
    }

    public function protokol() 
    {
        $kd_pengajuan = $this->input->post('kd_pengajuan'); 
        $data['kd_pengajuan'] = $kd_pengajuan;
        $result = $this->ProtokolModel->getData($kd_pengajuan);
        $data['result'] = $result;
        $i = 0;
        foreach ($result as $row)
        {           
            $data['array'][] = array('Latar Belakang Dilakukannya Penelitian' => $row['motivasi']);
            $data['array'][] = array('Tujuan Penelitian' => $row['tujuan']);
			$data['array'][] = array('Manfaat Penelitian' => $row['manfaat']);
            $data['array'][] = array('Desain/Metode Penelitian' => $row['metode']);
            $data['array'][] = array('Unit Sampel' => $row['sample']);
            $data['array'][] = array('siapa saja yang akan direkrut sebagai sampel/peserta/informan' => $row['inklusi']);
            //$data['array'][] = array('Kriteria Eksklusi' => $row['eksklusi']);
            $data['array'][] = array('Rencana Analisis Data' => $row['analisis']);
            
            $data['array'][] = array('Risiko yang Mungkin Timbul Disertai Cara Mengatasinya' => $row['resiko']);
            $i++;
        }

        $this->load->view('form/protokol_periksa', $data);
    }

    public function asesmen_kelengkapan_berkas() 
    {
		$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
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

        $this->load->view('form/asesmen_kelengkapan_berkas', $data);
    }

    public function asesmen_kelengkapan_berkas_view() 
    {
        $kd_pengajuan = $this->input->post('kd_pengajuan');
        $data['result'] = $this->PengajuanModel->getData($kd_pengajuan);
        $data['result_kelengkapan_berkas'] = $this->DaftarPeriksaModel->getKelengkapanBerkas($kd_pengajuan);
        $data['kd_pengajuan'] = $this->input->post('kd_pengajuan'); 

		foreach ($this->PengajuanModel->getData($kd_pengajuan) as $row)
		{
			$data['nm_pemeriksa_sekre'] = $row['nm_pemeriksa_sekre'];
			$data['catatan_perbaikan_sekre'] = $row['catatan_perbaikan_sekre'];
            $data['judul_penelitian'] = $row['judul_bhs_ind'];
            $data['peneliti_utama'] = $row['peneliti_utama'];
		}

        $this->load->view('form/asesmen_kelengkapan_berkas_view', $data);
    }

    public function simpan_kelengkapan_berkas() 
    {
        $a = $this->input;
        $kd_pengajuan = $a->post('kd_pengajuan');
        $catatan = $a->post('catatan');
        $permohonan = $a->post('dokumen_1');
        $surat_pernyataan = $a->post('dokumen_2');
        $format_minimum = $a->post('dokumen_3');
        $nm_pemeriksa_sekre = $a->post('nm_pemeriksa_sekre');

        $data_periksa = array(
            'catatan_perbaikan_sekre' => $catatan, 
            'nm_pemeriksa_sekre' => $nm_pemeriksa_sekre
            //'tgl_periksa_sekre' => date('Y-m-d H:i:s')
        );

        $data_kelengkapan_berkas = array(
            'kd_pengajuan' => $kd_pengajuan,
            'permohonan' => $permohonan, 
            'surat_pernyataan' => $surat_pernyataan, 
            'format_minimum' => $format_minimum
        );

        # simpan ke dalam tabel pengajuan
        $this->DaftarPeriksaModel->editPemeriksa($kd_pengajuan, $data_periksa);
		//$sql = "UPDATE pengajuan SET ";

        # simpan ke dalam tabel kelengkapan berkas
        $this->DaftarPeriksaModel->simpan_kelengkapan_berkas($kd_pengajuan, $data_kelengkapan_berkas);
        //$this->cek_output($data_periksa);
        //$this->cek_output($data_kelengkapan_berkas);
    }    

    public function set_status() 
    {
        $kd_pengajuan = $this->input->post('kd_pengajuan');
        $crud = $this->input->post('crud');

        if ($crud == 2) // jika tidak lengkap
        {
            $catatan_perbaikan_sekre = $this->input->post('catatan');
            $data = array(
                //'catatan_perbaikan_sekre' => $catatan_perbaikan_sekre, 
                'status' => $crud, 
                //'nm_pemeriksa_sekre' => $nm_pemeriksa_sekre,
                'tgl_periksa_sekre' => date('Y-m-d H:i:s')
            );
        } 
        else if ($crud == 10) // menunggu penugasan reviewer
        {
            $data = array(
                'status' => $crud, 
                //'nm_pemeriksa_sekre' => $nm_pemeriksa_sekre,
                'tgl_periksa_sekre' => date('Y-m-d H:i:s')
            );
        }
        else if ($crud == 3) // jika reviewer sudah ditentukan oleh ketua komisi -> menunggu pemeriksaan reviewer tahap I
        {
            $data = array(
                'status' => $crud, 
                //'nm_pemeriksa_sekre' => $nm_pemeriksa_sekre,
                'tgl_periksa_sekre' => date('Y-m-d H:i:s')
            );
        }
        else if ($crud == 4) // jika ada perbaikan dari reviewer 1
        {
            $data = array(
                'status' => $crud, 
				'flag_perbaikan' => 1,
                'tgl_periksa_reviewer_1' => date('Y-m-d H:i:s')
            );
        }
		else if ($crud == 5) // jika tidak lolos dari reviewer 1
        {
            $data = array(
                'status' => $crud,
				//'catatan_tidak_lolos_reviewer_1' => $catatan_tidak_lolos_reviewer_1, 
                //'nm_pemeriksa_sekre' => $nm_pemeriksa_sekre,
                'tgl_periksa_sekre' => date('Y-m-d H:i:s')
            );
        }
		else if ($crud == 6) // jika disetujui reviewer 1 => menunggu persetujuan reviewer 2
        {
            $data = array(
                'status' => $crud,
				'flag_sidang' => 1,
                //'nm_pemeriksa_reviewer_1' => $nm_pemeriksa_reviewer_1,
                'tgl_periksa_reviewer_1' => date('Y-m-d H:i:s')
            );
        }
		else if ($crud == 7) // jika ada perbaikan dari reviewer 2
        {
            $data = array(
                'status' => $crud, 
				'flag_perbaikan' => 1,
				//'catatan_perbaikan_reviewer_2' => $catatan_perbaikan_reviewer_2, 
                //'nm_pemeriksa_reviewer_2' => $nm_pemeriksa_reviewer_2,
                'tgl_periksa_reviewer_2' => date('Y-m-d H:i:s')
            );
        }
		else if ($crud == 8) // jika tidak lolos dari reviewer 2
        {
            $data = array(
                'status' => $crud,
				//'catatan_tidak_lolos_reviewer_2' => $catatan_tidak_lolos_reviewer_2, 
                //'nm_pemeriksa_reviewer_2' => $nm_pemeriksa_reviewer_2,
                'tgl_periksa_reviewer_2' => date('Y-m-d H:i:s')
            );
        }
		else if ($crud == 9) // jika lolos dari reviewer 2
        {
            $data = array(
                'status' => $crud,
                //'nm_pemeriksa_reviewer_2' => $nm_pemeriksa_reviewer_2,
                'tgl_periksa_reviewer_2' => date('Y-m-d H:i:s')
            );
        }

        $this->DaftarPeriksaModel->setStatus($kd_pengajuan, $data);
    }

	public function hasil_asesmen() 
    {
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		
		# tarik data hasil asesmen dari tabel reviewer
		$data['array'] = $this->DaftarPeriksaModel->getHasilAsesmen($kd_pengajuan);
		$this->load->view('form/hasil_asesmen', $data);
	}
	
	public function hasil_asesmen_reviewer() 
    {
		$kd_pengajuan = $this->input->post('kd_pengajuan');
		
		# tarik data hasil asesmen dari tabel reviewer
		$data['array'] = $this->DaftarPeriksaModel->getHasilAsesmen($kd_pengajuan);
		$this->load->view('form/hasil_asesmen_reviewer', $data);
	}

    public function data_sekretariat()
    {
		$nama_status = $this->uri->segment(3);

		if($nama_status == ''){
            $kd_status = '(1,2,3,4,5,6,7,8,9,10)';
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
		} else if($nama_status == 'lolos_administratif'){
			$kd_status = '(3,4,6,7,8,9,10)';
		}

		$data['kd_status'] = $kd_status;

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('sekretariat/daftar', $data);
        $this->load->view('layout/footer');
    }

    public function ajax_daftar_sekretariat()
    {
		
		$kd_status = $this->input->post('kd_status');
		
        # buat array status untuk menentukan nama status
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;

        $records = $this->DaftarPeriksaModel->ajaxDaftarSekretariat($kd_status);
        $data['pengajuan'] = $records;
        $data['array_catatan'] = $this->PengajuanModel->getCatatanReviewerAll();
        $this->load->view('sekretariat/ajax_daftar_sekretariat', $data);
    }

    public function data_reviewer()
    {
        $nama_status = $this->uri->segment(3); 

        if($nama_status == ''){
            $kd_status = '(3,4,5,6,7,8,9,10)';
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
        }

        $data['kd_status'] = $kd_status;
        //cek_output($data); exit();
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('reviewer/daftar', $data);
        $this->load->view('layout/footer');
    }

    public function ajax_daftar_reviewer()
    {
        $id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
        $kd_status = $this->input->post('kd_status');
      
        # buat array status untuk menentukan nama status
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;
        
        $records = $this->DaftarPeriksaModel->ajaxDaftarReviewer($kd_status, $id_user);
        //cek_output($records); exit();
        $data['pengajuan'] = $records;
        $data['array_catatan'] = $this->PengajuanModel->getCatatanReviewerAll();
        $this->load->view('reviewer/ajax_daftar_reviewer', $data);

    }

    public function data_ketua_tim()
    {
        $nama_status = $this->uri->segment(3);

        if($nama_status == ''){
            $kd_status = '(1,2,3,4,5,6,7,8,9,10)';
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
        } else if ($nama_status == 'penugasan'){
            $kd_status = '(3)';
        } else if($nama_status == 'lolos_administratif'){
			$kd_status = '(3,4,6,7,8,9,10)';
		}

        $data['kd_status'] = $kd_status;

        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('ketua_tim/daftar', $data);
        $this->load->view('layout/footer');
    }

    public function ajax_daftar_ketua_tim()
    {
        
        $kd_status = $this->input->post('kd_status');
        
        # buat array status untuk menentukan nama status
        $array = $this->PengajuanModel->getNamaStatus();
        foreach($array as $row){
            $status[$row['kd_status']] = $row['nm_status'];
        }
        $data['status'] = $status;

        $records = $this->DaftarPeriksaModel->ajaxDaftarKetuaTim($kd_status);
        $data['pengajuan'] = $records;
        $data['array_catatan'] = $this->PengajuanModel->getCatatanReviewerAll();
        $this->load->view('ketua_tim/ajax_daftar_ketua_tim', $data);
    }

   /* 
    function cek_output($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }*/

}