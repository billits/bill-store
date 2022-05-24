<?php
  include ('akses.php');
  include ('../_partials/partial_pic.php');
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
            <li class="breadcrumb-item active"> Laporan BTB Pusat Cabang <?php echo $_COOKIE['office_bill']; ?>  Per Nota</li>
          </ol>

          <!-- DataTables Example -->
    <?php
      include "../db_proses/koneksi.php"; 
      
      $kantor = $_COOKIE['office_bill'];      

      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $tgl_start = $_POST['tgl_start'];
      $tgl_end = $_POST['tgl_end'];
      $nota_start = $_POST['nota_start'];
      $nota_end = $_POST['nota_end'];
      $model = $_POST['model'];

      $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
      $tgl_temp=date('Y-m-d', strtotime($tgl_end));
      $tgl_selesai = $tgl_temp." 23:59:59";

      if ($nota_start=='ALL'||$nota_end=='ALL'){
        $nota="ALL";
      }else{
        $nota="NONE";
      }

      $jml_pdk=0;
      $tot_jum=0;
      $totju=0;

    ?>
          
          <div class="card mb-3">    
            <div class="card-header">
              Laporan BTB Pusat Cabang <?php echo $_COOKIE['office_bill']; ?> <br>
              Periode <?php echo $tgl_start.' s/d '.$tgl_end; ?> <br>
              <?php if ($nota!='ALL'){?>
              Nota <?php echo $nota_start.' s/d '.$nota_end; ?> <br>
              <?php }?>
            </div>         
          </div>  
          <div class="card mb-3">  
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Invoice</th>
										  <th>Jual(Rp)</th>
                    </tr>
                  </thead>
                  <tbody>
        <?php
          if($model=="REKAP"){
            if ($nota=="ALL"){
              $query1="SELECT * FROM tb_beli
              WHERE kantor_beli='$kantor' AND event_beli='OFFICE' AND tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
            }else{
              $query1="SELECT * FROM tb_beli
              WHERE kantor_beli='$kantor' AND event_beli='OFFICE' AND id_beli BETWEEN '$nota_start' AND '$nota_end' AND tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";              
            }

            $result1 = mysqli_query($kon, $query1);
            while($baris1 = mysqli_fetch_assoc($result1)){
        ?>
                    <tr>
                      <td><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_beli']));  ?></td>
                      <td><?php echo $baris1['id_beli']; ?></td>
                      <td><?php echo rupiah($baris1['total_beli']); ?></td>
                    </tr>    
                    
        <?php
                $totju=$totju+$baris1['total_beli'];
        
              }
              ?>
               
                
        <?php
        //model detail
            }else{
              if ($nota=="ALL"){
                $query1="SELECT * FROM tb_beli 
                WHERE kantor_beli='$kantor' AND event_beli='OFFICE' AND tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
              }else{
                $query1="SELECT * FROM tb_beli 
                WHERE kantor_beli='$kantor' AND event_beli='OFFICE' AND id_beli BETWEEN '$nota_start' AND '$nota_end' AND tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";              
              }
  
              $result1 = mysqli_query($kon, $query1);
              while($baris1 = mysqli_fetch_assoc($result1)){
                $tmp_nota=$baris1['id_beli'];
          ?>
                      <tr>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_beli']));  ?></td>
                        <td><?php echo $baris1['id_beli']; ?>
                          <table>
                          <?php
                            $query1a="SELECT * FROM tb_detail_beli 
                            INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli.produk_detbeli
                            INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli.harga_detbeli
                            WHERE tb_detail_beli.nota_detbeli='$tmp_nota'";
              
                            $result1a = mysqli_query($kon, $query1a);
                            while($baris1a = mysqli_fetch_assoc($result1a)){
                              
                          ?>
                            <tr>
                              <td><?php echo $baris1a['produk_detbeli']; ?></td>
                              <td><?php echo $baris1a['nama_produk']; ?></td>
                              <td><?php echo $baris1a['qty_detbeli']; ?></td>
                              <td><?php echo "@".rupiah($baris1a['harga_harian']); ?></td>
                              <!-- <td><?php echo rupiah($baris1a['total_jumlah_detbeli']); ?></td> -->
                            </tr>
                          <?php
                            }
                          ?>
                          </table>
                        </td>
                        <td><?php echo rupiah($baris1['total_beli']); ?></td>
                      </tr>    
                      
          <?php
                  $totju=$totju+$baris1['total_beli'];
          
                }
            }
        ?>
            
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="2">TOTAL </th>
                      <th><?php echo rupiah($totju); ?></th>
                    </tr> 
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
                <a href="#" class="btn btn-success" id="cetak" 
                data-tgl_start="<?php echo $tgl_start; ?>"
                data-tgl_end="<?php echo $tgl_end; ?>"
                data-nota_start="<?php echo $nota_start; ?>"
                data-nota_end="<?php echo $nota_end; ?>"
                data-model="<?php echo $model; ?>"
                >Cetak</a>
              <a href="#" class="btn btn-danger btn-small-block" id="kembali"> Kembali</a>
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
       
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          window.location= 'popusat_nota.php';
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();        
          var tgl_start = $(this).attr('data-tgl_start');
          var tgl_end = $(this).attr('data-tgl_end');
          var nota_start = $(this).attr('data-nota_start');
          var nota_end = $(this).attr('data-nota_end');
          var model = $(this).attr('data-model');
          window.open(
            'Print Lap PO Nota.php?tgl_start='+tgl_start+'&tgl_end='+tgl_end+'&nota_start='+nota_start+'&nota_end='+nota_end+'&model='+model,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

