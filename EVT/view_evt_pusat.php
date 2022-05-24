<?php
  include ('akses.php');
  include ('../_partials/partial_evt.php');
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
            <li class="breadcrumb-item active">Laporan Konsi Event Pusat Kantor <?php echo $_COOKIE['nama_office']; ?></li>
          </ol>

          <!-- DataTables Example -->
    <?php
      include "../db_proses/koneksi.php";
      
      $kantor = $_COOKIE['id_office'];      

      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $tgl_start = $_POST['tgl_start'];
      $tgl_end = $_POST['tgl_end'];
      $pdk = $_POST['pdk'];
      $nota = $_POST['nota_start'];
      $model = $_POST['model']; 
      // $offc = $_POST['offc'];
      $offc = 'SBY';
      $stat = $_POST['stat'];
      $event = $_POST['event'];

      $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
      $tgl_temp=date('Y-m-d', strtotime($tgl_end));
      $tgl_selesai = $tgl_temp." 23:59:59";
      $jml_pdk=0;
      $tot_jum=0;
      $totju=0;

      $query11i= "SELECT * FROM detail_events WHERE id_det_event='$event'";
      $result11i = mysqli_query($kon,$query11i);
      $baris11i = mysqli_fetch_array($result11i,MYSQLI_ASSOC);

      $query11="SELECT * FROM office WHERE id_office='$offc'";
      $result11 = mysqli_query($kon, $query11);
      while($baris11 = mysqli_fetch_assoc($result11)){
        $nama_offc=$baris11['nama_office'];
      }

         
    ?>
          
            
          <div class="card mb-3">  
            <div class="card-header">
              Laporan Konsi Event  <br>
              Periode <?php echo $tgl_start.' - '.$tgl_end; ?> <br>            
              Event <?php echo $baris11i['nama_det_event']; ?> <br>              
              <?php if ($nota!='ALL'){?>
              Kode Nota <?php echo $nota; ?> <br>
              <?php }if ($pdk!='ALL'){?>
              Kode Produk <?php echo $pdk; ?> <br>
              <?php }?>
              Status PO Event <?php echo $stat; ?> <br>
            </div>    
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Beli(qty)</th>
										  <th>Retur(qty)</th>
										  <th>Beli(Rp)</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
          if($model=="REKAP"){
            
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT produk.id_produk, produk.nama_produk FROM produk 
              INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
              INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
              WHERE beli_event.kantor_beli_event='$offc' AND beli_event.stat_beli_event='$stat' AND beli_event.event_beli_event='$event'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$det_pdk' AND beli_event.event_beli_event='$event' AND beli_event.stat_beli_event='$stat' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$det_pdk' AND beli_event.event_beli_event='$event' AND beli_event.stat_beli_event='$stat' AND detail_beli_event.nota_detbelev='$nota' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbelev'];
                }
                if($jml_pdk!="0"){
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td>-</td>
                      <td><?php echo rupiah($tot_jum); ?></td>
                    </tr>    
                    
    <?php
                }
                $totju=$totju+$tot_jum;
              }
            }else{
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$pdk' AND beli_event.event_beli_event='$event' AND beli_event.stat_beli_event='$stat' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$pdk' AND beli_event.event_beli_event='$event' AND detail_beli_event.nota_detbelev='$nota' AND beli_event.stat_beli_event='$stat' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbelev'];
                  $nama_pdk=$baris1['nama_produk'];
                }
    ?>
                    <tr>
                      <td><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td>-</td>
                      <td><?php echo rupiah($tot_jum); ?></td>
                    </tr> 
    <?php
              
              $totju=$totju+$tot_jum;
            }
          }else{
            //model detail
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT produk.id_produk, produk.nama_produk FROM produk INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
              INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
              WHERE beli_event.kantor_beli_event='$offc' AND beli_event.stat_beli_event='$stat' AND beli_event.event_beli_event='$event'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$det_pdk' AND beli_event.event_beli_event='$event' AND beli_event.stat_beli_event='$stat' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$det_pdk' AND beli_event.event_beli_event='$event' AND beli_event.stat_beli_event='$stat' AND detail_beli_event.nota_detbelev='$nota' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbelev'];
                }
                if($jml_pdk!="0"){
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?>
                        <table>
                          <?php
                            $result1a = mysqli_query($kon, $query1);
                            while($baris1a = mysqli_fetch_assoc($result1a)){
                              
                          ?>
                            <tr>
                              <td><?php echo date('d-m-Y', strtotime($baris1a['tgl_beli_event'])); ?></td>
                              <td><?php echo $baris1a['id_beli_event']; ?></td>
                              <td><?php echo $baris1a['qty_detbelev']; ?></td>
                              <td><?php echo rupiah($baris1a['total_jumlah_detbelev']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                      </td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td>-</td>
                      <td><?php echo rupiah($tot_jum); ?></td>
                    </tr>    
                    
    <?php
                }
                $totju=$totju+$tot_jum;
              }
            }else{
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$pdk' AND beli_event.event_beli_event='$event' AND beli_event.stat_beli_event='$stat' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM produk 
                  INNER JOIN detail_beli_event ON detail_beli_event.produk_detbelev=produk.id_produk 
                  INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev
                  WHERE beli_event.kantor_beli_event='$offc' AND detail_beli_event.produk_detbelev='$pdk' AND beli_event.event_beli_event='$event' AND detail_beli_event.nota_detbelev='$nota' AND beli_event.stat_beli_event='$stat' AND beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbelev'];
                  $nama_pdk=$baris1['nama_produk'];
                }
    ?>
                    <tr>
                      <td><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?>
                        <table>
                          <?php
                            $result1a = mysqli_query($kon, $query1);
                            while($baris1a = mysqli_fetch_assoc($result1a)){
                              
                          ?>
                            <tr>
                              <td><?php echo date('d-m-Y', strtotime($baris1a['tgl_beli_event'])); ?></td>
                              <td><?php echo $baris1a['id_beli_event']; ?></td>
                              <td><?php echo $baris1a['qty_detbelev']; ?></td>
                              <td><?php echo rupiah($baris1a['total_jumlah_detbelev']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                      </td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td>-</td>
                      <td><?php echo rupiah($tot_jum); ?></td>
                    </tr> 
    <?php
              
              $totju=$totju+$tot_jum;
            }
          }
    ?>             
                  </tbody>
                  <tfoot>         
                    <tr>
                      <th colspan="4">Total </th>
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
                data-pdk="<?php echo $pdk; ?>"
                data-nota="<?php echo $nota; ?>"
                data-model="<?php echo $model; ?>"
                data-offc="<?php echo $offc; ?>"
                data-event="<?php echo $event; ?>"
                data-stat="<?php echo $stat; ?>"
                >Cetak</a>
              <a href="#" class="btn btn-danger btn-small-block" id="kembali"> Kembali</a>
            </div>
          </div>
    <?php
      
    ?>
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
          window.location= 'po_evt_pusat.php';
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();          
          var tgl_start = $(this).attr('data-tgl_start');
          var tgl_end = $(this).attr('data-tgl_end');
          var pdk = $(this).attr('data-pdk');
          var nota = $(this).attr('data-nota');
          var model = $(this).attr('data-model');
          var stat = $(this).attr('data-stat');
          var event = $(this).attr('data-event');
          window.open(
            'Print Lap Evt Pusat.php?tgl_start='+tgl_start+'&tgl_end='+tgl_end+'&pdk='+pdk+'&nota='+nota+'&model='+model+'&stat='+stat+'&event='+event,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

