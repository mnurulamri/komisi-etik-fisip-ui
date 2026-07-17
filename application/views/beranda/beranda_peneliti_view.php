<?php
//cek_output($array_status);
$role_id = $this->session->userdata('role_id');
$role_name = $this->session->userdata['role_name'];
$status = 0;
$kd_pengajuan = '';
$judul_bhs_ind = '';

# set kode dan judul penelitian
if (isset($result) and count($result)>0) {
  # code...
  foreach ($result as $row){
    $kd_pengajuan = $row['kd_pengajuan'];
    $judul_bhs_ind = $row['judul_bhs_ind'];
    $status = $row['status'];
    $catatan_perbaikan_sekre = $row['catatan_perbaikan_sekre'];
    $flag_perbaikan = $row['flag_perbaikan'];
    $start_date_sidang = $row['start_date_sidang'];
    $end_date_sidang = $row['end_date_sidang'];
    $lokasi_sidang = $row['lokasi_sidang'];
    $info_status = $array_status[$row['status']];
  }

	//if($flag_perbaikan==1){
    if($status==2 or $status==4 or $status==7){
	    /* dinonaktifkan dulu sementara
      $notifikasi_perbaikan = '
      <br>
      <div class="panel panel-default">
        <div class="panel-heading text-center"><b class="text-info">Perhatian</b></div>
        <!--<div class="panel panel-body" style="background-color: #fff; text-align:left; color:#D81B60; font-weight: bold; font-style:italic;"> </div>-->
        <div class="panel-body">
          Yth. Ibu/Bapak pengaju permohonan etika,
      
          Kami telah menerima permintaan perpanjangan masa revisi anda. Revisi maksimal dituntaskan dalam 5 (lima) hari kerja. Pengajuan akan otomatis gugur jika melampaui tenggat waktu, dan anda akan perlu mengajukan permohonan baru.
      
          Semoga lancar.
      
          Salam,
          KEP
        </div>
      </div>';
      */
      $notifikasi_perbaikan = '';
	} else {
		$notifikasi_perbaikan = '';
	}
} else {
  # code...
  redirect(base_url('pengajuan/baru'));
}

if($status=='' or empty($status)){ $status = 0;}
# set array status
$array_status = [
  0 => 'Pengajuan Permohonan Uji Etika Penelitian oleh Pengaju/Peneliti',
  1 => 'Pemeriksaan Administratif oleh Sekretariat',
  10 => 'Penugasan Reviewer',
  3 => 'Pengulasan/Review oleh Komisi Etika Penelitian',
  9 => 'Pemberian Klirens pada Pengaju/Peneliti',
  11 => 'Tidak Dilanjutkan'
];

# set variabel progress bar
if ($status == 0 and ( $kd_pengajuan=='' or empty($kd_pengajuan) ) ) {

  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Pemberian Klirens pada Pengaju/Peneliti');
  $init_status = '';
} else if ($status == 1) {
  # perlu perbaikan dari sekretariat
  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Pemberian Klirens pada Pengaju/Peneliti');
  $init_status = 'Pemeriksaan Administratif oleh Sekretariat';
} else if ($status == 2) {
  # perlu perbaikan dari sekretariat
  $variabel_init = array(
    'Pengajuan Perbaikan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat <br><i>- Perlu Perbaikan -</i>',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Pemberian Klirens pada Pengaju/Peneliti');
  $init_status = 'Pengajuan Perbaikan Uji Etika Penelitian oleh Pengaju/Peneliti';
} else if ($status == 4 or $status == 7) {
  # perlu perbaikan dari sekretariat -> pengaju haru smengajukan ulang
  $variabel_init = array(
    'Pengajuan Perbaikan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian <br><i>- Perlu Perbaikan -</i>',
    'Pemberian Klirens pada Pengaju/Peneliti');
  $init_status = 'Pengajuan Perbaikan Uji Etika Penelitian oleh Pengaju/Peneliti';
} else if ($status == 5 or $status == 8) {
  # perlu perbaikan dari reviewer
  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian <br><i>- Tidak Lolos -</i>',
    'Pemberian Klirens pada Pengaju/Peneliti');
    $init_status = 'Pengulasan/Review oleh Komisi Etika Penelitian (Tidak Lolos)';
} else if ($status == 6) {
  # perlu disidangkan / butuh pemaparan
  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Butuh Pemaparan dalam Sidang Komisi',
    'Pemberian Klirens pada Pengaju/Peneliti');
     $init_status = 'Butuh Pemaparan dalam Sidang Komisi';
} else if ($status == 9) {
  # Lolos
  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Pemberian Klirens pada Pengaju/Peneliti');
     $init_status = 'Pemberian Klirens pada Pengaju/Peneliti';
} else if ($status == 10) {
  # penugasan reviewer
  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Pemberian Klirens pada Pengaju/Peneliti');
     $init_status = 'Penugasan Reviewer';
} else {
  $variabel_init = array(
    'Pengajuan Uji Etika Penelitian oleh Pengaju/Peneliti',
    'Pemeriksaan Administratif oleh Sekretariat',
    'Penugasan Reviewer',
    'Pengulasan/Review oleh Komisi Etika Penelitian',
    'Pemberian Klirens pada Pengaju/Peneliti');

  $init_status = $array_status[$status];
}

