<?php
//var_dump($this->session->userdata());
# sebelum masuk ke dalam sistem cek registrasi dulu
//echo $this->session->userdata['role_id'];
//$num_row = count($data);

?>
<!--<button type="button" id="input-data" class="btn btn-info btn-sm" data-toggle="modalx" data-target="#pengajuanModalx">
	<b style="font-size:14px">Input Data Pengajuan Baru</b>
</button>-->
<br><br>
<div class="box box-info" style="overflow:auto">
	<input type="hidden" id="kd_pengajuan_public" value="">
	<input type="hidden" id="status_public" value="">
	<div id="data-pengajuan"></div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
		<ul class="col-xs-12 col-md-12 pull-left text-info" style="font-size:12px;">
			<i><b><u>Panduan:</u></b></i>	
			<!--<li>Silahkan melakukan pengisian data pengajuan melalui tombol <font class="label label-info">Input Data Pengajuan</font></li>-->
			<li>Perubahan data pengajuan protokol dapat dilakukan melalui icon <i class="fa fa-file-o" style="color:#fa0"></i></li>
			<li>Perubahan data ringkasan protokol dapat dilakukan melalui icon <i class="fa fa-cog" style="color:#00c0ef"></i></li>
			<li>Perubahan data jawaban pertanyaan etika dapat dilakukan melalui icon <i class="fa fa-cogs text-primary"></i> yang terdapat pada kolom form pertanyaan etika</li>
			<li>Perubahan data dokumen dapat dilakukan melalui icon <i class="fa fa-folder-o text-primary"></i></li>
			<!--
			<li>Bila Peneliti adalah Mahasiswa, menyertakan surat pernyataan Pembimbing atau Promotor bahwa ybs mengetahui dan mengizinkan Protokol diajukan untuk uji etika.</li>
			-->
			<li>Selanjutnya adalah melakukan pengajuan melalui tombol <font class="label label-primary">ajukan</font> (status akan berubah menjadi "Menunggu Konfirmasi Sekretariat") </li>
			<!--
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
			-->
			<li>Pengajuan yang sudah dinyatakan lolos uji, pernyataan hasil uji etika dapat dilihat melalui icon <i class="fa fa-file-pdf-o" style="color:red"></i> </li>
			<!--
			<li>Pengajuan yang dinyatakan Belum Lolos Uji Etika dengan Perbaikan atau Tidak Lolos Uji Etik, Berita Acara Uji Etika dapat dilihat melalui icon <i class="fa fa-file-pdf-o" style="color:red"></i> pada kolom Berita Acara Uji Etik</li>
			-->
		</ul>
	</div>
</div>
<!-- modal form pengajuan -->
<div class="modal fade" id="pengajuanModal" tabindex="-1" role="dialog" aria-labelledby="pengajuanModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="pengajuanModalLabel">Pengajuan Etika Penelitian</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="form-input-pengajuan">
					<?php
					//include(APPPATH. 'views/form/pengajuan.php');
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal form protokol -->
<div class="modal fade" id="protokolModal" tabindex="-1" role="dialog" aria-labelledby="protokolModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="protokolModalLabel">Protokol Etika Penelitian</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<!--<div id="form-input-pengajuan">
					<?php
					//include(APPPATH. 'views/form/protokol.php');
					?>
				</div>-->
			</div>
		</div>
	</div>
</div>

<!-- modal form penilaian -->
<div class="modal fade" id="penilaianModal" tabindex="-1" role="dialog" aria-labelledby="penilaianModalModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="penilaianModalLabel">Penilaian Etika Penelitian</h4>
			</div>
			<div class="modal-body">
				<div id="form-data-penilaian">
					<?php
					//$url = base_url().'penilaian/form';
					//include($url);
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal form input -->
<div class="modal fade" id="formInputModal" tabindex="-1" role="dialog" aria-labelledby="formInputModalModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="formInputModalLabel">Form</h4>
			</div>
			<div class="modal-body">
				<div id="form-input"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close">Tutup</button>
			</div>
		</div>
	</div>
</div>

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

<!-- modal dokumen penunjang -->
<div class="modal fade" id="viewDokumenPenunjangModal" tabindex="-1" role="dialog" aria-labelledby="viewDokumenPenunjangModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="viewDokumenPenunjangModalLabel">Dokumen</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="dokumen-penunjang-view"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal" aria-label="Close" id="close-dokumen-penunjang-modal">Tutup</button>
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
			                            <input type="text" name="nomor" id="nomor">
			                            <input type="text" name="nama_dok" id="nama_dok">
										<input type="text" name="view_name" id="view_name">
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
				<div id="cek-isian-form"></div>
				<br>
				<div>
					<button type="button" class="btn btn-primary btn-sm" id="ajukan-ok">OK</button>
					<button type="button" class="btn btn-danger btn-sm" id="ajukan-cancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal alert delete -->
