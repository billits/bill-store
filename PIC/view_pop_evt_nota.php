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
            <li class="breadcrumb-item active"> Laporan BTB Event <?php echo $_COOKIE['office_bill']; ?>  Per Nota</li>
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
      $event = $_POST['event'];

      $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
      $tgl_temp=date('Y-m-d', strtotime($tgl_end));
      $tgl_selesai = $tgl_temp." 23:59:59";

      if ($nota_start=='ALL'||$nota_end=='ALL'){
        $nota="ALL";
      }else{
        $nota="NONE";
      }

      $sqlre= "SELECT * FROM tb_detail_events WHERE id_det_event = '$event'";
      $resultre = mysqli_query($kon,$sqlre);	  
      $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);	
      $nama_event = $rowre['nama_det_event'];

      $jml_pdk=0;
      $tot_jum=0;
      $totju=0;

    ?>
          
          <div class="card mb-3">    
            <div class="card-header">
              Laporan BTB Event <?php echo $_COOKIE['office_bill']; ?> <br>
              Event <?php echo $nama_event; ?> <br>
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
                $query1="SELECT * FROM tb_beli_event
                WHERE kantor_beli_event='$kantor' AND event_beli_event='$event' AND tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
              
            }else{
                $query1="SELECT * FROM tb_beli_event 
                WHERE kantor_beli_event='$kantor' AND event_beli_event='$event' AND id_beli_event BETWEEN '$nota_start' AND '$nota_end' AND tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";              
              
            }

              $result1 = mysqli_query($kon, $query1);
              while($baris1 = mysqli_fetch_assoc($result1)){
        ?>
                    <tr>
                      <td><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_beli_event']));  ?></td>
                      <td><?php echo $baris1['id_beli_event']; ?></td>
                      <td><?php echo rupiah($baris1['total_beli_event']); ?></td>
                    </tr>    
                    
        <?php
                $totju=$totju+$baris1['total_beli_event'];
        
              }
              ?>
               
                
        <?php
        //model detail
            }else{
              if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_beli_event
                  WHERE kantor_beli_event='$kantor' AND event_beli_event='$event' AND tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
                
              }else{
                  $query1="SELECT * FROM tb_beli_event 
                  WHERE kantor_beli_event='$kantor' AND event_beli_event='$event' AND id_beli_event BETWEEN '$nota_start' AND '$nota_end' AND tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";              
                
              }
  
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $tmp_nota=$baris1['id_beli_event'];
          ?>
                      <tr>
                        <td><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_beli_event']));  ?></td>
                        <td><?php echo $baris1['id_beli_event']; ?>
                          <table>
                          <?php
                            $query1a="SELECT * FROM tb_detail_beli_event INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev
                            INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev
                            WHERE tb_detail_beli_event.nota_detbelev='$tmp_nota'";
              
                            $result1a = mysqli_query($kon, $query1a);
                            while($baris1a = mysqli_fetch_assoc($result1a)){
                              
                          ?>
                            <tr>
                              <td><?php echo $baris1a['produk_detbelev']; ?></td>
                              <td><?php echo $baris1a['nama_produk']; ?></td>
                              <td><?php echo $baris1a['qty_detbelev']; ?></td>
                              <td><?php echo "@".rupiah($baris1a['harga_harian']); ?></td>
                              <!-- <td><?php echo rupiah($baris1a['total_jumlah_detbelev']); ?></td> -->
                            </tr>
                          <?php
                            }
                          ?>
                          </table>
                        </td>
                        <td><?php echo rupiah($baris1['total_beli_event']); ?></td>
                      </tr>    
                      
          <?php
                  $totju=$totju+$baris1['total_beli_event'];
          
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
                data-event="<?php echo $event; ?>"
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
          window.location= 'poevent_nota.php';
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();         
          var tgl_start = $(this).attr('data-tgl_start');
          var tgl_end = $(this).attr('data-tgl_end');
          var nota_start = $(this).attr('data-nota_start');
          var nota_end = $(this).attr('data-nota_end');
          var model = $(this).attr('data-model');
          var event = $(this).attr('data-event');
          window.open(
            'Print Lap PO Evt Nota.php?tgl_start='+tgl_start+'&tgl_end='+tgl_end+'&nota_start='+nota_start+'&nota_end='+nota_end+'&model='+model+'&event='+event,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

