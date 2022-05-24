<?php
  include ('akses.php');
  include ('../_partials/partial_pusat.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $csjs1; ?>
  </head>

  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Overview</li>
          </ol>

  
          <!-- DataTables Example -->
          <div class="card mb-3">
            <div class="card-header">
              <div id="clock"></div>
            </div>              
            <div class="card-body">
              Selamat Datang di Halaman Gudang Pusat
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->
        
        <?php echo $footer; ?>
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php echo $logout; ?>
    <?php echo $csjs2; ?>

    <script type="text/javascript">
      function showTime() {
        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth();
        var thisDay = date.getDay(), thisDay = myDays[thisDay];
        var yy = date.getYear();
        var year = (yy < 1000) ? yy + 1900 : yy;
        var a_p = "";
        var today = new Date();
        var curr_hour = today.getHours();
        var curr_minute = today.getMinutes();
        var curr_second = today.getSeconds();
        if (curr_hour < 12) {
          a_p = "AM";
        } else {
          a_p = "PM";
        }
        if (curr_hour == 0) {
          curr_hour = 12;
        }
        if (curr_hour > 12) {
          curr_hour = curr_hour - 12;
        }
        curr_hour = checkTime(curr_hour);
        curr_minute = checkTime(curr_minute);
        curr_second = checkTime(curr_second);
        document.getElementById('clock').innerHTML=thisDay + ', ' + day + ' ' + months[month] + ' ' + year + ' - ' + curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
      }

      function checkTime(i) {
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }
      setInterval(showTime, 500);

      $(document).ready(function(){
      })
    </script>
  </body>
</html>
