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
            <li class="breadcrumb-item active">Retur Konsi Leader</li>
          </ol>

          <!-- DataTables Example -->
          <!-- <div id="DataNTJK">          
          </div> -->
          <div class="card mb-3">
            <div class="card-body">
              <form method="post" id="form-approv" >
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Pilih Nota Konsi Yang Di Retur*</label>
                        <select class="form-control m-bot15" name="konsi" id="konsi">
                          <option value="">Pilih Nota</option>
    <?php
      include "../db_proses/koneksi.php";   
      $kantor=$_COOKIE["office_bill"];
      $query = "SELECT * FROM tb_jual_konsi WHERE retur_jk='0' AND status_jk='SUCCESS' AND total_jk!='0' AND kantor_jk='$kantor'";
      $result = mysqli_query($kon, $query);

      while($baris = mysqli_fetch_assoc($result)){
    ?>
                      <option value="<?php echo $baris['id_jk']; ?>"><?php echo $baris['id_jk']." - ".$baris['cs_jk']; ?></option>
    <?php
        }
    ?>
                      </select>
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
            url:"../db_proses/add_ret_konsi.php",
            type:"POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                // alert(obj.error); 
                var nota_temp = obj.nota;
                var konsi = document.getElementById("konsi").value;   
                window.location= 'det_retur_konsi.php?nota='+nota_temp+'&konsi='+konsi;
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

