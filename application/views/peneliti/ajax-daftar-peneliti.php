<?php
$role_id = $this->session->userdata('role_id');
?>

<table class="table table-stripped">
	<thead>
		<tr>
			<th rowspan="2">No. Protokol</th>
			<th rowspan="2">Judul</th>		
			<th rowspan="2">Tanggal Penelitian</th>			
			<th colspan="3" style="text-align:center">Form</th>
			<th rowspan="2">Dokumen</th>
			<th rowspan="2">Aksi</th>
			<th rowspan="2">Status</th>
			<!--<th colspan="2" class="text-success text-center">Keterangan</th>
			<th rowspan="2" class="text-info text-center">Berita Acara Uji Etika</th>
			<th rowspan="2" class="text-info text-center">Berita Acara Sidang</th>-->
			<th rowspan="2" class="text-info text-center">Pernyataan Hasil Uji</th>
		</tr>
		<tr>
			<th>Pengajuan Protokol</th>
			<th>Ringkasan Protokol</th>
			<th>Pertanyaan Etika</th>
			<!--
			<th class="text-success text-center">Hasil Asesmen</th>
			<th class="text-success text-center text-danger">Jadwal Sidang</th>
			-->
		</tr>
	</thead>
	<tbody>

	<?php
	
	$html = '';
	foreach ($pengajuan as $row) 
		{
		# set icon berita acara
		if ($row['status'] > 3 and $row['status'] != 9) {
			$icon = 'fa fa-file-word-o fa-lg';
		} else {
			$icon = '';
		}

		# set icon berita acara lolos uji etik
		if ($row['status'] == 9) {
			$icon_lolos = 'fa fa-file-word-o fa-lg';
		} else {
			$icon_lolos = '';
		}

		# set icon pdf berita acara uji etik
		if ($row['file_berita_acara_uji_etik'] == 'pdf') {
			$icon_pdf_uji_etik = 'view-file fa fa-file-pdf-o fa-lg';
		} else {
			$icon_pdf_uji_etik = '';
		}

		# set icon pdf berita acara sidang
		if ($row['file_berita_acara_uji_sidang'] == 'pdf') {
			$icon_pdf_sidang= 'view-file fa fa-file-pdf-o fa-lg';
		} else {
			$icon_pdf_sidang = '';
		}
		
		# set icon pdf berita acara lolos uji
		if ($row['file_berita_acara_lolos_uji'] == 'pdf') {
			$icon_pdf_lolos_uji= 'view-file fa fa-file-pdf-o fa-lg';
		} else {
			$icon_pdf_lolos_uji = '';
		}
		
		$dokumen = '<i data-id="'.$row['kd_pengajuan'].'" data-status="'.$row['status'].'" class="form-dokumen fa fa-folder-o"></i>';

		$tombol_aksi = tombol_aksi($row['kd_pengajuan'], $row['status'], $role_id, $row['flag_perbaikan']);

		/*$catatan = catatan($row['status'],$row['catatan_perbaikan_sekre'],$row['catatan_perbaikan_reviewer_1'],$row['catatan_tidak_lolos_reviewer_1'],$row['catatan_perbaikan_reviewer_2'],$row['catatan_tidak_lolos_reviewer_2']);*/

		$i=0;
		$catatan_reviewer = '<ul>';
		if (!empty($array_catatan[$row['kd_pengajuan']])){
			
			foreach ($array_catatan[$row['kd_pengajuan']] as $k) {
				$catatan_reviewer .= '<li style="margin-left:-20px" class="text-danger">'.$k.'</li>';
				$i++;
			}
		} 
		$catatan_reviewer .= '</ul>';

		# set catatan berdasarkan status
		$catatan_status = catatan_status($status, $row['status'], $row['catatan_perbaikan_sekre'],$catatan_reviewer,$row['start_date_sidang'],$row['end_date_sidang'],$row['lokasi_sidang']);
	
		# penanda pengajuan perbaikan
		/* versi 2 
		if ($row['flag_perbaikan'] == 1) {
			$penanda = '
			<tr>
				<td colspan="12">
					<div class="box-aktifitas arrow-bottom">
						<i>Pengajuan dengan Perbaikan</i>
					</div> 
				</td>
			</tr>';
		} else {
			$penanda = '';
		}*/

		$arrow = '';
		/* versi 1
		if ($row['flag_perbaikan'] == 1) {
			$arrow = 'arrow';
		} else {
			$arrow = '';
		}
		*/

		/* 	
		if ($row['status'] == 2) 
		{
			$catatan = '<div style="border-top:1px solid #fa0; font-style:italic; font-weight:bold" class="text-danger">Catatan:</div><i class="text-danger">'.$row['catatan_perbaikan_sekre'].'</i>';
		} 
		else if ($row['status'] == 4) 
		{
			$catatan = '<div style="border-top:1px solid #fa0; font-style:italic; font-weight:bold" class="text-danger">Catatan:</div>'.$catatan_reviewer;
		} 
		else if ($row['status'] == 7) 
		{
			$catatan = '<br>underconstruction';
		} 
		else if ($row['status'] == 6) 
		{
			# rubah ke format tanggal
			if ($row['start_date_sidang']=='0000-00-00 00:00:00') {
				$tgl_sidang = '';
				$jam_mulai = '';
				$menit_mulai = '';
				$jam_selesai = '';
				$menit_selesai = '';
			} else {
				$tgl_sidang = dateTimeToTanggal($row['start_date_sidang']);
				$jam_mulai = substr($row['start_date_sidang'], 11, 2).':';
				$menit_mulai = substr($row['start_date_sidang'], 14, 2).' - ';
				$jam_selesai = substr($row['end_date_sidang'], 11, 2).':';
				$menit_selesai = substr($row['end_date_sidang'], 14, 2);
			}
			$lokasi_sidang = $row['lokasi_sidang'];
			$jadwal_sidang = $tgl_sidang.' '.$jam_mulai.$menit_mulai.$jam_selesai.$menit_selesai;
			$catatan = '
			<div style="border-top:1px solid #fa0; font-style:italic; font-weight:bold" class="text-danger">Jadwal Sidang:</div>
			<div style="font-style:italic; font-weight:bold" class="text-danger">'.$jadwal_sidang.'</div>
			<div style="font-style:italic; font-weight:bold" class="text-danger">'.$lokasi_sidang.'</div>';
		} else {
			$catatan = '';
		}
		
		$status_catatan	= $status[$row['status']].$catatan;
		*/
		
		$html.= penanda_perbaikan($row['flag_perbaikan']).'
		<tr class="'.$arrow.'">
			<td class="'.$arrow.'">'.$row['kd_pengajuan'].'</td>
			<td>'.$row['judul_bhs_ind'].'</td>
			<td>'.dbToTanggal($row['tgl_penelitian_awal']).' - '.dbToTanggal($row['tgl_penelitian_akhir']).'</td>
			
			<td class="form-daftar">
				<i data-id="'.$row['kd_pengajuan'].'" class="fa fa-file-o form-pengajuan" style="color:#ff851b"></i>
			</td>
			<td class="form-daftar">
				<i data-id="'.$row['kd_pengajuan'].'" class="fa fa-cog form-protokol" style="color:#00c0ef"></i>
			</td>
			<td class="form-daftar">
				<i data-id="'.$row['kd_pengajuan'].'" class="fa fa-cogs form-penilaian" style="color:#3c8dbc"></i>
			</td>
			<td>'.$dokumen.'</td>
			<td id="aksi_'.$row['kd_pengajuan'].'">'.$tombol_aksi.'</td>
			<td id="status_'.$row['kd_pengajuan'].'">'.$catatan_status.'</td>
			<!--		
			<td id="berita_acara_uji_etik'.$row['kd_pengajuan'].'"><i data-id="'.$row['kd_pengajuan'].'" class="berita_acara_uji_etik '.$icon.'"></i></td>
			<td id="berita_acara_lolos_uji'.$row['kd_pengajuan'].'"><i data-id="'.$row['kd_pengajuan'].'" class="berita_acara_lolos_uji '.$icon_lolos.'"></i></td>
			-->	
			<!--
			<td class="text-center">
				<button data-id="'.$row['kd_pengajuan'].'" class="view_hasil_asesmen btn btn-success btn-xs">view</button>
			</td>
			<td class="text-center">
				<button data-id="'.$row['kd_pengajuan'].'" class="view_jadwal_sidang btn btn-success btn-xs">view</button>
			</td>
			<td></td>
			<td id="berita_acara_uji_etik'.$row['kd_pengajuan'].'" class="text-center">
				<i data-id="'.$row['kd_pengajuan'].'" data-file_name="berita_acara_uji_etik" class="berita_acara_uji_etik '.$icon_pdf_uji_etik.'"></i>
			</td>
			<td id="berita_acara_sidang'.$row['kd_pengajuan'].'" class="text-center">
				<i data-id="'.$row['kd_pengajuan'].'" data-file_name="berita_acara_sidang" class="berita_acara_sidang '.$icon_pdf_sidang.'"></i>
			</td>
			-->
			<td id="berita_acara_lolos_uji'.$row['kd_pengajuan'].'" class="text-center">
				<i data-id="'.$row['kd_pengajuan'].'" data-file_name="berita_acara_lolos_uji" class="berita_acara_lolos_uji '.$icon_pdf_lolos_uji.'"></i>
			</td>
		</tr>';
	} 
	echo $html;
	
	?>
	</tbody>
</table>
