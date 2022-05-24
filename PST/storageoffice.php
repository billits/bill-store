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
            url:"../db_proses/add_stok_gudang.php",
            type:"POST",
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                //alert(obj.error); 
                window.location= 'add_stok.php?nota='+obj.nota;
              }else{
                alert(obj.error); 
              }
            }
          })
        });

        $(document).on('click','#btn-del',function(e){
          e.preventDefault();
          alert("hai....");
          $('#ModalAddStok').modal('hide');
        });
        
      })
    </script>

  </body>
  
</html>

