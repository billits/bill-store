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
  <head>
    <meta http-equiv="Content-Type" content="text/html/css; charset=utf-8" />   
    <meta name='description' content='Billionaires Store'>
    <meta name='author' content='Billionaires'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='../img/favcon.png'>
    <title> Laporan BTR Office </title>
  </head>

            <div>
              Laporan BTR Office <?php echo $nama_offc; ?> <br>
              Periode <?php echo $tgl_start.' - '.$tgl_end; ?> <br>
              <?php if ($nota!='ALL'){?>
              Kode Nota <?php echo $nota; ?> <br>
              <?php }if ($pdk!='ALL'){?>
              Kode Produk <?php echo $pdk; ?> <br>
              <?php }?>
              Status BTR <?php echo $stat; ?> <br>
            </div> <br>

            <table width="100%" cellspacing="0" cellpadding="7" border="1">
                  <thead>
                    <tr>
                      <th align="left">Kode</th>
                      <th align="left">Produk</th>
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
                      <td align="center"><?php echo $jml_pdk; ?></td>
                      <td align="center"><?php echo rupiah($tot_jum); ?></td>
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
                      <td valign="top"><?php echo $baris['id_produk']; ?></td>
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
                      <td valign="top"><?php echo $pdk; ?></td>
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