<div class="modal fade" id="alertDeleteModal" tabindex="-1" role="dialog" aria-labelledby="alertDeleteModalLabel">
	<div class="modal-dialog modal-xs" role="document">
		<div class="modal-content">
			<div class="modal-body" style="overflow:auto; text-align:center">
				<input type="hidden" id="alert-delete-kd_pengajuan" value="">
				<table>
					<tr>
						<td rowspan="3"><i class="fa fa-exclamation-triangle" style="font-size:45px; color:#f56954"></i></td>
					</tr>
					<tr>
						<td id="data-alert-delete-modal" style="padding-left:20px;"></td>
					</tr>
				</table>
				<br>
				<div>
					<button type="button" class="btn btn-primary btn-sm" id="delete-ok">OK</button>
					<button type="button" class="btn btn-danger btn-sm" id="delete-cancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modal hasil asesmen -->
<div class="modal fade" id="hasilAsesmenModal" tabindex="-1" role="dialog" aria-labelledby="hasilAsesmenModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="hasilAsesmenModalLabel">Hasil Asesmen dan Catatan</h4>
			</div>
			<div class="modal-body" style="overflow:auto">
				<div id="hasil-asesmen-modal"></div>
			</div>			
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" data-dismiss="modal" id="close-hasil-asesmen-modal">Tutup</button>
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
	getData();

	function getData()
	{
		var kd_status = "<?=$kd_status?>";
		$.ajax({
			url: "<?=base_url()?>pengajuan/ajax_daftar_peneliti",
			type: "POST",
			data: {kd_status:kd_status},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#data-pengajuan").html(data)
			}         
		});
	};
	
	$(document).on("click", "#input-data", function()
	{
		// kosongkan modal body
		$("#form-input").html("");
		$("#formInputModalLabel").html("Form Pengajuan");
		// buka modal
		$("#formInputModal").modal("show");
		
		// tampilkan form
		$.ajax({
			url: "<?=base_url()?>pengajuan/form",
			type: "POST",
			success: function(data)   // A function to be called if request succeeds
			{
				$("#form-input").html(data)
			}         
		});
	});
	
	$(document).on("click", ".form-pengajuan", function()
	{
		// kosongkan modal body
		$("#form-input").html("");
		$("#formInputModalLabel").html("Form Pengajuan");
		// buka modal
		$("#formInputModal").modal("show");
		
		// ambil data form
		var kd_pengajuan = $(this).data("id");
		
		$.ajax({
			url: "<?=base_url()?>pengajuan/lihat_data",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#form-input").html(data)
			}         
		});
	});

	$(document).on("click", ".form-protokol", function()
	{
		// kosongkan modal body
		$("#form-input").html("");
		$("#formInputModalLabel").html("Form Protokol");
		// buka modal
		$("#formInputModal").modal("show");
		
		// ambil data form
		var kd_pengajuan = $(this).data("id");
		
		$.ajax({
			url: "<?=base_url()?>protokol/lihat_data",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#form-input").html(data)
			}         
		});
	});
	
	
	$(document).on("click", ".form-penilaian", function()
	{
		// kosongkan modal body
		$("#form-input").html("");
		$("#formInputModalLabel").html("Form Pertanyaan Etik");
		// buka modal
		$("#formInputModal").modal("show");
		
		// ambil data form
		var kd_pengajuan = $(this).data("id");
		
		$.ajax({
			url: "<?=base_url()?>penilaian/form",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#form-input").html(data)
			}         
		});
	});

	$(document).on("click", ".form-dokumen", function()
	{
		//$("#allModalLabel").html("Dokumen");
		$("#viewDokumenPenunjangModal").modal("show");

		var kd_pengajuan = $(this).data("id");
		var status = $(this).data("status");
		
		$("#kd_pengajuan_public").val(kd_pengajuan);
		$("#status_public").val(status);

		$.ajax({
			url: "<?=base_url()?>dokumen/dokumen_list",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, status:status},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#dokumen-penunjang-view").html(data)
			}         
		});
	});

	$(document).on('hidden.bs.modal', '#viewDokumenPenunjangModal', function () {
		getDataDokumen();
	});

	/* old
	$(document).on("click", ".ajukan", function()
	{
		// set kode pengajuan
		var kd_pengajuan = $(this).attr("id");
		
		// kosongkan modal body
		$("#all-modal").html("");
		
		// buka modal
		$("#allModal").modal("show");
		
		$.ajax({
			url: "<?=base_url()?>pengajuan/cek_data",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#all-modal").html(data);
			}         
		});
	});
	*/
	
	// mengajukan protokol
	$(document).on("click", ".ajukan", function()
	{
		var kd_pengajuan = $(this).attr("id");
		$("#alert-kd_pengajuan").val(kd_pengajuan);
		$("#data-alert-modal").html("Apakah anda yakin akan mengajukan permohonan uji etika penelitian?<br>Mohon periksa kembali form pengajuan, protokol dan penilaian");
		$("#cek-isian-form").html("");
		$.ajax({
			url: "<?=base_url()?>test_script/CekIsianForm/pertanyaanEtik",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#cek-isian-form").html(data);
				if(data===''){
					$("#ajukan-ok").prop("disabled", false);
				} else {
					$("#ajukan-ok").prop("disabled", true);
				}
				console.log(data);
			}         
		});

		$("#alertModal").modal("show");
	});
	
	$("#ajukan-ok").click(function(){
		// set kode pengajuan
		var kd_pengajuan = $("#alert-kd_pengajuan").val();
		
		$.ajax({
			url: "<?=base_url()?>pengajuan/status",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, status:1},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#alertModal").modal("hide");
				//getData();
				$("#status_"+kd_pengajuan).html(data);
				$("#aksi_"+kd_pengajuan).html("");
				console.log(data);
			}         
		});
	});
	
	$("#ajukan-cancel").click(function()
	{
		$("#alertModal").modal("hide");
	});

	// membatalkan pengajuan protokol
	$(document).on("click", ".delete", function()
	{
		var kd_pengajuan = $(this).attr("id");
		$("#alert-delete-kd_pengajuan").val(kd_pengajuan);
		$("#data-alert-delete-modal").html("Apakah anda yakin akan membatalkan permohonan uji etika penelitian?");
		$("#alertDeleteModal").modal("show");
	});
	
	$("#delete-ok").click(function(){
		// set kode pengajuan
		var kd_pengajuan = $("#alert-delete-kd_pengajuan").val();
		
		$.ajax({
			url: "<?=base_url()?>pengajuan/delete",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#alertDeleteModal").modal("hide");
				getData();
			}         
		});
	});
	
	$("#delete-cancel").click(function()
	{
		$("#alertDeleteModal").modal("hide");
	});
	
	$(document).on('hidden.bs.modal', '#formInputModal, #allModal', function () {
		getData();
	});

	function getDataDokumen()
	{		
		var kd_pengajuan = $("#kd_pengajuan_public").val();
		var status = $("#status_public").val();
		
		$.ajax({
			url: "<?=site_url('dokumen/dokumen_list')?>",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, status:status},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#dokumen-penunjang-view").html(data)
			}         
		});
	};

	$("#close-upload-modal").click(function()
	{
		$("#uploadDokumenModal").modal("hide");
		getDataDokumen();
	});

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
		const form = document.querySelector('form#form-upload-dokumen');
		form.reset();

		$("#status").html('');
		$("#loaded_n_total").html('');

		$("#nomor").val($(this).data("id"));
		$("#nama_dok").val($(this).data("file_name"));
		$("#view_name").val($(this).data("view_name"));
		$("#uploadDokumenModal").modal("show");
		//$("input[name=file_upload]").val(null);
	});

	//view file dokumen
	$(document).on("click", ".view-dok", function(){
		$("#viewDokumenModal").modal("show")
		$(".modal-body #dokumen-view").html('')

		var kd_pengajuan = $(this).data("id");
		var ext_file = $(this).data("ext");
		var nama_dok = $(this).data("file_name");

		$.ajax({
			url: "<?=site_url('dokumen/view_dokumen')?>",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan, ext_file:ext_file, nama_dok:nama_dok},
			success: function(data)   // A function to be called if request succeeds
			{
				$(".modal-body #dokumen-view").html(data)
			},
	        cache: false
	        //contentType: false,
	        //processData: false      
		});
	})
	/*
	$(document).on("click", ".berita_acara_lolos_uji", function(){
		var kd_pengajuan = $(this).data("id");
		//alert(kd_pengajuan)

		//post_to_url('/backend/word/G001.php', {
		post_to_url('/backend/dokumen/berita_acara/berita_acara_lolos_uji.php', {
		    kd_pengajuan:kd_pengajuan
		}, 'post');
		//clock.start();
	})
	*/

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

	$(document).on("click", ".view_hasil_asesmen", function()
	{
		// set kode pengajuan
		var kd_pengajuan = $(this).data("id");
		$("#kd_pengajuan_public").val(kd_pengajuan);
		// kosongkan modal body
		$("#hasil-asesmen-modal-modal").html("");
		$("#hasilAsesmenModalLabel").html("Hasil Asesmen dan Catatan");	
		// buka modal
		$("#hasilAsesmenModal").modal("show");

		$.ajax({
			url: "<?=site_url('penilaian/hasil_asesmen_peneliti')?>",
			type: "POST",
			data: {kd_pengajuan:kd_pengajuan},
			success: function(data)   // A function to be called if request succeeds
			{
				$("#hasil-asesmen-modal").html(data);
			}         
		});

	});
});
</script>

<style type="text/css">
.form-daftar, .form-dokumen {
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

<?php
include(APPPATH. 'views/penanda_perbaikan_css.php');
?>