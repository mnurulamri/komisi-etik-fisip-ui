<?php
//var_dump($this->session->userdata());
# sebelum masuk ke dalam sistem cek registrasi dulu
//echo $this->session->userdata['role_id'];
//$num_row = count($data);

?>
<!-- 
	tab pengajuan meliputi tiga form
	form pengajuan, ringkasan protokol, dan persyaratan dokumen
-->

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#form-1" id="tab-pengajuan-protokol">Pengajuan Protokol</a></li>
  <li><a data-toggle="tab" href="#form-2" id="tab-ringkasan-protokol">Ringkasan Protokol</a></li>
  <li><a data-toggle="tab" href="#form-4" id="tab-pertanyaan-etik">Pertanyaan Etika</a></li>
  <li><a data-toggle="tab" href="#form-3" id="tab-dokumen">Dokumen</a></li>
</ul>

<br><br>
<div class="panel panel-default">
	<div class="panel-body">
	<input type="hidden" name="kd_pengajuan" id="kd_pengajuan" value="">
		<div class="tab-content">
		  <div id="form-1" class="tab-pane fade in active">
		    <h3>Pengajuan Protokol</h3>
		    <p><div id="form-pengajuan-protokol"></div></p>
		  </div>
		  <div id="form-2" class="tab-pane fade">
		    <h3>Ringkasan Protokol</h3>
		    <p><div id="form-ringkasan-protokol"></div></p>
		  </div>
		  <div id="form-4" class="tab-pane fade">
		    <h3>Pertanyaan Etika</h3>
		    <div class="box box-info">
				<p><div id="form-pertanyaan-etik"></div></p>		    	
		    </div>

		  </div>
		  <div id="form-3" class="tab-pane fade">
		    <h3>Dokumen Penunjang</h3>
		    <p>
				<div id="notifikasi-dokumen" style="display:none"></div>
				
					<div id="form-dokumen" style="display:none">
						<fieldset>
						
						<!-- Form Name 
						<legend>Dokumen Penunjang</legend>-->
						<div id="data-penunjang">
							<!--
							<table class="table table-bordered" id="box-dokumen" style="displayx:nonex">
								<tr style="background:#aaa;">
									<th>Nama Dokumen</th>
									<th>File</th>
									<th></th>
								</tr>
								<tr>
									<td>1. Surat Pengantar</td>
									<td></td>
									<td>
										<button id="upload" data-file_name="surat_pengantar" data-view_name="1. Surat Pengantar" class="btn btn-xs btn-info upload">upload</button>
									</td>
								</tr>
								<tr>
									<td>2. Surat Persetujuan Promotor</td>
									<td></td>
									<td><button id="" data-file_name="surat_promotor" data-view_name="2. Surat Persetujuan Promotor" class="btn btn-xs btn-info upload">upload</button></td>
								</tr>
								<tr>
									<td>3. Proposal</td>
									<td></td>
									<td><button id="" data-file_name="proposal" data-view_name="3. Proposal" class="btn btn-xs btn-info upload">upload</button></td>
								</tr>
								<tr>
									<td>4. Pemaparan (Dokumen Presentasi)</td>
									<td></td>
									<td><button id="" data-file_name="pemaparan" data-view_name="4. Pemaparan" class="btn btn-xs btn-info upload">upload</button></td>
								</tr>
								<tr>
									<td>5. Instrumen Penelitian (panduan wawancara, FGD, kuesioner)</td>
									<td></td>
									<td><button id="" data-file_name="instrumen" data-view_name="5. Instrumen Penelitian (panduan wawancara, FGD, kuesioner)" class="btn btn-xs btn-info upload">upload</button></td>
								</tr>
								
							</table>
						-->
						</div>
				
						<!-- File Button
						<div class="form-group">
						  <label class="col-md-4 control-label" for="surat_pengantar">Surat Pengantar</label>
						  <div class="col-md-4">
						    <input id="surat_pengantar" name="surat_pengantar" class="input-file" type="file">
						  </div>
						</div>
					
						<div class="form-group">
						  <label class="col-md-4 control-label" for="surat_pengantar">Instrumen/Kuesioner, dll</label>
						  <div class="col-md-4">
						    <input id="instrumen" name="instrumen" class="input-file" type="file">
						  </div>
						</div> --> 
					
						<!-- Button (Double)
						<div class="form-group">
						  <label class="col-md-4 control-label" for="button1id">Double Button</label>
						  <div class="col-md-8">
						    <button id="button1id" name="button1id" class="btn btn-success">Good Button</button>
						    <button id="button2id" name="button2id" class="btn btn-danger">Scary Button</button>
						  </div>
						</div> -->
					
						</fieldset>
					</div>
				
			</p>
			<!--
			<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
				<i><b><u>Panduan:</u></b></i>
				<li>Ekstensi file yang dizinkan jpg, bmp, gif, png dan pdf </li>
			</ul>
			-->
		  </div>
		</div>
	</div>
