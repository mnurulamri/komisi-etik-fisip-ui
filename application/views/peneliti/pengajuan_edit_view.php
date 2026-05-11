
<?php
//var_dump( $result );
//exit();

if ($sumber_dana=='Hibah'){
	$selected_hibah = "selected";
	$selected_non_hibah = "";
	$dana_pribadi = "";
} else if ($sumber_dana=='Non Hibah'){
	$selected_hibah = "";
	$selected_non_hibah = "selected";
	$dana_pribadi = "";
} else {
	$selected_hibah = "";
	$selected_non_hibah = "";
	$dana_pribadi = "selected";
}
$role_id = $this->session->userdata['logged_in']['kajietik_role_id'];
?>

<div class="box box-info">
<br>
	<form id="edit-pengajuan" class="form-horizontal">
		<fieldset>
			
			<!-- Form Name 
			<legend>Form Pengajuan</legend>-->
			<input id="kd_pengajuan" name="kd_pengajuan" type="hidden"  value="<?=$kd_pengajuan?>" />
			<input id="status" name="status" type="hidden"  value="<?=$status?>" />
			<!-- Textarea -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="judul_bhs_ind">Judul Penelitian (Indonesia)</label>
			  <div class="col-md-4">                     
			    <textarea class="form-control" id="judul_bhs_ind" name="judul_bhs_ind"><?=$judul_bhs_ind?></textarea>
			    <span class="error-judul_bhs_ind"></span>
			  </div>
			</div>

			<!-- Textarea -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="judul_bhs_eng">Judul Penelitian (inggris)</label>
			  <div class="col-md-4">                     
			    <textarea class="form-control" id="judul_bhs_eng" name="judul_bhs_eng"><?=$judul_bhs_eng?></textarea>
			    <span class="error-judul_bhs_eng"></span>
			  </div>
			</div>

			<!-- Textarea -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="subjek_penelitian">Subjek Penelitian (Indonesia)</label>
			  <div class="col-md-4">                     
			    <textarea class="form-control" id="subjek_penelitian" name="subjek_penelitian"><?=$subjek_penelitian?></textarea>
			    <span class="error-subjek_penelitian"></span>
			  </div>
			</div>

			<!-- Textarea -->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="subjek_penelitian_eng">Subjek Penelitian (inggris)</label>
			  <div class="col-md-4">                     
			    <textarea class="form-control" id="subjek_penelitian_eng" name="subjek_penelitian_eng"><?=$subjek_penelitian_eng?></textarea>
			    <span class="error-subjek_penelitian_eng"></span>
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="peneliti_utama">Peneliti Utama</label>  
			  <div class="col-md-4">
			  <input id="peneliti_utama" name="peneliti_utama" type="text" placeholder="Nama peneliti utama" class="form-control input-md" value="<?=$peneliti_utama?>">
			    <span class="error-peneliti_utama"></span>			    
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
			  <label class="col-md-4 control-label" for="peneliti_anggota">Anggota</label>  
			  <div class="col-md-4">
			  <textarea class="form-control" id="peneliti_anggota" name="peneliti_anggota"><?=$peneliti_anggota?></textarea>
			  </div>
			</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="peneliti_anggota">Lembaga Pengusul</label>  
		  <div class="col-md-3">
		    <input id="nama_lembaga_pengusul" name="nama_lembaga_pengusul" type="text" placeholder="Nama Lembaga Pengusul" class="form-control input-md" value="<?=$nama_lembaga_pengusul?>"/>
			    <span class="error-nama_lembaga_pengusul"></span>
		  </div>
		   <div class="col-md-5">
		    <input id="unit_lembaga_pengusul" name="unit_lembaga_pengusul" type="text" placeholder="Unit Lembaga Pengusul" class="form-control input-md" value="<?=$unit_lembaga_pengusul?>"/>
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
		  		<option value="Hibah" <?=$selected_hibah?> >Hibah</option>
		  		<option value="Non Hibah" <?=$selected_non_hibah?> >Non Hibah</option>
					<option value="Dana Pribadi" <?=$dana_pribadi?> >Dana Pribadi</option>
		  	</select>
			 <span class="error-sumber_dana"></span>		  	
		  </div>
		  <div>
		    <!--<input id="sumber_dana" name="sumber_dana" type="text" placeholder="Sumber Dana" class="form-control input-md"/>
		    <span class="form-text text-muted">Hibah; Non Hibah</span>-->
		    <div class="col-md-3">
		    	<input id="total_sumber_dana" name="total_sumber_dana" type="text" placeholder="Total Dana" class="form-control input-md" value="<?=number_format($total_sumber_dana)?>"/>
				<span class="error-total_sumber_dana"></span>
		    </div>
		  </div>
		</div>

			<!-- Multiple Radios 
			<div class="form-group">
			  <label class="col-md-4 control-label" for="multi_senter">Multi Senter</label>
			  <div class="col-md-4">
			  <div class="radio">
			    <label for="multi_senter-0">
			      <input type="radio" name="multi_senter" id="multi_senter-0" value="1" <?=$checked_multi_senter_ya?> >
			      Ya
			    </label>
				</div>
			  <div class="radio">
			    <label for="multi_senter-1">
			      <input type="radio" name="multi_senter" id="multi_senter-1" value="0" <?=$checked_multi_senter_tidak?> >
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
			  <input id="tempat_multi_senter" name="tempat_multi_senter" type="text" placeholder="Tempat peneliltian multi senter" class="form-control input-md" value="<?=$tempat_multi_senter?>">
			    
			  </div>
			</div>
			-->
			<!-- Multiple Radios 
			<div class="form-group">
			  <label class="col-md-4 control-label" for="persetujuan_etik_multi_senter">Apakah sudah diajukan ke komisi etik yang lain</label>
			  <div class="col-md-4">
			  <div class="radio">
			    <label for="persetujuan_etik_multi_senter-0">
			      <input type="radio" name="persetujuan_etik_lain" id="persetujuan_etik_multi_senter-0" value="1" <?=$checked_etik_lain_ya?> >
			      Ya
			    </label>
				</div>
			  <div class="radio">
			    <label for="persetujuan_etik_multi_senter-1">
			      <input type="radio" name="persetujuan_etik_lain" id="persetujuan_multi_senter-1" value="0"  <?=$checked_etik_lain_tidak?> >
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
			  <input id="tempat_penelitian" name="tempat_penelitian" type="text" placeholder="Tempat penelitian" class="form-control input-md" value="<?=$tempat_penelitian?>">
				<span class="error-tempat_penelitian"></span>			    
			  </div>
			</div>

			<!-- Text input-->
			<div class="form-group">
				<!--<label class="col-md-4 control-label" for="tgl_penelitian">Tanggal Peneliitian</label>-->
				<label class="col-md-4 control-label" for="tgl_penelitian">Estimasi Periode Pengambilan Data</label>
				<div class="col-md-2">
					<input id="tgl_penelitian_awal" name="tgl_penelitian_awal" type="text" class="form-control input-md" autocomplete="off" value="<?=$tgl_penelitian_awal?>">
				<span class="error-tgl_penelitian_awal"></span>
				</div>
				<div class="col-md-2">
					<input id="tgl_penelitian_akhir" name="tgl_penelitian_akhir" type="text" class="form-control input-md" autocomplete="off" value="<?=$tgl_penelitian_akhir?>">
				</div>
				<span class="error-tgl_penelitian_akhir"></span>
			</div>

			<!-- Button (Double) -->
			<div class="form-group">
				<?php if ( ($status == 0 or $status == 2 or $status == 4 or $status == 7) and ($role_id == 1 or $role_id == 10) ) {?>
				<label class="col-md-4 control-label" for="simpan"></label>
				<div class="col-md-8">
					<button id="simpan" name="simpan" class="btn btn-success">Simpan</button>
				</div>
				<?php } ?>
			</div>	
		</fieldset>
	</form>	
	<div id="message"></div>
	<!--<button id="test" name="test" class="btn btn-xs btn-info test">test</button>-->
	<hr>
