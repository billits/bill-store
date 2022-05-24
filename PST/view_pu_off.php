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
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active"> Print Ulang Konsinyasi Office Cabang</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataTrans">
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
        var kantor = getUrlVars()["kantor"];
        var datatrans = "data_pu_off.php?tgl_start="+tgl_start+"&tgl_end="+tgl_end+"&kantor="+kantor;
        $('#DataTrans').load(datatrans); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_det_pu_off.php?id="+datatmp;
          $('#DataTrans').load(datalap); 
        });

        $(document).on('click','#detail1',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_det_pu_off_po.php?id="+datatmp;
          $('#DataTrans').load(datalap); 
        });

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          var datatrans = "data_pu_off.php?tgl_start="+tgl_start+"&tgl_end="+tgl_end+"&kantor="+kantor;
          $('#DataTrans').load(datatrans); 
        });
        
        $(document).on('click','#back',function(e){
          e.preventDefault();
          window.location= 'pu_off.php';
        });

        $(document).on('click','#cetak',function(e){
          e.preventDefault();          
          var nota_tmp = $(this).attr('data-id');
                window.open(
                  '../Print Nota BTB.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
        });

        $(document).on('click','#cetak1',function(e){
          e.preventDefault();          
          var nota_tmp = $(this).attr('data-id');
                window.open(
                  '../Print Nota NPO Cabang.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
        });

      })
    </script>

  </body>
  
</html>