</div>
<!--
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
			<i><b><u>Panduan:</u></b></i>	
			<li>Silahkan melakukan pengisian data pengajuan melalui tombol <font class="label label-info">Input Data Pengajuan</font></li>
			<li>Perubahan data pengajuan dapat dilakukan melalui icon <i class="fa fa-file-o" style="color:#fa0"></i></li>
			<li>Silahkan melakukan pengisian protokol penelitian melalui tombol <i class="fa fa-cog" style="color:#00c0ef"></i> yang terdapat pada kolom form protokol</li>
			<li>Silahkan melakukan pengisian pertanyaan etika penelitian melalui tombol <i class="fa fa-cogs text-primary"></i> yang terdapat pada kolom form pertanyaan etik</li>
			<li>Bila Peneliti adalah Mahasiswa, menyertakan surat pernyataan Pembimbing atau Promotor bahwa ybs mengetahui dan mengizinkan Protokol diajukan untuk uji etika.</li>
			<li>Selanjutnya adalah melakukan pengajuan melalui tombol <font class="label label-primary">ajukan</font> (status akan berubah menjadi "Menunggu Konfirmasi Sekretariat") </li>
			<li>Status pengajuan terdiri dari:
				<ul>
					<li>Belum Diajukan</li>
					<li>Menunggu Konfirmasi Sekretariat</li>
					<li>Perlu Perbaikan -> setelah dilakukan pemeriksaan oleh Sekretariat kelengkapan berkas dinyatakan belum lengkap atau setelah dilakukan penilaian memerlukan perbaikan oleh reviewer</li>
					<li>Menunggu Penilaian Reviewer -> bila kelengkapan berkas sudah dinyatakan lengkap oleh sekretariat</li>
					<li>Tidak Lolos -> setelah dinyatakan tidak lolos oleh reviewer atau sidang komisi</li>
					<li>Menunggu Sidang Komisi -> bila terdapat perbedaan penilaian diantara reviewer</li>
					<li>Lolos -> setelah dinyatakan lolos oleh reviewer atau sidang komisi</li>
				</ul>
			</li>
			<li>Bila status pengajuan adalah "Menunggu Sidang Komisi" maka silahkan melihat jadwal Sidang Komisi Etik pada menu "Jadwal Sidang Komisi" </li>
			<li>Pengajuan yang sudah dinyatakan lolos uji, Surat Keterangan Lolos dapat dilihat melalui icon <i class="fa fa-file-pdf-o" style="color:red"></i> </li>
			<li>Pengajuan yang dinyatakan Belum Lolos Uji Etik dengan Perbaikan atau Tidak Lolos Uji Etik, Berita Acara Uji Etika dapat dilihat melalui icon <i class="fa fa-file-pdf-o" style="color:red"></i> pada kolom Berita Acara Uji Etik</li>
		</ul>
	</div>
</div>
-->

