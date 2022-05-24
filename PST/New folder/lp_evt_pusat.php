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
            <li class="breadcrumb-item active"> Laporan PO Event Pusat Kantor <?php echo $_COOKIE['nama_office']; ?></li>
          </ol>

          <div id="DataBTB">
          </div>

          <!-- DataTables Example -->
          <!-- <div class="card mb-3">
            <div class="card-body">
              <form method="post" id="form-approv" action="view_evt_pst.php">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="tgl">Mulai Tanggal*</label>
					            <input type="text" name="tgl_start" id="tgl_start" class="form-control" placeholder="Mulai Tanggal" autocomplete="off" required>
					          </div>	
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="tgl">Sampai Tanggal*</label>
					            <input type="text" name="tgl_end" id="tgl_end" class="form-control" placeholder="Sampai Tanggal" autocomplete="off" required>
					          </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="pdk">Kode Produk*</label>
                      <input class="form-control" type="text" name="pdk" id="pdk" required value="ALL" autocomplete="off"/> 
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nota">Kode Nota*</label>
                     <input class="form-control" type="text" name="nota_start" id="nota_start" required value="ALL" autocomplete="off"/> 
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="evnt">Event*</label>
                      <select class="form-control" name="evnt" id="evnt">
    <?php
      include "../db_proses/koneksi.php";
      $query1 = "SELECT * FROM events WHERE id_events='BIG' OR id_events='BST' OR id_events='BMW' OR id_events='RTS' OR id_events='BCP' OR id_events='ELT'";

      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                      <option value="<?php echo $baris1['id_events']; ?>"><?php echo $baris1['nama_events']." (".$baris1['id_events'].")"; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="stat">Status*</label>
                      <select class="form-control" name="stat" id="stat">
                        <option value="APPROVE">APPROVE</option>
                        <option value="SUCCESS">SUCCESS</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="model">Model*</label>
                      <select class="form-control" name="model" id="model">
                        <option value="REKAP">Rekap</option>
                        <option value="DETAIL">Detail</option>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit" name="submit">Lihat</button>
                    </div>
                  </form>
            </div>
          </div> -->

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
        var databtb = "data_rekapbtb.php";
        $('#DataBTB').load(databtb); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datalap = "data_repbtb1.php?id="+datatmp;
          $('#DataBTB').load(datalap); 
        });
        
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
        $('#DataBTB').load(databtb); 
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NTJK.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