if($kd_pengajuan=='' or empty($kd_pengajuan)) {$kd_pengajuan = ' - ';}
if($judul_bhs_ind=='' or empty($judul_bhs_ind)) {$judul_bhs_ind = ' - ';}
?>

<div class="panel panel-default">
  <div class="panel-heading text-center"><b class="text-info">Pengajuan Protokol</b></div>
  <div class="panel-body">
    <div style="background:#fff; padding: 5px">
      <div class="colx-lg-12 colx-md-12 colx-sm-12">
        <table>
          <tr>
            <td style="background-color: #fff; border:1px solid #fff; padding:5px; font-weight:bold; color:gray; vertical-align:top">Nomor Protokol</td>
            <td style="border:1px solid #fff; padding:5px;">: <?=$kd_pengajuan?></td>
          </tr>
          <tr>
            <td style="background-color: #fff; border:1px solid #fff; padding:5px;font-weight:bold; color:gray">Judul Penelitian</td>
            <td style="border:1px solid #fff; padding:5px;">: <?=$judul_bhs_ind;?></td>
          </tr>
          <tr>
            <td style="background-color: #fff; border:1px solid #fff; padding:5px;font-weight:bold; color:gray; vertical-align:top">Status</td>
            <td style="border:1px solid #fff; padding:5px;">: 
              <?php if($status==2 or $status==4 or $status==7){ ?>
                <b><div class="animate-charcter"><?=$info_status?></div></b>
              <div style="padding-left:5px"><i class="text-info">silahkan menuju menu "Daftar Pengajuan" untuk melakukan perbaikan pada form isian yang sudah disediakan, selanjutnya klik tombol <font class="label label-primary">ajukan Perbaikan</font></i></div>
              <?php } else { 
                  echo '<b>'.$info_status.'</b>';
              }?>
              <!-- testing
              <div class="waviy">
                <span style="--i:1">P</span>
                <span style="--i:2">e</span>
                <span style="--i:3">r</span>
                <span style="--i:4">l</span>
                <span style="--i:5">u</span>
                <span style="--i:6"></span>
                <span style="--i:7">p</span>
                <span style="--i:8">e</span>   
                <span style="--i:9">r</span>
                <span style="--i:10">b</span>
                <span style="--i:11">a</span>
                <span style="--i:12">i</span>
                <span style="--i:13">k</span>
                <span style="--i:14">a</span>
                <span style="--i:15">n</span>
              </div> -->
            </td>
          </tr>
        </table>
      </div>
    </div>      
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading text-center"><b class="text-info">Dimana Anda Sekarang?</b></div>
  <div class="panel-body">
    <!-- progress bar
    <link href="<?=site_url('assets/css/progress_bar.css')?>" rel="stylesheet" /> -->
    <div style="background-color: #fff; text-align:left; color:#D81B60; font-weight: bold; font-style:italic;">
      &nbsp;
    </div>
    <div class="progress-bar-wrapper" style="background-color: #fff;"></div>
    <script src="<?=site_url('assets/js/progress-bar.js')?>"></script>
  </div>
</div>

<!-- panel untuk monitoring evaluasi penelitian -->
<?php
// tampilkan panel monitoring evaluasi penelitian jika status penelitian sudah dinyatakan lolos (status = 9)

