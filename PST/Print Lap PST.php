<?php

  include "../db_proses/koneksi.php";
  
  $kantor = $_COOKIE['office_bill'];      

  function rupiah($angka){
    $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
    return $hasil_rupiah;
  }

  $tgl_start = $_GET['tgl_start'];
  $tgl_end = $_GET['tgl_end'];

  $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
  $tgl_temp=date('Y-m-d', strtotime($tgl_end));
  $tgl_selesai = $tgl_temp." 23:59:59";

  $totju=0;

?>
  <head>
    <meta http-equiv="Content-Type" content="text/html/css; charset=utf-8" />   
    <meta name='description' content='Billionaires Store'>
    <meta name='author' content='Billionaires IT'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='../img/favcon.png'>
    <title>Laporan Keseluruhan Pusat </title>
  </head>

            <div>
              Laporan Keseluruhan <?php echo $_COOKIE['office_bill']; ?> <br>
              Periode <?php echo $tgl_start.' - '.$tgl_end; ?> <br>
            </div> <br>

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
          $query1="SELECT * FROM tb_beli 
          WHERE kantor_beli='$kantor' AND event_beli='OFFICE' AND tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
          $result1 = mysqli_query($kon, $query1);
          while($baris1 = mysqli_fetch_assoc($result1)){
            $tmp_nota=$baris1['id_beli'];
    ?>
                    
                    <tr>
                      <td style="vertical-align:top"><?php echo date('d-m-Y H:i:s', strtotime($baris1['tgl_beli'])); ?></td>
                      <td><?php echo $baris1['id_beli']." [BTB Pusat - IN] - ".$baris1['keterangan_beli']; ?>
                        <table>
                          <?php
                            $query1a="SELECT * FROM tb_detail_beli INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli.produk_detbeli
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
                              <td><?php echo rupiah($baris1a['total_jumlah_detbeli']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                          </table>
                        </td>
                        <td><?php echo rupiah($baris1['total_beli']); ?></td>
                    </tr>    
                    
    <?php
               }
    ?>          
    <?php
        $query3="SELECT * FROM tb_beli 
        WHERE kantor_beli!='$kantor' AND event_beli='OFFICE' AND tgl_beli BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
        $result3 = mysqli_query($kon, $query3);
        while($baris3 = mysqli_fetch_assoc($result3)){
          $tmp_nota3=$baris3['id_beli'];
    ?>
                  
                  <tr>
                    <td style="vertical-align:top"><?php echo date('d-m-Y H:i:s', strtotime($baris3['tgl_beli'])); ?></td>
                    <td><?php echo $baris3['id_beli']." [KONSI CABANG - OUT] - ".$baris3['keterangan_beli']; ?>
                      <table>
                        <?php
                          $query3a="SELECT * FROM tb_detail_beli INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli.produk_detbeli
                          INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli.harga_detbeli
                          WHERE tb_detail_beli.nota_detbeli='$tmp_nota3'";
            
                          $result3a = mysqli_query($kon, $query3a);
                          while($baris3a = mysqli_fetch_assoc($result3a)){
                            
                        ?>
                          <tr>
                            <td><?php echo $baris3a['produk_detbeli']; ?></td>
                            <td><?php echo $baris3a['nama_produk']; ?></td>
                            <td><?php echo $baris3a['qty_detbeli']; ?></td>
                            <td><?php echo "@".rupiah($baris3a['harga_harian']); ?></td>
                            <td><?php echo rupiah($baris3a['total_jumlah_detbeli']); ?></td>
                          </tr>
                        <?php
                          }
                        ?>
                        </table>
                      </td>
                      <td><?php echo rupiah($baris3['total_beli']); ?></td>
                  </tr>    
                  
    <?php
            }
    ?>         
    <?php
          $query2="SELECT * FROM tb_free_produk 
          WHERE kantor_fp='$kantor' AND event_fp='OFFICE' AND waktu_fp BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
          $result2 = mysqli_query($kon, $query2);
          while($baris2 = mysqli_fetch_assoc($result2)){
            $tmp_nota2=$baris2['id_fp'];
    ?>
                    
                    <tr>
                      <td style="vertical-align:top"><?php echo date('d-m-Y H:i:s', strtotime($baris2['waktu_fp'])); ?></td>
                      <td><?php echo $baris2['id_fp']." [Free Produk - OUT] - ".$baris2['keterangan_fp']; ?>
                        <table>
                          <?php
                            $query2a="SELECT * FROM tb_detail_fp INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_fp.produk_detfp
                            INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_fp.harga_detfp
                            WHERE tb_detail_fp.id_detfp='$tmp_nota2'";
              
                            $result2a = mysqli_query($kon, $query2a);
                            while($baris2a = mysqli_fetch_assoc($result2a)){
                              
                          ?>
                            <tr>
                              <td><?php echo $baris2a['produk_detfp']; ?></td>
                              <td><?php echo $baris2a['nama_produk']; ?></td>
                              <td><?php echo $baris2a['jum_detfp']; ?></td>
                              <td><?php echo "@".rupiah($baris2a['harga_harian']); ?></td>
                              <td><?php echo rupiah($baris2a['totjum_detfp']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                          </table>
                        </td>
                        <td><?php echo rupiah($baris2['total_fp']); ?></td>
                    </tr>    
                    
    <?php
               }
    ?>     
    <?php
          $query4="SELECT * FROM tb_retur_event 
          WHERE kantor_returevt='$kantor' AND event_returevt='OFFICE' AND waktu_returevt BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
          $result4 = mysqli_query($kon, $query4);
          while($baris4 = mysqli_fetch_assoc($result4)){
            $tmp_nota4=$baris4['id_returevt'];
    ?>
                    
                    <tr>
                      <td style="vertical-align:top"><?php echo date('d-m-Y H:i:s', strtotime($baris4['waktu_returevt'])); ?></td>
                      <td><?php echo $baris4['id_returevt']." [Retur Supplier - OUT] - ".$baris4['keterangan_returevt']; ?>
                        <table>
                          <?php
                            $query4a="SELECT * FROM tb_detail_retur_event INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_retur_event.produk_detretevt
                            INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_retur_event.harga_detretevt
                            WHERE tb_detail_retur_event.id_detretevt='$tmp_nota4'";
              
                            $result4a = mysqli_query($kon, $query4a);
                            while($baris4a = mysqli_fetch_assoc($result4a)){
                              
                          ?>
                            <tr>
                              <td><?php echo $baris4a['produk_detretevt']; ?></td>
                              <td><?php echo $baris4a['nama_produk']; ?></td>
                              <td><?php echo $baris4a['jumret_detretevt']; ?></td>
                              <td><?php echo "@".rupiah($baris4a['harga_harian']); ?></td>
                              <td><?php echo rupiah($baris4a['totjum_detretevt']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                          </table>
                        </td>
                        <td><?php echo rupiah($baris4['total_returevt']); ?></td>
                    </tr>    
                    
    <?php
               }
    ?>     
    <?php
          $query5="SELECT * FROM tb_beli_event INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_beli_event.event_beli_event
          INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
          WHERE tb_beli_event.kantor_beli_event!='$kantor' AND tb_beli_event.stat_beli_event != 'REQUEST' AND tb_beli_event.tgl_beli_event BETWEEN '$tgl_mulai' AND '$tgl_selesai'";                  
          $result5 = mysqli_query($kon, $query5);
          while($baris5 = mysqli_fetch_assoc($result5)){
            if ($baris5['level_events']=='BESAR'){            
              $tmp_nota5=$baris5['id_beli_event'];
    ?>
                    
                    <tr>
                      <td style="vertical-align:top"><?php echo date('d-m-Y H:i:s', strtotime($baris5['tgl_beli_event'])); ?></td>
                      <td><?php echo $baris5['id_beli_event']." [Konsi Event - OUT] - ".$baris5['keterangan_beli_event']; ?>
                        <table>
                          <?php
                            $query5a="SELECT * FROM tb_detail_beli_event INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev
                            INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev
                            WHERE tb_detail_beli_event.nota_detbelev='$tmp_nota5'";
              
                            $result5a = mysqli_query($kon, $query5a);
                            while($baris5a = mysqli_fetch_assoc($result5a)){
                              
                          ?>
                            <tr>
                              <td><?php echo $baris5a['produk_detbelev']; ?></td>
                              <td><?php echo $baris5a['nama_produk']; ?></td>
                              <td><?php echo $baris5a['qty_detbelev']; ?></td>
                              <td><?php echo "@".rupiah($baris5a['harga_harian']); ?></td>
                              <td><?php echo rupiah($baris5a['total_jumlah_detbelev']); ?></td>
                            </tr>
                          <?php
                            }
                          ?>
                          </table>
                        </td>
                        <td><?php echo rupiah($baris5['total_beli_event']); ?></td>
                    </tr>    
                    
    <?php
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