<?php
if (!isset($this->session->userdata['logged_in'])) {
	redirect('autentikasi/logout');
} else {
	$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
}

# hasil asesmen reviewer

?>

<input type="hidden" id="cek-berkas" value="<?=$kd_pengajuan?>">


<div class="panel panel-default">
	<div class="panel-heading text-center"><b class="text-info">Histori Catatan Perbaikan</b></div>
	<div class="panel-body">

		<!-- versi 2 -->
		<div class="row">
			<div class="col-md-12">
				<?php

				$html='
					<table class="table" style="width:100%; margin:auto">
						<tr style="color:#777">
							<th width="35%">Reviewer</th>
							<th>Catatan</th>
						</tr>';
					$i = 1;
					$array_i = array(1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X');
					foreach($array_catatan_reviewer as $row){
						
						$html.= '
						<tr>
							<td>Reviewer '.$array_i[$i].'</td>
							<td>
								<table>';
									if(!is_null($row['catatan']) and !empty($row['catatan']) and $row['catatan']!='')
									{
										$html.='<tr>
											<td><i><u>Perbaikan Pertama ('.dbToTanggal($row['tgl_catatan']).'):</u></i></td>
										</tr>
										<tr>							
											<td style="text-align: justify; border-bottom: 1px solid #aaa">'.str_replace(PHP_EOL, "<br>", $row['catatan']).'</td>
										</tr>';	
									}

									if(!is_null($row['catatan_2']) and !empty($row['catatan_2']) and $row['catatan_2']!='')
									{ 
										$html.='		
										<tr><td style="line-height:8px">&nbsp;</td></tr>											
										<tr>
											<td><i><u>Perbaikan Kedua ('.dbToTanggal($row['tgl_catatan_2']).'):</u></i></td>
										</tr>
										<tr>
											<td style="text-align: justify; border-bottom: 1px solid #aaa">'. str_replace(PHP_EOL, "<br>", $row['catatan_2']).'</td>
										</tr>';		
									}

									if(!is_null($row['catatan_3']) and !empty($row['catatan_3']) and $row['catatan_3']!='')
									{ 
										$html.='	
										<tr><td style="line-height:8px">&nbsp;</td></tr>				
										<tr>
											<td><i><u>Perbaikan Ketiga ('.dbToTanggal($row['tgl_catatan_3']).'):</u></i></td>
										</tr>
										<tr>
											<td style="text-align: justify; border-bottom: 1px solid #aaa">'.str_replace(PHP_EOL, "<br>", $row['catatan_3']).'</td>
										</tr>';
									}

								$html.='</table>				
							</td>
						</tr>';
						$i++;
					}
					$html.= '
					</table>';
					echo $html;
				?>
			</div>
		</div>

		<!-- versi 1
		<div class="row">

			<div class="col-md-12">
				<?php

					$catatan_reviewer = '';
					$catatan_sidang = '';


				# catatan reviewer
				if ($flag_sidang == 1) {
					# jika sudah melalui sidang komisi
				$html = '
				<table class="table">
					<tr>
						<td style="text-align:center; background-color:#eee">Reviewer</td>
						<td style="text-align:center; background-color:#eee">Sidang Komisi</td>
					</tr>';

					foreach($array_catatan as $k => $v){
						if ($v['catatan']==''){
							$catatan_reviewer .= $v['catatan'];
						} else {
							$catatan_reviewer .= '<li>'.$v['catatan'].'</li>';
						}
					}

					foreach($array_catatan as $k => $v){
						if ($v['catatan_sidang']==''){
							$catatan_sidang .= $v['catatan_sidang'];
						} else {
							$catatan_sidang .= '<li>'.$v['catatan_sidang'].'<li>';
						}
					}

					$html.= '
					<tr>
						<td><ul>'.$catatan_reviewer.'</ul></td>
						<td>'.$catatan_sidang.'</td>
					</tr>';

					/*foreach($array_catatan as $k => $v){
						
						$html.= '
							<tr>
								<td style="border:1px solid #eee">'.$v['catatan'].'</td>
								<td style="border:1px solid #eee">'.$v['catatan_sidang'].'</td>
							</tr>';
						$html.= '
						<tr>
							<td>&nbsp;</td>
						</tr>';
					}*/
					$html.= '</table>';
					echo $html;
				} else {
					# jika belum melalui sidang komisi

					echo '<div style="word-wrap: break-word; white-space: pre-line; text-align:justify">';
					foreach ($array_catatan as $k => $v) {
						# code...
						print_r($v['catatan']);
					}
					echo '</div>';

					# header nama reviewer
					/*$html.= '
					<tr>
						<td colspan="1" style="font-weight:bold; font-style:italic; ">&nbsp;</td>
					</tr>';

					foreach($array_catatan as $k => $v){
						
						if ($v['catatan']==''){
							$catatan_reviewer .= $v['catatan'];
						} else {
							$catatan_reviewer .= '<li>'.$v['catatan'].'</li>';
						}
							$html.= '
								<tr>
									<td style="border:1px solid #ddd">'.$catatan_reviewer.'</td>
								</tr>';
							$html.= '
							<tr>
								<td style="border:1px solid #ddd">&nbsp;</td>
							</tr>';
						}
					}*/


				//$data['array_catatan'] = $array_catatan;
				}
				?>
			</div>
		</div>
		 -->

	</div>
</div>


<script type="text/javascript">
$(document).ready(function()
{

	$(document).on("click", ".penilaian-reviewer", function()
	{
		var id_user = $(this).data("id_user");
		var kd_pengajuan = $("#kd_pengajuan_public").val();

		$("#hasil-asesmen-"+id_user).html("test");

		$.ajax({
			url: "<?=site_url('penilaian/lembar_penilaian_peneliti_per_reviewer')?>",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, id_user:id_user},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#hasil-asesmen-"+id_user).html(data);
			},
			cache:false
		});


	});
});
</script>