<?php
if (!isset($this->session->userdata['logged_in'])) {
	redirect('autentikasi/logout');
} else {
	$id_user = $this->session->userdata['logged_in']['kajietik_id_user'];
	$role = $this->session->userdata['logged_in']['kajietik_role'];
	
	if($role == 'mahasiswa')
	{
		//$option = '<option value="1" selected>mahasiswa</option>';
		$selected_mahasiswa = 'selected';
		$selected_dosen = '';
		$selected_staf = '';
	} else if($role == 'dosen'){
		$selected_mahasiswa = '';
		$selected_dosen = 'selected';
		$selected_staf = '';
	} else {
		$selected_mahasiswa = '';
		$selected_dosen = '';
		$selected_staf = 'selected';
	}

	# set nama dan lembaga peneliti
	foreach ($identitas as $row) {
		$nama = $row['nama'];
		$nama_lembaga = $row['nama_lembaga'];
		$unit_lembaga = $row['unit_lembaga'];
	}
	
}
?>
<div class="alert alert-danger print-error-msg" style="display:none"></div>
<div class="box box-info">
	<br>
	
	<form id="frm-pengajuan" class="form-horizontal">
		<fieldset>
		<!--
		<div class="form-group">
			<label class="col-md-4 control-label" for="judul_bhs_ind">Status Pengusul</label>
			<div class="col-md-4">
				
		  	<select id="status_pengusul" name="status_pengusul" class="form-control input-md">
		  		<option value="1" <?=$selected_mahasiswa?> >Mahasiswa</option>
		  		<option value="2"<?=$selected_dosen?> >Dosen</option>
		  		<option value="3"<?=$selected_staf?> >Staf</option>
		  	</select>
				<input name="status_pengusul" id="status_pengusul" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="judul_bhs_ind">Strata Pendidikan Pengusul</label>
			<div class="col-md-4">
				
		  	<select id="strata_pendidikan_pengusul" name="strata_pendidikan_pengusul" class="form-control input-md">
		  		<option value="0">Strata Pendidikan</option>
		  		<option value="1">S1</option>
		  		<option value="2">S2</option>
		  		<option value="3">S3</option>
		  	</select>
				<input name="strata_pendidikan_pengusul" id="strata_pendidikan_pengusul" class="form-control" />
			</div>
		</div>
		
		<hr>-->
		<!--
		<table>
			<tr>
				<th>Status Pengusul</th>
				<th>Strata Pendidikan Pengusul</th>
			</tr>
			<tr>
				<td><input name="status_pengusul" id="status_pengusul" class="form-control"/></td>
				<td><input name="strata_pendidikan_pengusul" id="strata_pendidikan_pengusul"  class="form-control"/></td>
			</tr>
		</table>
		-->
		<!-- Form Name 
		<legend>Form Pengajuan</legend>-->
		<input type="hidden" name="id_user" id="id_user" value="<?=$id_user?>" />
		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="judul_bhs_ind">Judul Penelitian (Indonesia)</label>
		  <div class="col-md-4">                     
		    <textarea class="form-control" id="judul_bhs_ind" name="judul_bhs_ind"></textarea>
		    <span class="error-judul_bhs_ind"></span>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="judul_bhs_eng">Judul Penelitian (inggris)</label>
		  <div class="col-md-4">                     
		    <textarea class="form-control" id="judul_bhs_eng" name="judul_bhs_eng"></textarea>
		    <span class="error-judul_bhs_eng"></span>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="subjek_penelitian">Subjek Penelitian (Indonesia)</label>
		  <div class="col-md-4">                     
		    <textarea class="form-control" id="subjek_penelitian" name="subjek_penelitian"></textarea>
		    <span class="error-subjek_penelitian"></span>
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="subjek_penelitian_eng">Subjek Penelitian (inggris)</label>
		  <div class="col-md-4">                     
		    <textarea class="form-control" id="subjek_penelitian_eng" name="subjek_penelitian_eng"></textarea>
		    <span class="error-subjek_penelitian_eng"></span>
		  </div>
		</div>

		<hr>

		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="peneliti_utama">Peneliti Utama</label>  
			<div class="col-md-4">
				<input id="peneliti_utama" name="peneliti_utama" type="text" placeholder="Nama peneliti utama" class="form-control input-md" value="<?=$nama?>">
				<span class="error-peneliti_utama"></span>
			</div>
			<!--
			<div class="col-md-2">
				<input id="no_telp_peneliti_utama" name="no_telp_peneliti_utama" type="text" placeholder="Nomor Telepon" class="form-control input-md">
			</div>
			<div class="col-md-2">
				<input id="email_peneliti_utama" name="email_peneliti_utama" type="text" placeholder="Email" class="form-control input-md">
			</div>
			-->
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="peneliti_anggota">Anggota</label>  
		  <div class="col-md-4">
		    <textarea class="form-control" id="peneliti_anggota" name="peneliti_anggota"></textarea>
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="peneliti_anggota">Lembaga Pengusul</label>  
		  <div class="col-md-3">
		    <input id="nama_lembaga_pengusul" name="nama_lembaga_pengusul" type="text" placeholder="Nama Lembaga Pengusul" class="form-control input-md" value="<?=$nama_lembaga?>"/>
		    <span class="error-nama_lembaga_pengusul"></span>
		  </div>
		   <div class="col-md-5">
		    <input id="unit_lembaga_pengusul" name="unit_lembaga_pengusul" type="text" placeholder="Unit Lembaga Pengusul" class="form-control input-md" value="<?=$unit_lembaga?>"/>
		    <span class="form-text text-muted"><i>sebutkan program studi bila dari Universitas; atau satuan kerja bila dari Non Universitas</i></span>
		     <span class="error-unit_lembaga_pengusul"></span>
		  </div>		  
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="peneliti_anggota">Sumber Dana</label>  
		  <div class="col-md-3">
		  	<select id="sumber_dana" name="sumber_dana" class="form-control input-md">
		  		<option value="0">Sumber Dana</option>
		  		<option value="Hibah">Hibah</option>
		  		<option value="Non Hibah">Non Hibah</option>
		  		<option value="Pribadi">Dana Pribadi</option>
		  	</select>
		  	 <span class="error-sumber_dana"></span>
		  </div>
		  <div>
		    <!--<input id="sumber_dana" name="sumber_dana" type="text" placeholder="Sumber Dana" class="form-control input-md"/>
		    <span class="form-text text-muted">Hibah; Non Hibah</span>-->
		    <div class="col-md-3">
		    	<input id="total_sumber_dana" name="total_sumber_dana" type="text" placeholder="Total Dana" class="form-control input-md" onkeypress="return isNumberKey(event)"/>
		    	<span class="error-total_sumber_dana"></span>
		    </div>
		  </div>
		</div>

		<hr>

		<!-- Multiple Radios
		<div class="form-group">
		  <label class="col-md-4 control-label" for="multi_senter">Multi Senter</label>
		  <div class="col-md-4">
		  <div class="radio">
		    <label for="multi_senter-0">
		      <input type="radio" name="multi_senter" id="multi_senter-0" value="1">
		      Ya
		    </label>
			</div>
		  <div class="radio">
		    <label for="multi_senter-1">
		      <input type="radio" name="multi_senter" id="multi_senter-1" value="0" checked="checked">
		      Tidak
		    </label>
			</div>
		  </div>
		</div>
		 -->
		<!-- Text input
		<div class="form-group">
		  <label class="col-md-4 control-label" for="tempat_multi_senter">Tempat Multi Senter</label>  
		  <div class="col-md-4">
		  <input id="tempat_multi_senter" name="tempat_multi_senter" type="text" placeholder="Tempat peneliltian multi senter" class="form-control input-md">
		    
		  </div>
		</div>
		-->
		<!-- Multiple Radios
		<div class="form-group">
		  <label class="col-md-4 control-label" for="persetujuan_etik_lain">Apakah sudah diajukan ke komisi etik yang lain</label>
		  <div class="col-md-4">
		  <div class="radio">
		    <label for="persetujuan_etik_multi_senter-0">
		      <input type="radio" name="persetujuan_etik_lain" id="persetujuan_etik_lain-0">
		      Ya
		    </label>
			</div>
		  <div class="radio">
		    <label for="persetujuan_etik_multi_senter-1">
		      <input type="radio" name="persetujuan_etik_lain" id="persetujuan_etik_lain-1" value="0" value="1" checked="checked">
		      Tidak
		    </label>
			</div>
		  </div>
		</div>
		-->
		<!-- Text input-->
		<div class="form-group">
			<label class="col-md-4 control-label" for="tempat_penelitian">Lokasi Penelitian</label>  
			<div class="col-md-4">
				<input id="tempat_penelitian" name="tempat_penelitian" type="text" placeholder="Tempat penelitian" class="form-control input-md">
				<span class="error-tempat_penelitian"></span>
			</div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <!--<label class="col-md-4 control-label" for="tgl_penelitian">Tanggal Peneliitian</label>-->
			<label class="col-md-4 control-label" for="tgl_penelitian">Estimasi Periode Pengambilan Data</label>
		  <div class="col-md-2">
		  	<input id="tgl_penelitian_awal" name="tgl_penelitian_awal" type="text" class="form-control input-md" autocomplete="off">
		  	<span class="error-tgl_penelitian_awal"></span>
		  </div>
			<div class="col-md-2">
				<input id="tgl_penelitian_akhir" name="tgl_penelitian_akhir" type="text" class="form-control input-md" autocomplete="off">
				<span class="error-tgl_penelitian_akhir"></span>
			</div>
		</div>

		<!-- Button (Double) -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="simpan"></label>
		  <div class="col-md-8 edit-pengajuan-baru">
		    <button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
		  </div>
		</div>	
		</fieldset>
	</form>	
	<div id="message"></div>
	<!--<button id="test" name="test" class="btn btn-xs btn-info test">test</button>-->
	<hr>
