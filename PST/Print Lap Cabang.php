<?php

  include "../db_proses/koneksi.php";
  
  $kantor = $_COOKIE['office_bill'];      

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
    <meta name='author' content='KiiGeeks'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='../img/favcon.png'>
    <title> Laporan Cabang </title>
  </head>

            <div>
              Laporan BTB Cabang <?php echo $nama_offc.' - '.$_COOKIE['office_bill']; ?> <br>
              Periode <?php echo $tgl_start.' - '.$tgl_end; ?> <br>
              <?php if ($nota!='ALL'){?>
              Kode Nota <?php echo $nota; ?> <br>
              <?php }if ($pdk!='ALL'){?>
              Kode Produk <?php echo $pdk; ?> <br>
              <?php }?>
              Status BTB <?php echo $stat; ?> <br>
            </div> <br>

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
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
              INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
              WHERE tb_beli.kantor_beli='$offc' AND tb_beli.status_beli='$stat'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.status_beli='$stat' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
               }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.status_beli='$stat' AND tb_detail_beli.nota_detbeli='$nota' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
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
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_beli.status_beli='$stat' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_detail_beli.nota_detbeli='$nota' AND tb_beli.status_beli='$stat' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
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
              $query="SELECT DISTINCT tb_produk.id_produk, tb_produk.nama_produk FROM tb_produk INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
              INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
              WHERE tb_beli.kantor_beli='$offc' AND tb_beli.status_beli='$stat'";
              $result = mysqli_query($kon, $query);
              while($baris = mysqli_fetch_assoc($result)){
                $det_pdk=$baris['id_produk'];
                $jml_pdk=0;
                $tot_jum=0;

                if ($nota=="ALL"){
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.status_beli='$stat' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
               }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$det_pdk' AND tb_beli.status_beli='$stat' AND tb_detail_beli.nota_detbeli='$nota' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
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
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_beli.status_beli='$stat' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }else{
                  $query1="SELECT * FROM tb_produk 
                  INNER JOIN tb_detail_beli ON tb_detail_beli.produk_detbeli=tb_produk.id_produk 
                  INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli
                  WHERE tb_beli.kantor_beli='$offc' AND tb_detail_beli.produk_detbeli='$pdk' AND tb_detail_beli.nota_detbeli='$nota' AND tb_beli.status_beli='$stat' AND tb_beli.tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";
                }
                
                $result1 = mysqli_query($kon, $query1);
                while($baris1 = mysqli_fetch_assoc($result1)){
                  $jml_pdk=$jml_pdk+$baris1['qty_detbeli'];
                  $tot_jum=$tot_jum+$baris1['total_jumlah_detbeli'];
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