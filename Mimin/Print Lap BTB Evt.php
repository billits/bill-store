<?php

  include "../db_proses/koneksi.php";   

  function rupiah($angka){
    $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
    return $hasil_rupiah;
  }

  $tgl_start = $_GET['tgl_start'];
  $tgl_end = $_GET['tgl_end'];
  $pdk = $_GET['pdk'];
  $nota = $_GET['nota'];
  $model = $_GET['model']; 
  $offc = $_GET['offc']; 
  $stat = $_GET['stat'];
  $event = $_GET['event'];

  $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
  $tgl_temp=date('Y-m-d', strtotime($tgl_end));
  $tgl_selesai = $tgl_temp." 23:59:59";
  $jml_pdk=0;
  $tot_jum=0;
  $totju=0;

  $query11i= "SELECT * FROM tb_detail_events WHERE id_det_event='$event'";
  $result11i = mysqli_query($kon,$query11i);
  $baris11i = mysqli_fetch_array($result11i,MYSQLI_ASSOC);

  $query11="SELECT * FROM tb_office WHERE id_office='$offc'";
  $result11 = mysqli_query($kon, $query11);
  while($baris11 = mysqli_fetch_assoc($result11)){
    $nama_offc=$baris11['nama_office'];
  }
?>
  <head>
    <meta http-equiv="Content-Type" content="text/html/css; charset=utf-8" />   
    <meta name='description' content='Billionaires Store'>
    <meta name='author' content='KiiGeeks'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='../img/favcon.png'>
    <title> Laporan BTB Event </title>
  </head>

            <div>
              Laporan BTB Event <br>
              Periode <?php echo $tgl_start.' - '.$tgl_end; ?> <br>              
              Cabang <?php echo $nama_offc; ?> <br>                  
              Event <?php echo $baris11i['nama_det_event']; ?> <br>
              <?php if ($nota!='ALL'){?>
              Kode Nota <?php echo $nota; ?> <br>
              <?php }if ($pdk!='ALL'){?>
              Kode Produk <?php echo $pdk; ?> <br>
              <?php }?>
              Status BTB <?php echo $stat; ?> <br>
            </div> <br>

            <table width="100%" cellspacing="0" cellpadding="7" border="1">
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
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk 
              INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
              INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
              WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.event_beli_event='$event'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$det_pdk' AND tb_beli_event.event_beli_event='$event' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$det_pdk' AND tb_beli_event.event_beli_event='$event' AND tb_beli_event.stat_beli_event='$stat' AND tb_detail_beli_event.nota_detbelev='$nota' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
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
                      <td align="center"><?php echo $jml_pdk; ?></td>
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
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$pdk' AND tb_beli_event.event_beli_event='$event' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$pdk' AND tb_beli_event.event_beli_event='$event' AND tb_detail_beli_event.nota_detbelev='$nota' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
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
                      <td align="center"><?php echo $jml_pdk; ?></td>
                      <td align="center"><?php echo rupiah($tot_jum); ?></td>
                    </tr> 
    <?php
              
              $totju=$totju+$tot_jum;
            }
          }else{
            //model detail
            if ($pdk=="ALL"){
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
              INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
              WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.event_beli_event='$event'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$det_pdk' AND tb_beli_event.event_beli_event='$event' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$det_pdk' AND tb_beli_event.event_beli_event='$event' AND tb_beli_event.stat_beli_event='$stat' AND tb_detail_beli_event.nota_detbelev='$nota' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbelev'];
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
                      <td valign="top" align="center"><?php echo $jml_pdk; ?></td>
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
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$pdk' AND tb_beli_event.event_beli_event='$event' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli_event ON tb_detail_beli_event.produk_detbelev=tb_produk.id_produk 
                  INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev
                  WHERE tb_beli_event.kantor_beli_event='$offc' AND tb_detail_beli_event.produk_detbelev='$pdk' AND tb_beli_event.event_beli_event='$event' AND tb_detail_beli_event.nota_detbelev='$nota' AND tb_beli_event.stat_beli_event='$stat' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbelev'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbelev'];
                  $nama_pdk=$baris1['nama_produk'];
                }
    ?>
                    <tr>
                      <td valign="top"><?php echo $pdk; ?></td>
                      <td><?php echo $nama_pdk; ?>
                        <table  cellpadding="5">
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
                      <td valign="top" align="center"><?php echo $jml_pdk; ?></td>
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
                      <th colspan="3">Total </th>
                      <th><?php echo rupiah($totju); ?></th>
                    </tr> 
                  </tfoot>
                </table>
    <script>
      window.print();
    </script>