<!-- modal all -->
<div class="modal fade" id="allModal" tabindex="-1" role="dialog" aria-labelledby="allModalModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="allModalLabel">Form</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="all-modal"></div>
			</div>
		</div>
	</div>
</div>

<!-- modal dokumen -->
<div class="modal fade" id="viewDokumenModal" tabindex="-1" role="dialog" aria-labelledby="viewDokumenModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="viewDokumenModalLabel">Dokumen</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="dokumen-view"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- modal upload dokumen -->
<div class="modal fade" id="uploadDokumenModal" tabindex="-1" role="dialog" aria-labelledby="uploadDokumenModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="uploadDokumenModalLabel">Dokumen</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				
				<div id="box-upload" >
					<div id="dok-upload">
			                <div class="form-container">
			                        <form id="form-upload-dokumen" enctype="multipart/form-data" method="post">
			                            <input type="hidden" name="nomor" id="nomor">
			                            <input type="hidden" name="nama_dok" id="nama_dok">
										<input type="hidden" name="view_name" id="view_name">
			                            <input type="file" name="file_upload" id="file_upload" onchange="uploadFile()" style="margin:0px auto; display:block;"/>
			                            <br>
			                            <progress class="progress" id="progressBar" value="0" max="100" style="width:300px;"></progress>
			                            <h3 id="status"></h3>
			                            <p id="loaded_n_total"></p>
			                            <p id="result"></p>
			                        </form>         
			                </div>
			
			
			                <script>
			                function _(el) {
			                    return document.getElementById(el);
			                }
			
			                function uploadFile() {
			                    //e.preventDefault()
			                    var r = confirm("Anda akan mengunggah dokumen ini!");
			                    if (r == true) {
			                        var file = _("file_upload").files[0];
			                        var nomor = _("nomor").value;
			                        var nama_dok = _("nama_dok").value;
									var view_name = _("view_name").value;
			                        //alert(file.name+" | "+file.size+" | "+file.type);
			                        var formdata = new FormData();
			                        formdata.append("nomor", nomor);
			                        formdata.append("file_upload", file);
			                        formdata.append("nama_dok", nama_dok);
									formdata.append("view_name", view_name);
			                        var ajax = new XMLHttpRequest();
			                        ajax.upload.addEventListener("progress", progressHandler, false);
			                        ajax.addEventListener("load", completeHandler, false);
			                        ajax.addEventListener("error", errorHandler, false);
			                        ajax.addEventListener("abort", abortHandler, false);
			                        ajax.open("POST", "<?=site_url('upload')?>"); // http://www.developphp.com/video/JavaScript/File-Upload-Progress-Bar-Meter-Tutorial-Ajax-PHP
			
			                        //use file_upload_parser.php from above url
			                        ajax.send(formdata);              
			                    }
			
			                }
			
			                function progressHandler(event) {
			                    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
			                    var percent = (event.loaded / event.total) * 100;
			                    _("progressBar").value = Math.round(percent);
			                    _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
			                }
			
			                function completeHandler(event) {
			                    _("status").innerHTML = event.target.responseText;
			                    _("progressBar").value = 0; //wil clear progress bar after successful upload;
			                    /*_("box-upload").style.display = "none"; //will hide box-upload */
			                }
			
			                function errorHandler(event) {
			                    _("status").innerHTML = "Upload Failed";
			                }
			
			                function abortHandler(event) {
			                _("status").innerHTML = "Upload Aborted";
			                }
			
			                </script>   
			                             
			            </div>
				</div>
				<!-- end of box upload -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" id="close-upload-modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<!-- modal alert -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel">
	<div class="modal-dialog modal-xs" role="document">
		<div class="modal-content">
			<div class="modal-body" style="overflow:auto; text-align:center">
				<input type="hidden" id="alert-kd_pengajuan" value="">
				<table>
					<tr>
						<td rowspan="3"><i class="fa fa-exclamation-triangle" style="font-size:45px; color:#f56954"></i></td>
					</tr>
					<tr>
						<td id="data-alert-modal" style="padding-left:20px;"></td>
					</tr>
				</table>
				<br>
				<div>
					<button type="button" class="btn btn-primary btn-sm" id="ajukan-ok">OK</button>
					<button type="button" class="btn btn-danger btn-sm" id="ajukan-cancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal alert -->
