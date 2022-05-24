<?php

  include "../db_proses/koneksi.php";
  session_start();
  $kantor = $_COOKIE['office_bill'];      

  function rupiah($angka){
    $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
    return $hasil_rupiah;
  }

  $tgl_start = $_GET['tgl_start'];
  $tgl_end = $_GET['tgl_end'];
  $status = $_GET['status'];
  $jenis = $_GET['jenis'];
  $nota_start = $_GET['nota_start'];
  $nota_end = $_GET['nota_end'];
  $model = $_GET['model'];

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
  <head>
    <meta http-equiv="Content-Type" content="text/html/css; charset=utf-8" />   
    <meta name='description' content='Billionaires Store'>
    <meta name='author' content='KiiGeeks'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='../img/favcon.png'>
    <title> Laporan Penjualan </title>
  </head>

            <div>
            Laporan Penjualan <?php echo $_COOKIE['office_bill']; ?> <br>
              Periode <?php echo $tgl_start.' s/d '.$tgl_end; ?> <br>
              <?php if ($nota!='ALL'){?>
              Nota <?php echo $nota_start.' s/d '.$nota_end; ?> <br>
              <?php }?>Status Penjualan <?php echo $status; ?> <br>
            </div>          <br>

            <table width="100%" cellspacing="0" cellpadding="2">
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
          if ($jenis=="ALL"){
            $query1="SELECT * FROM  tb_jual
            WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
          }elseif ($jenis=="LK"){
            $query1="SELECT * FROM tb_jual 
            WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual!='UMUM' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
          }else{
            $query1="SELECT * FROM tb_jual 
            WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual='UMUM' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
          }
        }else{
          if ($jenis=="ALL"){
            $query1="SELECT * FROM tb_jual 
            WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND id_jual BETWEEN '$nota_start' AND '$nota_end' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";              
          }elseif ($jenis=="LK"){
            $query1="SELECT * FROM tb_jual
            WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual!='UMUM' AND id_jual BETWEEN '$nota_start' AND '$nota_end' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
          }else{
            $query1="SELECT * FROM tb_jual
            WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual='UMUM' AND id_jual BETWEEN '$nota_start' AND '$nota_end' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
          }
        }

          $result1 = mysqli_query($kon, $query1);
          while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                <tr>
                  <td valign="top"><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_order_jual'])); ?></td>
                  <td><?php echo $baris1['id_jual']; ?></td>
                  <td align="center"><?php echo rupiah($baris1['total_jual']); ?></td>
                </tr>    
                
    <?php
            $totju=$totju+$baris1['total_jual'];
    
          }
          ?>
           
            
    <?php
    //model detail
        }else{
          if ($nota=="ALL"){
            if ($jenis=="ALL"){
              $query1="SELECT * FROM  tb_jual 
              WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
            }elseif ($jenis=="LK"){
              $query1="SELECT * FROM tb_jual 
              WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual!='UMUM' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            }else{
              $query1="SELECT * FROM tb_jual 
              WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual='UMUM' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            }
          }else{
            if ($jenis=="ALL"){
              $query1="SELECT * FROM tb_jual 
              WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND id_jual BETWEEN '$nota_start' AND '$nota_end' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";              
            }elseif ($jenis=="LK"){
              $query1="SELECT * FROM tb_jual
              WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual!='UMUM' AND id_jual BETWEEN '$nota_start' AND '$nota_end' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            }else{
              $query1="SELECT * FROM tb_jual
              WHERE kantor_jual='$kantor' AND status_jual='$status' AND acara_jual='OFFICE' AND jenis_jual='UMUM' AND id_jual BETWEEN '$nota_start' AND '$nota_end' AND tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            }
          }

            $result1 = mysqli_query($kon, $query1);
            while($baris1 = mysqli_fetch_assoc($result1)){
              $tmp_nota=$baris1['id_jual'];
      ?>
                  <tr>
                    <td valign="top"><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_order_jual'])); ?></td>
                    <td><?php echo $baris1['id_jual']; ?>
                      <table cellpadding=5>
                      <?php
                        $query1a="SELECT * FROM tb_detail_jual INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_jual.produk_detjual
                        INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_jual.harga_detjual
                        WHERE tb_detail_jual.nota_detjual='$tmp_nota'";
          
                        $result1a = mysqli_query($kon, $query1a);
                        while($baris1a = mysqli_fetch_assoc($result1a)){
                          
                      ?>
                        <tr>
                          <td><?php echo $baris1a['produk_detjual']; ?></td>
                          <td><?php echo $baris1a['nama_produk']; ?></td>
                          <td><?php echo $baris1a['qty_detjual']; ?></td>
                          <td><?php echo "@".rupiah($baris1a['harga_harian']); ?></td>
                          <!-- <td><?php echo rupiah($baris1a['total_jumlah_detjual']); ?></td> -->
                        </tr>
                      <?php
                        }
                      ?>
                      </table>
                    </td>
                    <td valign="top" align="center"><?php echo rupiah($baris1['total_jual']); ?></td>
                  </tr>    
                  
      <?php
              $totju=$totju+$baris1['total_jual'];
      
            }
        }
    ?>             
                  </tbody>
                  <tfoot>         
                    <tr>
                      <th colspan="2">Total </th>
                      <th><?php echo rupiah($totju); ?></th>
                    </tr> 
                  </tfoot>
                </table>
    <script>
      window.print();
    </script>