</div>

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
	
	$( "form#edit-pengajuan" ).on( "submit", function(e) {
		e.preventDefault();

	    var dataString = $(this).serialize();
		$("#message").html("<i class='fa fa-spinner fa-spin'></i>");
	    //$("#message").html(dataString)
	    //return false;

		$.ajax({
		type: "POST",
		url: "<?=base_url()?>pengajuan/edit",
		data: dataString,
		dataType: "json",
		success: function (data) {

				if($.isEmptyObject(data.error)){
					//alert("data sudah disimpan")
					$("#message").html("data sudah disimpan");
					setTimeout(function(){    
						$("#message").html("");
				    }, 700);

                } else {
					//$(".print-error-msg").css('display','block');
                	//$(".print-error-msg").html(data.error);
                	$(".error-judul_bhs_ind").html(data.error.judul_bhs_ind);
                	$(".error-judul_bhs_eng").html(data.error.judul_bhs_eng);                	
                	$(".error-subjek_penelitian").html(data.error.subjek_penelitian);
                	$(".error-subjek_penelitian_eng").html(data.error.subjek_penelitian_eng);
                	$(".error-peneliti_utama").html(data.error.peneliti_utama);
                	$(".error-tempat_penelitian").html(data.error.tempat_penelitian);
                	$(".error-tgl_penelitian_awal").html(data.error.tgl_penelitian_awal);
                	$(".error-tgl_penelitian_akhir").html(data.error.tgl_penelitian_akhir);
                	$(".error-nama_lembaga_pengusul").html(data.error.nama_lembaga_pengusul);
                	$(".error-unit_lembaga_pengusul").html(data.error.unit_lembaga_pengusul);
                	$(".error-sumber_dana").html(data.error.sumber_dana);
                	$(".error-total_sumber_dana").html(data.error.total_sumber_dana);
                	$("#message").show();
                	$("#message").hide(700);
                	console.log(data.error)
                }			

			}

		})
	    
	  	//clock.start();
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