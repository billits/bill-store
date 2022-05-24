<?php
  include "db_proses/koneksi.php";
  
  $nota = $_REQUEST['nota'];   

  $sqlre= "SELECT * FROM beli_event INNER JOIN pegawai ON pegawai.id_pegawai=beli_event.staff_beli_event 
  INNER JOIN office ON office.id_office=pegawai.office_pegawai 
  INNER JOIN detail_events ON detail_events.id_det_event=beli_event.event_beli_event 
  WHERE beli_event.id_beli_event='$nota'";
	$resultre = mysqli_query($kon,$sqlre);
  $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);    

?>

<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html/css; charset=utf-8" />   
    <meta name='description' content='Billionaires Store'>
    <meta name='author' content='KiiGeeks'>
    <meta name='keyword' content='Billionaires Store'>
    <link rel='shortcut icon' href='img/favcon.png'>
    <title><?php echo $nota; ?></title>
  </head>

  <body>
    <p>
      <div align="center">
        <img src="Logo bill full HP.png" width="145" height="45"><br>
        Billionaires Indonesia <br>
        <b><font size="5">Purchasing Order</font></b><br><br>
      </div>
      <table>
        <tr><td>No.Order</td><td>:</td><td><?php echo $nota; ?></td>
        <tr><td>Tanggal</td><td>:</td><td><?php echo date("d-m-Y H:i:s", strtotime($rowre['tgl_beli_event'])); ?></td>
        <tr><td>Staff</td><td>:</td><td><?php echo $rowre['nama_pegawai']." - ".$rowre['nama_office']; ?></td>
        <tr><td>Event</td><td>:</td><td><?php echo $rowre['nama_det_event']; ?></td>
        <tr><td>Keterangan</td><td>:</td><td><?php echo $rowre['keterangan_beli_event']; ?></td>
      </table>

    </p>

    <table width="100%" border="1" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;">
      <tr>
        <th width="7%" scope="col">Qty</th>
        <th width="18%" scope="col">Kode Produk</th>
        <th width="34%" scope="col">Nama Produk</th>
        <th width="15%" scope="col">Price</th>
        <th width="6%" scope="col">Disc.</th>
        <th width="20%" scope="col">SubTotal</th>
      </tr>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;
      $query2="SELECT * FROM detail_beli_event INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev 
      INNER JOIN produk ON produk.id_produk=detail_beli_event.produk_detbelev	 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
      INNER JOIN harga_produk ON harga_produk.id_harga=detail_beli_event.harga_detbelev 
      WHERE beli_event.id_beli_event='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $bayar=$bayar+$baris2['total_jumlah_detbelev'];
        $produk=$baris2['id_produk'];
        $totju=$baris2['total_beli_event'];
        
    ?>
      <tr>
        <td align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['qty_detbelev']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['id_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['nama_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['harga_harian']); ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['diskon_detbelev']."%"; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['total_jumlah_detbelev']); ?></td>
      </tr>
    <?php
      }
    ?>  
      <tr>
        <td colspan="5" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><b>Total<b></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"> <?php echo rupiah($rowre['total_beli_event']); ?> </td>
      </tr>
    </table>
    <br>
    <table width="50%" border="0" align="right">
      <tr>
        <th width="50%" scope="col" align="center"><font size="-1">Menyetujui</font> </th>
      </tr>
    </table>
    <br><br><br><br>
    <table width="50%" border="0" align="right">
      <tr>
        <th width="50%" scope="col" align="center"><font size="-1"><?php echo $rowre['nama_pegawai']." - ".$rowre['nama_office']; ?></font></th>
      </tr>
    </table>

    <script>
      window.print();
    </script>
  </body>
</html>