<div class="modal fade" id="alertBatalModal" tabindex="-1" role="dialog" aria-labelledby="alertBatalModalLabel">
	<div class="modal-dialog modal-xs" role="document">
		<div class="modal-content">
			<div class="modal-body" style="overflow:auto; text-align:center">
				<input type="hidden" id="alert-kd_pengajuan" value="">
				<table>
					<tr>
						<td rowspan="3"><i class="fa fa-exclamation-triangle" style="font-size:45px; color:#f56954"></i></td>
					</tr>
					<tr>
						<td id="data-alert-batal-modal" style="padding-left:20px;"></td>
					</tr>
				</table>
				<br>
				<div>
					<button type="button" class="btn btn-primary btn-sm" id="batal-ok">OK</button>
					<button type="button" class="btn btn-danger btn-sm" id="batal-cancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal validation
<div class="modal fade" id="alertValidationModal" tabindex="-1" role="dialog" aria-labelledby="alertValidationModalLabel">
	<div class="modal-dialog modal-xs" role="document">
		<div class="modal-content">
			<div class="modal-body" style="overflow:auto; text-align:center">
				
				<table>
					<tr>
						<td rowspan="3"><i class="fa fa-exclamation-triangle" style="font-size:45px; color:#f56954"></i></td>
					</tr>
					<tr>
						<td id="data-alert-validation-modal" style="padding-left:20px;"></td>
					</tr>
				</table>
				<br>
				<div>
					<button type="button" class="btn btn-primary btn-sm" id="validation-ok">OK</button>
				</div>
			</div>
		</div>
	</div>
</div> -->
<? //=include(APPPATH.'views/form/upload.php');?> 

