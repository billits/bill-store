<?php
  include "db_proses/koneksi.php";
  
  $nota = $_REQUEST['nota'];   

  $sqlre= "SELECT * FROM temp_beli INNER JOIN pegawai ON pegawai.id_pegawai=temp_beli.staff_tbeli INNER JOIN office ON office.id_office=pegawai.office_pegawai WHERE temp_beli.id_tbeli='$nota'";
	$resultre = mysqli_query($kon,$sqlre);
  $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
  $supply = $rowre['supplier_tbeli'];

  $sql= "SELECT * FROM pegawai INNER JOIN office ON office.id_office=pegawai.office_pegawai WHERE pegawai.id_pegawai='$supply'";
	$result = mysqli_query($kon,$sql);
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    

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
  <font face="verdana" size="-2">
    <p>
      <div align="center">
        <img src="Logo bill full HP.png" width="145" height="45"><br>
        Billionaires Indonesia <br>
        <font face="verdana" size="5">Bukti Terima Barang</font><br><br>
      </div>
      <table width="100%">
        <tr>
          <td>
            <table>
              <tr><td>No.Order</td><td>:</td><td><?php echo $nota; ?></td>
              <tr><td>Tanggal</td><td>:</td><td><?php echo date("d-m-Y H:i:s", strtotime($rowre['tgl_tbeli'])); ?></td>
              <tr><td>Cabang</td><td>:</td><td><?php echo $rowre['nama_pegawai']." - ".$rowre['nama_office']; ?></td>
            </table>
          </td>
          <td>
            <table>
              <tr><td>Supplier</td><td>:</td><td><?php echo $row['nama_pegawai']." - ".$row['nama_office']; ?></td>
              <tr><td>Keterangan</td><td>:</td><td><?php echo $rowre['keterangan_tbeli']; ?></td>
              <tr><td>Status PO</td><td>:</td><td><?php echo $rowre['status_tbeli']; ?></td>
            </table>
          </td>
        </tr>
      </table>
      
      <!-- <?php echo "No.Order : ".$nota."<br>  
      Tanggal : ".date("d-m-Y H:i:s", strtotime($rowre['tgl_tbeli']))."<br>
      Supplier  : ".$row['nama_pegawai']." - ".$row['nama_office']."<br>
      Keterangan : ".$rowre['keterangan_tbeli']; ?> -->

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
      $query2="SELECT * FROM temp_detail_beli INNER JOIN temp_beli ON temp_beli.id_tbeli=temp_detail_beli.nota_tdetbeli 
      INNER JOIN produk ON produk.id_produk=temp_detail_beli.produk_tdetbeli 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
      INNER JOIN harga_produk ON harga_produk.id_harga=temp_detail_beli.harga_tdetbeli 
      WHERE temp_beli.id_tbeli='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $bayar=$bayar+$baris2['total_jumlah_tdetbeli'];
        $produk=$baris2['id_produk'];
        $totju=$baris2['total_tbeli'];
        
    ?>
      <tr>
        <td align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['qty_tdetbeli']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['id_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['nama_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['harga_harian']); ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['diskon_tdetbeli']."%"; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['total_jumlah_tdetbeli']); ?></td>
      </tr>
    <?php
      }
    ?>  
      <tr>
        <td colspan="5" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><b>Total<b></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"> <?php echo rupiah($rowre['total_tbeli']); ?> </td>
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
    </font>
  </body>
</html>