if ($status == 9) {
?>
 <div class="panel panel-default">
  <div class="panel-heading text-center"><b class="animate-charcter">Monitoring Evaluasi Penelitian</b></div>
  <div class="panel-body">
    <div style="background-color: #fff; text-align:left; color:#444; font-weight: normal;">
      <p style="margin:0; line-height:1.5;">
        <!--Pantau perkembangan penelitian Anda melalui form monitoring evaluasi untuk memastikan Anda telah melaksanakan rekomendasi reviewer. Silahkan klik tombol <a class="btn btn-success btn-xs" href="<?=site_url('monitoring_evaluasi/buat_sesi')?>">Monitoring Evaluasi</a> untuk mengisi form monitoring evaluasi penelitian.-->
        
        <form method="post" action="<?= site_url('monitoring_evaluasi/buat_sesi') ?>">
            <input type="text" value="<?= $kd_pengajuan ?>" name="penelitian_id" class="form-control" readonly style="display:none">
            <input type="text" name="periode" class="form-control"
                       placeholder="Contoh: Bulan 1, Kuartal 2, Semester I 2025"
                       value="" style="display:none">

            <input type="text" name="tanggal_monitoring" class="form-control datepicker"
              placeholder="yyyy-mm-dd" id="tanggal_monitoring"
              value="<?= date('Y-m-d') ?>" style="display:none">
              <textarea name="catatan_peneliti" class="form-control" rows="3"
              placeholder="Tuliskan catatan awal atau konteks monitoring ini..." style="display:none"
            ></textarea> 

            <b class="text-warning">Pantau perkembangan penelitian Anda melalui form monitoring evaluasi untuk memastikan Anda telah melaksanakan rekomendasi reviewer. Silahkan klik tombol
              <button type="submit" class="btn btn-success btn-xs">
                <i class="fa fa-arrow-right"></i> Isi Form Monitoring Evaluasi
              </button> untuk mengisi form monitoring evaluasi penelitian.    </b>        
          </form>
      </p>
    </div>
  </div>
</div>
<?php
 } else {
   # code...
 }
?>
<script>
//we can set animation delay as following in ms (default 1000)
ProgressBar.singleStepAnimation = 1500;
ProgressBar.init(
  [ <?php echo '"'.implode('","', $variabel_init).'"' ?> ], "<?=$init_status?>", 'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
);
/*
ProgressBar.init(
  [ 'Belum Diajukan',
    'Menunggu Konfirmasi Sekretariat',
    'Penugasan Reviewer',
    'Sedang Diuji',
    'Perlu Perbaikan',
    'Perlu Disidangkan',
    'Lolos'
  ],
  "<?=$init_status?>",
  'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
);
*/
</script>


<!--<div class="box box-body">-->
  <?php

	echo $notifikasi_perbaikan;

  if ($status == 6) {
    # jika status adalah menunggu sidang komisi maka tampilkan jadwal
    echo '
    <div style="background-color: #fff; text-align:left; color:#D81B60; font-weight: bold; font-style:italic;">
  		Tanggal Sidang Komisi:
	</div>';
    echo tanggalSidang($start_date_sidang, $end_date_sidang);

  } else if ($status == 2) {
    # tampilkan asesmen kelengkapan berkas
    /*echo '<script>
    setTimeout(function(){'.
    //alert("test")
	asesmenKelengkapanBerkas($kd_pengajuan)
    .'}, 2000)

    </script>';*/
    echo asesmenKelengkapanBerkas($kd_pengajuan);
    if ($catatan_perbaikan_sekre == '' or empty($catatan_perbaikan_sekre)) {
      # code...
      echo '
      <div class="panel panel-body" style="background-color: #fff; text-align:left; color:#D81B60; font-weight: bold; font-style:italic;">Catatan:</div>
      ';
    } else {
      # code...
      echo '
      <div class="panel panel-body" style="background-color: #fff; text-align:left; color:#D81B60; font-weight: bold; font-style:italic;">Catatan:</div>
      <div>'.$catatan_perbaikan_sekre.'</div>';
    }
  } else if ($status == 3 or $status == 4 or $status == 7 or $status == 9) {
    # tampilkan catatan dan ulasan dari revewer
    ?>
    <div id="data"></div>
    <script type="text/javascript">
    var kd_pengajuan = "<?=$kd_pengajuan?>";
    $.ajax({
      url: "<?=site_url('penilaian/hasil_asesmen_peneliti')?>",
      type: "POST",
      data: {kd_pengajuan:kd_pengajuan},
      success: function(data)   // A function to be called if request succeeds
      {
        $("#data").html(data);
      }
    });
    </script>

  <?php } else {
    # code...
  }


  //cek_output($result);
  ?>
</div>

