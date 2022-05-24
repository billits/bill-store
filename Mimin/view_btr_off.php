<?php
  include ('akses.php');
  include ('../_partials/partial_admin.php');
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
            <li class="breadcrumb-item active">Laporan BTB Office</li>
          </ol>

          <!-- DataTables Example -->
    <?php
      include "../db_proses/koneksi.php";
      

      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      
      $tgl_start = $_POST['tgl_start'];
      $tgl_end = $_POST['tgl_end'];
      $pdk = $_POST['pdk'];
      $nota = $_POST['nota_start'];
      $model = $_POST['model']; 
      $offc = $_POST['offc'];
      $stat = $_POST['stat'];

      $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
      $tgl_temp=date('Y-m-d', strtotime($tgl_end));
      $tgl_selesai = $tgl_temp." 23:59:59";

      $jml_pdk=0;
      $tot_jum=0;
      $totju=0;

      $query11="SELECT * FROM tb_office WHERE id_office='$offc'";
      $result11 = mysqli_query($kon, $query11);
      while($baris11 = mysqli_fetch_assoc($result11)){
        $nama_offc=$baris11['nama_office'];
      }
    ?>

            
          <div class="card mb-3">  
            <div class="card-header">
              Laporan BTR Office <?php echo $nama_offc; ?> <br>
              Periode <?php echo $tgl_start.' - '.$tgl_end; ?> <br>
              <?php if ($nota!='ALL'){?>
              Kode Nota <?php echo $nota; ?> <br>
              <?php }if ($pdk!='ALL'){?>
              Kode Produk <?php echo $pdk; ?> <br>
              <?php }?>
              Status BTR <?php echo $stat; ?> <br>
            </div>    
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Qty</th>
										  <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
          if($model=="REKAP"){
            
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
              INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
              WHERE tb_retur_event.kantor_returevt='$offc' AND tb_retur_event.status_returevt='$stat'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$det_pdk' AND tb_retur_event.status_returevt='$stat' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$det_pdk' AND tb_retur_event.status_returevt='$stat' AND tb_detail_retur_event.id_detretevt='$nota' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['jumret_detretevt'];
                  $tot_jum=$tot_jum+$baris1['totjum_detretevt'];
                }
                if($jml_pdk!="0"){
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
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
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$pdk' AND tb_retur_event.status_returevt='$stat' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$pdk' AND tb_detail_retur_event.id_detretevt='$nota' AND tb_retur_event.status_returevt='$stat' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['jumret_detretevt'];
                  $tot_jum=$tot_jum+$baris1['totjum_detretevt'];
                  $nama_pdk=$baris1['nama_produk'];
                }
    ?>
                    <tr>
                      <td><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td><?php echo rupiah($tot_jum); ?></td>
                    </tr> 
    <?php
              
              $totju=$totju+$tot_jum;
            }
          }else{
            //model detail
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
              INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
              WHERE tb_retur_event.kantor_returevt='$offc' AND tb_retur_event.status_returevt='$stat'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$det_pdk' AND tb_retur_event.status_returevt='$stat' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                 }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$det_pdk' AND tb_retur_event.status_returevt='$stat' AND tb_detail_retur_event.id_detretevt='$nota' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['jumret_detretevt'];
                  $tot_jum=$tot_jum+$baris1['totjum_detretevt'];
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
                              <td><?php echo date('d-m-Y', strtotime($baris1a['waktu_returevt'])); ?></td>
                              <td><?php echo $baris1a['id_returevt']; ?></td>
                              <td><?php echo $baris1a['jumret_detretevt']; ?></td>
                              <td><?php echo rupiah($baris1a['totjum_detretevt']); ?></td>
                              <td><a href="../Print Nota BTR Pusat.php?nota=<?php echo $baris1a['id_returevt']; ?>" target="_blank">CETAK</a></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                      </td>
                      <td><?php echo $jml_pdk; ?></td>
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
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$pdk' AND tb_retur_event.status_returevt='$stat' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_retur_event ON tb_detail_retur_event.produk_detretevt=tb_produk.id_produk 
                  INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt
                  WHERE tb_retur_event.kantor_returevt='$offc' AND tb_detail_retur_event.produk_detretevt='$pdk' AND tb_detail_retur_event.id_detretevt='$nota' AND tb_retur_event.status_returevt='$stat' AND tb_retur_event.waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['jumret_detretevt'];
                  $tot_jum=$tot_jum+$baris1['totjum_detretevt'];
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
                              <td><?php echo date('d-m-Y', strtotime($baris1a['waktu_returevt'])); ?></td>
                              <td><?php echo $baris1a['id_returevt']; ?></td>
                              <td><?php echo $baris1a['jumret_detretevt']; ?></td>
                              <td><?php echo rupiah($baris1a['totjum_detretevt']); ?></td>
                              <td><a href="../Print Nota BTR Pusat.php?nota=<?php echo $baris1a['id_returevt']; ?>" target="_blank">CETAK</a></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                      </td>
                      <td><?php echo $jml_pdk; ?></td>
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
                      <th colspan="3">Total </th>
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
          window.location= 'lp_btr_off.php';
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();          
          var tgl_start = $(this).attr('data-tgl_start');
          var tgl_end = $(this).attr('data-tgl_end');
          var pdk = $(this).attr('data-pdk');
          var nota = $(this).attr('data-nota');
          var model = $(this).attr('data-model');
          var offc = $(this).attr('data-offc');
          var stat = $(this).attr('data-stat');
          window.open(
            'Print Lap BTR Office.php?tgl_start='+tgl_start+'&tgl_end='+tgl_end+'&pdk='+pdk+'&nota='+nota+'&model='+model+'&offc='+offc+'&stat='+stat,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

