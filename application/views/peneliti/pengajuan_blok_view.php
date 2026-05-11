
      <div class="error-page">
        <h2 class="headline text-yellow"> <i class="fa fa-hand-paper-o"></i> </h2>

        <div class="error-content">
          <?php
          $array_proses = array (
            0 => 'akan diajukan',
            1 => 'menunggu konfirmasi sekretariat',
            2 => 'perbaikan',
            3 => 'sedang diuji',
            4 => 'perbaikan',
            6 => 'menunggu sidang komisi',
            7 => 'perbaikan',
            10 => 'penugasan reviewer'
          );   
          $keterangan = $judul_bhs_ind.' sedang dalam proses '.$array_proses[$status];
          ?>
          <h2>
            <i class="text-yellow"></i> Oops! permohonan dengan judul penelitian: <?php echo $keterangan?>
          </h2>
          <p>
              Sesaat lagi Anda akan diarahkan ke halaman daftar pengajuan
          </p>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->

        <div class="box-body">
          <div id="progress">
            <div id="bar"></div>
          </div>          
        </div>
        <!-- /.box-body -->


<p class="text" id="loading"></p>

<script type="text/javascript">
const progressBar = document.getElementById("bar");
const loadingMsg = document.getElementById("loading");
let barWidth = 0;

const animate = () => {
  barWidth++;
  progressBar.style.width = `${barWidth}%`;
  setTimeout(() => {
    loadingMsg.innerHTML = `${barWidth}% Completed`;
  }, 10100);
};

// animation starts 2 seconds after page load
setTimeout(() => {
  let intervalID = setInterval(() => {
    if (barWidth === 100) {
      clearInterval(intervalID);
      location.href = "../daftar/pengaju";
    } else {
      animate();
      
    }
  }, 50); //this sets the speed of the animation
}, 2000);
</script>

<style type="text/css">
.text {
  text-align: center;
}

#progress {
  margin: 20px auto;
  width: 80%;
  height: 40px;
  position: relative;
  background-color: #ddd;
}

#bar {
  background-color: #39CCCC;
  width: 10px;
  height: 40px;
  position: absolute;
}

#loading {
  font-size: 1.4rem;
}
</style>