<style type="text/css">
.progress-bar-wrapper {padding-bottom: 105px;}
ul.progress-bar {
    width: 100%;
    margin: 0;
    padding: 0;
    font-size: 0;
    list-style: none;
    background-color: #fff;
}

li.section {
    display: inline-block;
    padding-top: 45px;
    font-size: 13px;
    font-weight: bold;
    line-height: 16px;
    color: gray;
    vertical-align: top;
    position: relative;
    text-align: center;
    overflow: hidden;
    text-overflow: ellipsis;
}

li.section:before {
    content: 'x';
    position: absolute;
    top: 2px;
    left: calc(50% - 15px);
    z-index: 1;
    width: 30px;
    height: 30px;
    color: white;
    border: 2px solid white;
    border-radius: 17px;
    line-height: 30px;
    background: gray;
}
.status-bar {
    height: 2px;
    background: gray;
    position: relative;
    top: 20px;
    margin: 0 auto;
}
.current-status {
    height: 2px;
    width: 0;
    border-radius: 1px;
    background: #fa0;/*background: mediumseagreen;*/
}

@keyframes changeBackground {
    from {background: gray}
    to {background: mediumseagreen}
}

li.section.visited:before {
    content: '\2714';
    animation: changeBackground .5s linear;
    animation-fill-mode: forwards;
}

li.section.visited.current:before {
    box-shadow: 0 0 0 2px mediumseagreen;
}
</style>
<!-- ./ progress bar -->
<div style="background-color:#fff">&nbsp;</div>

<!--
	<div class="box box-body text-info">
		<div class="col-lg-6 col-xs-6">
	        <ul>
	        	<li>
					box status menggambarkan tahapan dari proses pengajuan yang sedang berjalan
				</li>
	        	<li>
					Jumlah yang tertera pada box status adalah jumlah data pengajuan yang sedang berproses atau ditindaklanjuti
				</li>
				<li>
					Untuk pengajuan etik penelitian yang baru, silahkan menuju menu "Daftar Pengajuan"
				</li>
	        </ul>
		</div>
	</div>
-->

<style>

/* Animation */

#scroll-container {
  /*border: 3px solid black;
  border-radius: 5px;*/
  overflow: hidden;
	white-space: nowrap;
	/*display: inline-block;*/
}

#scroll-text {
  /* animation properties */
  -moz-transform: translateX(100%);
  -webkit-transform: translateX(100%);
  transform: translateX(100%);


  -moz-animation: my-animation 10s linear infinite;
  -webkit-animation: my-animation 10s linear infinite;
  animation: my-animation 10s linear infinite;
animation-delay: -2s;
}

/* for Firefox */
@-moz-keyframes my-animation {
  from { -moz-transform: translateX(100%); }
  to { -moz-transform: translateX(-100%); }
}

/* for Chrome */
@-webkit-keyframes my-animation {
  from { -webkit-transform: translateX(100%); }
  to { -webkit-transform: translateX(-100%); }
}

@keyframes my-animation {
  from {
    -moz-transform: translateX(100%);
    -webkit-transform: translateX(100%);
    transform: translateX(100%);
  }
  to {
    -moz-transform: translateX(-100%);
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
  }

/*
.anim-typewriter{
  animation: typewriter 4s steps(44) 1s 1 normal both,
 blinkTextCursor 500ms steps(44) infinite normal;
 animation-iteration-count: infinite;
}
@keyframes typewriter{
  from{width: 0;}
  to{width: 24em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.75);}
  to{border-right-color: transparent;}
}*/
}

.waviy {
  position: relative;
}
.waviy span {
  position: relative;
  display: inline-block;
  font-size: 12px;
  color: red;
  text-transform: uppercase;
  animation: flip 4.5s infinite;
  animation-delay: calc(.2s * var(--i))
}
@keyframes flip {
  0%,80% {
    transform: rotateY(360deg) 
  }
}

.animate-charcter
{
   /*text-transform: uppercase;*/
  background-image: linear-gradient(
    -225deg,
    #231557 0%,
    #44107a 29%,
    #ff1361 67%,
    #fff800 100%
  );
  background-size: auto auto;
  background-clip: border-box;
  background-size: 200% auto;
  color: #fff;
  background-clip: text;
  text-fill-color: transparent;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  animation: textclip 2s linear infinite;
  display: inline-block;
      /*font-size: 12px;*/
}

@keyframes textclip {
  to {
    background-position: 200% center;
  }
}
</style>