<script>
$(document).ready(function()
{
	getFormPengajuanProtokol();

	function getFormPengajuanProtokol()
	{
		$("#kd_pengajuan").val("");
		$.ajax({
			url: "<?=base_url()?>pengajuan/form_pengajuan_protokol",
			type: "POST",
			success: function(data)   // A function to be called if request succeeds
			{
				$("#form-pengajuan-protokol").html(data)
			}         
		});
	}

	$(document).on("click", "#tab-ringkasan-protokol", function()
	{
		// ambil data form
		
		if ($("#kd_pengajuan").val() == ''){
			$("#form-ringkasan-protokol").html("Mohon untuk terlebih dahulu melengkapi dan menyimpan isian form pengajuan protokol");
		} else {
			var kd_pengajuan = $("#kd_pengajuan").val();
			$.ajax({
				url: "<?=base_url()?>protokol/lihat_data",
				type: "POST",
				data: {kd_pengajuan:kd_pengajuan},
				success: function(data)   // A function to be called if request succeeds
				{
					$("#form-ringkasan-protokol").html(data)
				}         
			});
		}

	});

	$(document).on("click", "#tab-dokumen", function()
	{
		// ambil data form
		
		if ($("#kd_pengajuan").val() == ''){
			
			$("#notifikasi-dokumen").css("display", "block").html("Mohon untuk terlebih dahulu melengkapi dan menyimpan isian form pengajuan protokol");
		} else {					
			$("#form-dokumen").css("display", "block");
			$("#notifikasi-dokumen").css("display", "none");
		
			var kd_pengajuan = $("#kd_pengajuan").val();
			$.ajax({
				
				url: "<?=base_url()?>dokumen/dokumen_list",
				type: "POST",
				data: {kd_pengajuan:kd_pengajuan},
				success: function(data)   // A function to be called if request succeeds
				{
					$("#data-penunjang").html(data)
				}         
			});
		}

	});
	
	$(document).on("click", "#tab-pertanyaan-etik", function()
	{
		if ($("#kd_pengajuan").val() == ''){
			$("#form-pertanyaan-etik").html("Mohon untuk terlebih dahulu melengkapi dan menyimpan isian form pengajuan protokol");
		} else {
			var kd_pengajuan = $("#kd_pengajuan").val();
			$.ajax({
				url: "<?=base_url()?>penilaian/form",
				type: "POST",
				data: {kd_pengajuan:kd_pengajuan},
				success: function(data)   // A function to be called if request succeeds
				{
					$("#form-pertanyaan-etik").html(data)
				}         
			});
		}
	});

	function getDataDokumen()
	{		
		var kd_pengajuan = $("#kd_pengajuan").val();
		var status = $("#status").val();
		
		$.ajax({
			//url: "<?=site_url('dokumen/dokumen_penunjang_temp')?>",
			url: "<?=site_url('dokumen/dokumen_list')?>",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, status:status},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-penunjang").html(data)
			}         
		});
	};
	
	//view file dokumen
	$(document).on("click", ".view-dok", function()
	{
		$("#viewDokumenModal").modal("show")
		$(".modal-body #dokumen-view").html('')

		var kd_pengajuan = $(this).data("id");
		var nama_dok = $(this).data("file_name");
		//var ext_file = $(this).data("ext");
		//var nama_dok = $(this).data("nama_dok");
		alert(kd_pengajuan, nama_dok)
		$.ajax({
			//url: "<?=site_url('pengajuan/view_dokumen')?>",
			url: "<?=site_url('dokumen/view_dokumen')?>",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, nama_dok:nama_dok},
			success: function(data)   // A function to be called if request succeeds
			{
				$(".modal-body #dokumen-view").html(data)
			}         
		});
	})
	//--------------------------------------//

	// upload dokumen
	$("form#form-upload-dokumen").submit(function(e)
	{
	    e.preventDefault();    
	    var formData = new FormData(this);

	    $.ajax({
	        url: "<?=site_url('upload')?>",
	        type: 'POST',
	        data: formData,
	        success: function (data) {
	            alert(data)
	        },
	        cache: false,
	        contentType: false,
	        processData: false
	    });
	});

	$(document).on('click', '.upload', function()
	{
		var kd_pengajuan = $(this).data("id");
		//$("#nomor").val($("#kd_pengajuan").val());
		$("#nomor").val(kd_pengajuan);
		$("#nama_dok").val($(this).data("file_name"));
		$("#view_name").val($(this).data("view_name"));
		$("#uploadDokumenModal").modal("show");
	});

	//$(document).on('click', '#close-upload-modal', function(){
	$("#close-upload-modal").click(function()
	{
		$("#uploadDokumenModal").modal("hide");
		getDataDokumen();
	});

	$(document).on('click', '.view-file', function()
	{
		var kd_pengajuan = $(this).data("id");
		var nama_file = $(this).data("file_name");
		var parameter = kd_pengajuan+'_'+nama_file+'.pdf';
		window.open("/backend/dokumen/berita_acara_pdf/"+parameter);
	});

	function post_to_url(path, params, method) {
	    method = method || "post";

	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", path);

	    for(var key in params) {
	        if(params.hasOwnProperty(key)) {
	            var hiddenField = document.createElement("input");
	            hiddenField.setAttribute("type", "hidden");
	            hiddenField.setAttribute("name", key);
	            hiddenField.setAttribute("value", params[key]);

	            form.appendChild(hiddenField);
	         }
	    }

	    document.body.appendChild(form);
	    form.submit();
	}
	/* menghapus semua data dari model dan meresetnya.
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});*/
});
</script>

<style type="text/css">
.form-daftar{
	text-align:center;
	cursor: pointer;
}

/* fix problem multiple modal scrollbar */
.modal { overflow: auto !important; }
.berita_acara_uji_etik {
	color:red;
	cursor:pointer;
}
.berita_acara_lolos_uji {
	color:red;
	cursor:pointer;
}
</style>