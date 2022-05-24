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
            <li class="breadcrumb-item active">Retur Transaksi</li>
          </ol>

          <!-- DataTables Example -->
          <!-- <div id="DataNTJK">          
          </div> -->
          <div class="card mb-3">
            <div class="card-body">
              <form method="post" id="form-approv" >
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="tgl">Nota NTJ*</label>
					            <input type="text" name="notantj" id="notantj" class="form-control" autocomplete="off" required >
					          </div>	
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit" name="submit">Retur</button>
                    </div>
                  </form>
            </div>
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

        $('#form-approv').submit(function(e){
          e.preventDefault();
          var dataform = $("#form-approv").serialize();
          $.ajax({
            url:"../db_proses/add_ret_trans.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                // alert(obj.error); 
                var nota_temp = obj.nota_id;
                var ntj = document.getElementById("notantj").value;   
                window.location= 'det_retur.php?nota='+nota_temp+'&ntj='+ntj;
              }else{
                alert(obj.error); 
              }
            }
          })
        })
        
      })
    </script>

  </body>
  
</html>

