<?php
  include ('akses.php');
  include ('../_partials/partial_counter.php');
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
            <li class="breadcrumb-item active"> Laporan Transaksi Office BillStore</li>
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
      $(document).ready(function(){
        var datatrans = "rekap_trans_off.php";
        $('#DataTrans').load(datatrans); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_detail_trans.php?id="+datatmp;
          $('#DataTrans').load(datalap); 
        });

       
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
        $('#DataTrans').load(datatrans); 
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();          
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NTJ.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

