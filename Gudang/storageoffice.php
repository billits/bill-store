<?php
  include ('akses.php');
  include ('../_partials/partial_gudang.php');
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
            <li class="breadcrumb-item active">Stok Produk Gudang Office <?php echo $_COOKIE['office_bill']; ?></li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataStok">          
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
        var datastok = "data_stok.php";
        $('#DataStok').load(datastok);     
        
        $(document).on('click','#addstok',function(e){
          e.preventDefault();
          $.ajax({
            url:"../db_proses/add_stok_cabang.php",
            type:"POST",
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                window.location= 'add_stok.php?nota='+obj.nota;
              }else{
                alert(obj.error); 
              }
            }
          })
        });    
      })
    </script>

  </body>
  
</html>

