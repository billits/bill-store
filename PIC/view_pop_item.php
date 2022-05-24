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
            <li class="breadcrumb-item active"> Laporan BTB Pusat Cabang <?php echo $_COOKIE['office_bill']; ?>  Per Item</li>
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
      $pdk = $_POST['pdk'];
      // $status = $_POST['status'];
      // $jenis = $_POST['jenis'];
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
              <?php }if ($pdk!='ALL'){?>
              Produk <?php echo $pdk; ?> <br>
              <?php }?> <br>
            </div>         
          </div>  
          <div class="card mb-3">  
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Jual(qty)</th>
										  <th>Retur(qty)</th>
										  <th>Jual(Rp)</th>
                    </tr>
                  </thead>
                  <tbody>
        <?php
          if($model=="REKAP"){
            
            if ($pdk=="ALL"){
              //ganti tabel beli dan hapus status
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk 
              INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
              INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
              WHERE tb_beli.kantor_beli='$kantor'";
              $result = mysqli_query($kon, $query);
          
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                    INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                    WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.event_beli='OFFICE' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.event_beli='OFFICE' AND tb_detail_beli.nota_detbeli BETWEEN '$nota_start' AND '$nota_end' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                 
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
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
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                    INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                    WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_beli.event_beli='OFFICE' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_beli.event_beli='OFFICE' AND tb_detail_beli.nota_detbeli BETWEEN '$nota_start' AND '$nota_end' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
                  $nama_pdk=$baris1['nama_produk'];
                }
                
                if($jml_pdk!="0"){
    ?>
                    <tr>
                      <td><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?></td>
                      <td><?php echo $jml_pdk; ?></td>
                      <td>-</td>
                      <td><?php echo rupiah($tot_jum); ?></td>
                    </tr> 
    <?php
                } 
              $totju=$totju+$tot_jum;
            }
          }else{
            //model detail
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
              INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
              WHERE tb_beli.kantor_beli='$kantor'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                    INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                    WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.event_beli='OFFICE' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                    INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                    WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.event_beli='OFFICE' AND tb_detail_beli.nota_detbeli BETWEEN '$nota_start' AND '$nota_end' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                 
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
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
                            <td><?php echo date('d-m-Y', strtotime($baris1a['tgl_beli'])); ?></td>
                            <td><?php echo $baris1a['id_beli']; ?></td>
                            <td><?php echo $baris1a['qty_detbeli']; ?></td>
                            <td><?php echo rupiah($baris1a['total_jumlah_detbeli']); ?></td>
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
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                    INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                    WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_beli.event_beli='OFFICE' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                    INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                    WHERE tb_beli.kantor_beli='$kantor' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_beli.event_beli='OFFICE' AND tb_detail_beli.nota_detbeli BETWEEN '$nota_start' AND '$nota_end' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
                  $nama_pdk=$baris1['nama_produk'];
                }
              
                if($jml_pdk!="0"){
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
                            <td><?php echo date('d-m-Y', strtotime($baris1a['tgl_beli'])); ?></td>
                            <td><?php echo $baris1a['id_beli']; ?></td>
                            <td><?php echo $baris1a['qty_detbeli']; ?></td>
                            <td><?php echo rupiah($baris1a['total_jumlah_detbeli']); ?></td>
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
          }
    ?>              
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4">TOTAL </th>
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
          window.location= 'popusat_item.php';
        });
        
        $(document).on('click','#cetak',function(e){
          e.preventDefault();                 
          var tgl_start = $(this).attr('data-tgl_start');
          var tgl_end = $(this).attr('data-tgl_end');
          var pdk = $(this).attr('data-pdk');
          var nota_start = $(this).attr('data-nota_start');
          var nota_end = $(this).attr('data-nota_end');
          var model = $(this).attr('data-model');
          window.open(
            'Print Lap PO Item.php?tgl_start='+tgl_start+'&tgl_end='+tgl_end+'&pdk='+pdk+'&nota_start='+nota_start+'&nota_end='+nota_end+'&model='+model,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

