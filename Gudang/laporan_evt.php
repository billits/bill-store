<?php
  include ('akses.php');
  include ('../_partials/partial_gudang.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
    <script>
      function myFunction() {        
        var qty=parseInt($('#qty').val());
        var price=parseInt($('#price').val());
        var tot_fix = qty*price;  

        var reverse = tot_fix.toString().split('').reverse().join(''),
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = 'Rp. '+ribuan.join('.').split('').reverse().join('');
        document.getElementById("total").value = ribuan;   
      }
    </script>
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
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active"> Laporan Gudang Event Kantor <?php echo $_COOKIE['office_bill']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataPO">
          </div>

        </div>
        <!-- /.container-fluid -->

        <?php
          echo $footer;
        ?>
        
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php
      echo $logout;
    ?>

    <?php
      echo $csjs2;
    ?>

    <script type="text/javascript">
    function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
        });
        return vars;
      }

      $(document).ready(function(){
        
        var tgl_start = getUrlVars()["tgl_start"];
        var tgl_end = getUrlVars()["tgl_end"];

        var datapo = "data_rekap_evt.php?tgl_start="+tgl_start+"&tgl_end="+tgl_end;
        $('#DataPO').load(datapo); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_detre_evt.php?id="+datatmp;
          $('#DataPO').load(datalap); 
        });
        
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataPO').load(datapo); 
        });
        
        $(document).on('click','#back',function(e){
          e.preventDefault();          
          window.location= 'pu_tevt.php'; 
        });

      })
    </script>

  </body>
  
</html>

