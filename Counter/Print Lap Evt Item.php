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
  $pdk = $_GET['pdk'];
  $status = $_GET['status'];
  $jenis = $_GET['jenis'];
  $nota_start = $_GET['nota_start'];
  $nota_end = $_GET['nota_end'];
  $model = $_GET['model'];
  $event = $_GET['event'];

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
              Event <?php echo $nama_event; ?> <br>
              Periode <?php echo $tgl_start.' s/d '.$tgl_end; ?> <br>
              <?php if ($nota!='ALL'){?>
              Nota <?php echo $nota_start.' s/d '.$nota_end; ?> <br>
              <?php }if ($pdk!='ALL'){?>
              Produk <?php echo $pdk; ?> <br>
              <?php }?>Status Penjualan <?php echo $status; ?> <br>
            </div>          <br>

            <table width="100%" cellspacing="0" cellpadding="2">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
										  <th>Beli(qty)</th>
										  <th>Retur(qty)</th>
										  <th>Beli(Rp)</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
      if($model=="REKAP"){
            
        if ($pdk=="ALL"){
          $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
          INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
          WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status'";
          $result = mysqli_query($kon, $query);
          while($baris = mysqli_fetch_assoc($result)){
            $det_pdk=$baris['id_produk'];
            $jml_pdk=0;
            $tot_jum=0;

            if ($nota=="ALL"){
              if ($jenis=="ALL"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              
              }elseif ($jenis=="LK"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";

              }else{
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";

              }

            
            }else{
              if ($jenis=="ALL"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              
              }elseif ($jenis=="LK"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              
              }else{
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              
              }

            }
             
            $result1 = mysqli_query($kon, $query1);
            while($baris1 = mysqli_fetch_assoc($result1)){
              $jml_pdk=$jml_pdk+$baris1['qty_detjual'];
              $tot_jum=$tot_jum+$baris1['total_jumlah_detjual'];
            }
            if($jml_pdk!="0"){
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td align="center"><?php echo $jml_pdk; ?></td>
                      <td align="center">-</td>
                      <td align="center"><?php echo rupiah($tot_jum); ?></td>
                    </tr>    
                    
    <?php
            }
            $totju=$totju+$tot_jum;
          }
        }else{
            $jml_pdk=0;
            $tot_jum=0;

            if ($nota=="ALL"){
              
              if ($jenis=="ALL"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            
              }elseif ($jenis=="LK"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            
              }else{
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            
              }

            }else{

              if ($jenis=="ALL"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              
              }elseif ($jenis=="LK"){
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
              
              }else{
                $query1="SELECT * FROM tb_produk 
                INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
            
              }

            }
            
            $result1 = mysqli_query($kon, $query1);
            while($baris1 = mysqli_fetch_assoc($result1)){
              $jml_pdk=$jml_pdk+$baris1['qty_detjual'];
              $tot_jum=$tot_jum+$baris1['total_jumlah_detjual'];
              $nama_pdk=$baris1['nama_produk'];
            }
    ?>
                    <tr>
                      <td><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?></td>
                      <td align="center"><?php echo $jml_pdk; ?></td>
                      <td align="center">-</td>
                      <td align="center"><?php echo rupiah($tot_jum); ?></td>
                    </tr> 
    <?php
              
              $totju=$totju+$tot_jum;
            }
          }else{
            //model detail
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
              INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
              WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' ";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  if ($jenis=="ALL"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                 
                  }elseif ($jenis=="LK"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                 
                  }else{
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                 
                  }

                }else{
                  if ($jenis=="ALL"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  
                  }elseif ($jenis=="LK"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  
                  }else{
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$det_pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                
                  }

                }
                 
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detjual'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detjual'];
                }
                if($jml_pdk!="0"){
    ?>
                    <tr>
                      <td valign="top"><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?>
                        <table cellpadding="5">
                          <?php
                            $result1a = mysqli_query($kon, $query1);
                            while($baris1a = mysqli_fetch_assoc($result1a)){
                              
                          ?>
                            <tr>
                              <td><?php echo date('d-m-Y', strtotime($baris1a['tgl_order_jual'])); ?></td>
                              <td><?php echo $baris1a['id_jual']; ?></td>
                              <td><?php echo $baris1a['qty_detjual']; ?></td>
                              <td><?php echo rupiah($baris1a['total_jumlah_detjual']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                      </td>
                      <td valign="top" align="center"><?php echo $jml_pdk; ?></td>
                      <td valign="top" align="center">-</td>
                      <td valign="top" align="center"><?php echo rupiah($tot_jum); ?></td>
                    </tr>    
                    
    <?php
                }
                $totju=$totju+$tot_jum;
              }
            }else{
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  if ($jenis=="ALL"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  
                  }elseif ($jenis=="LK"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  
                  }else{
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                    
                  }

                }else{
                  if ($jenis=="ALL"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  
                  }elseif ($jenis=="LK"){
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual!='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                  
                  }else{
                    $query1="SELECT * FROM tb_produk 
                    INNER JOIN tb_detail_jual ON tb_detail_jual.produk_detjual=tb_produk.id_produk 
                    INNER JOIN tb_jual ON tb_jual.id_jual=tb_detail_jual.nota_detjual
                    WHERE tb_jual.kantor_jual='$kantor' AND tb_jual.status_jual='$status' AND tb_detail_jual.produk_detjual='$pdk' AND tb_jual.acara_jual='$event' AND tb_jual.jenis_jual='UMUM' AND tb_detail_jual.nota_detjual BETWEEN '$nota_start' AND '$nota_end' AND tb_jual.tgl_order_jual BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                    
                  }

                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detjual'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detjual'];
                  $nama_pdk=$baris1['nama_produk'];
                }
    ?>
                    <tr>
                      <td valign="top"><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?>
                        <table cellpadding="5">
                          <?php
                            $result1a = mysqli_query($kon, $query1);
                            while($baris1a = mysqli_fetch_assoc($result1a)){
                              
                          ?>
                            <tr>
                              <td><?php echo date('d-m-Y', strtotime($baris1a['tgl_order_jual'])); ?></td>
                              <td><?php echo $baris1a['id_jual']; ?></td>
                              <td><?php echo $baris1a['qty_detjual']; ?></td>
                              <td><?php echo rupiah($baris1a['total_jumlah_detjual']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                        </table>
                      </td>
                      <td valign="top" align="center"><?php echo $jml_pdk; ?></td>
                      <td valign="top" align="center">-</td>
                      <td valign="top" align="center"><?php echo rupiah($tot_jum); ?></td>
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
    <script>
      window.print();
    </script>