</div>

<div class="panel panel-default panel-body" id="box-keterangan" style="padding-top:2px;padding-bottom:1px;display:none">
		<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
			<li>Selanjutnya silahkan melakukan pengisian ringkasan protokol </li>
		</ul>
</div>
<button id="test"></button>

<script src="<?=base_url('assets/js/jquery.formatCurrency.js')?>" type="text/javascript"></script>

<script type="text/javascript">
	
$(document).ready(function()
{
	/*$("#test").click(function(){
		alert("testing");
	});*/

    //Date picker
    $('#tgl_penelitian_awal').datepicker({
      autoclose: true,
		format: 'dd MM yyyy'
    });
    
    $('#tgl_penelitian_akhir').datepicker({
      autoclose: true,
		format: 'dd MM yyyy'
    });

    // simpan data pengajuan
   	$( "form#frm-pengajuan" ).on( "submit", function(e) {
		e.preventDefault();
		var kd_pengajuan = $("#kd_pengajuan").val();
		var dataString = $(this).serializeArray(); //var dataString = $(this).serialize();
		
		dataString.push({name:"kd_pengajuan", value:kd_pengajuan});
		console.log(dataString);
		$("#message").html("");
		$("#message").show();
		$("#message").html("<i class='fa fa-spinner fa-spin'></i>");

	        $.ajax({
	            url: "<?=base_url()?>pengajuan/tambah?>",
	            type:'POST',
	            dataType: "json",
	            data: $.param(dataString),
	            success: function(data) {
	            	$("#message").html(data);
					
	                if($.isEmptyObject(data.validasi_error)){
	                	$(".print-error-msg").css('display','none');
	                	//alert(data.success);
						$("#kd_pengajuan").val(data.validasi_ok.kd_pengajuan);
						$("#nomor").val(data.validasi_ok.kd_pengajuan);
						$("#box-keterangan").css("display", "block");
						$("#message").html(data.validasi_ok.kd_pengajuan);
						//$("#message").hide(1000);
						
						$("#message").html("data sudah disimpan");
						$("#message").hide(700);
						$(".edit-pengajuan-baru").html('<button id="edit-pengajuan-baru" name="edit_pengajuan_baru" class="btn btn-success">Edit</button>');

	                } else {
						//$(".print-error-msg").css('display','block');
	                	//$(".print-error-msg").html(data.error);
	                	$(".error-judul_bhs_ind").html(data.validasi_error.judul_bhs_ind);
	                	$(".error-judul_bhs_eng").html(data.validasi_error.judul_bhs_eng);
	                	$(".error-subjek_penelitian").html(data.validasi_error.subjek_penelitian);
	                	$(".error-subjek_penelitian_eng").html(data.validasi_error.subjek_penelitian_eng);
	                	$(".error-peneliti_utama").html(data.validasi_error.peneliti_utama);
	                	$(".error-tempat_penelitian").html(data.validasi_error.tempat_penelitian);
	                	$(".error-tgl_penelitian_awal").html(data.validasi_error.tgl_penelitian_awal);
	                	$(".error-tgl_penelitian_akhir").html(data.validasi_error.tgl_penelitian_akhir);
	                	$(".error-nama_lembaga_pengusul").html(data.validasi_error.nama_lembaga_pengusul);
	                	$(".error-unit_lembaga_pengusul").html(data.validasi_error.unit_lembaga_pengusul);
	                	$(".error-sumber_dana").html(data.validasi_error.sumber_dana);
	                	$(".error-total_sumber_dana").html(data.validasi_error.total_sumber_dana);
	                	//$("#message").show();
	                	//$("#message").html("data tidak diproses <pre>"+data.validasi_error.judul_bhs_ind+"</pre>");
	                	//$("#message").hide(1000);
						
	                }
					
					console.log(data);
	            }, cache: false
	        });
	}); 
	

	$("#total_sumber_dana").keyup(function()
	{
		$("#total_sumber_dana").formatCurrency();
	});

	//Fungsi Javascript Numeric Only
	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;		
		return true;
	}	
});
</script>