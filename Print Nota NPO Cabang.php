<?php
  include "db_proses/koneksi.php";
  
  $nota = $_REQUEST['nota'];   

  $sqlre= "SELECT * FROM tb_po INNER JOIN tb_staff ON tb_staff.kode_staff=tb_po.staff_po INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff WHERE tb_po.id_po='$nota'";
	$resultre = mysqli_query($kon,$sqlre);
  $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
  $supply = $rowre['supplier_po'];

  $sql= "SELECT * FROM tb_staff INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff WHERE tb_staff.kode_staff='$supply'";
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
        <img src="img/Logo bill full HP.png" width="145" height="45"><br>
        Billionaires Indonesia <br>
        <font face="verdana" size="5">Purchasing Order</font><br><br>
      </div>
      <table width="100%">
        <tr>
          <td>
            <table>
              <tr><td>No.Order</td><td>:</td><td><?php echo $nota; ?></td>
              <tr><td>Tanggal</td><td>:</td><td><?php echo date("d-m-Y H:i:s", strtotime($rowre['tgl_po'])); ?></td>
              <tr><td>Cabang</td><td>:</td><td><?php echo $rowre['nama_office']; ?></td>
            </table>
          </td>
          <td>
            <table>
              <tr><td>Keterangan</td><td>:</td><td><?php echo $rowre['keterangan_po']; ?></td>
              <tr><td>Status PO</td><td>:</td><td><?php echo $rowre['status_po']; ?></td>
            </table>
          </td>
        </tr>
      </table>
      
      <!-- <?php echo "No.Order : ".$nota."<br>  
      Tanggal : ".date("d-m-Y H:i:s", strtotime($rowre['tgl_po']))."<br>
      Supplier  : ".$row['nama_staff']." - ".$row['nama_office']."<br>
      Keterangan : ".$rowre['keterangan_po']; ?> -->

    </p>

    <table width="100%" border="1" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;">
      <tr>
        <th width="7%" scope="col">Qty</th>
        <th width="18%" scope="col">Kode</th>
        <th width="34%" scope="col">Produk</th>
        <th width="15%" scope="col">Price</th>
        <th width="20%" scope="col">SubTotal</th>
      </tr>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;
      $query2="SELECT * FROM tb_detail_po INNER JOIN tb_po ON tb_po.id_po=tb_detail_po.nota_detpo 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_po.produk_detpo 
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_po.harga_detpo 
      WHERE tb_po.id_po='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $bayar=$bayar+$baris2['total_jumlah_detpo'];
        $produk=$baris2['id_produk'];
        $totju=$baris2['total_po'];
        
    ?>
      <tr>
        <td align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['qty_detpo']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['id_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['nama_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['harga_harian']); ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['total_jumlah_detpo']); ?></td>
      </tr>
    <?php
      }
    ?>  
      <tr>
        <td colspan="4" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><b>Total<b></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"> <?php echo rupiah($rowre['total_po']); ?> </td>
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
        <th width="50%" scope="col" align="center"><font size="-1"><?php echo $rowre['nama_staff']." - ".$rowre['nama_office']; ?></font></th>
      </tr>
    </table>

    <script>
      window.print();
    </script>
    </font>
  </body>
</html>
