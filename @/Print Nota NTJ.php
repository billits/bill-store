<?php
  include "db_proses/koneksi.php";
  
  $nota = $_REQUEST['nota'];    

  $sqlre= "SELECT * FROM jual 
  INNER JOIN pegawai ON pegawai.id_pegawai=jual.counter_jual 
  INNER JOIN office ON office.id_office=jual.kantor_jual 
  WHERE jual.id_jual='$nota'";
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
        Billionaires Indonesia
      </div><br>
      <?php echo "No.Invoice : ".$nota."<br> Customer  : ".$rowre['nama_customer']."<br> Telepon : ".$rowre['tlp_customer']."<br> Keterangan : ".$rowre['keterangan_jual']; ?>
    </p>
    

    <table width="100%" border="1" align="center">
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
      $query2="SELECT * FROM detail_jual INNER JOIN jual ON jual.id_jual=detail_jual.nota_detjual 
      INNER JOIN produk ON produk.id_produk=detail_jual.produk_detjual 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
      INNER JOIN harga_produk ON harga_produk.id_harga=detail_jual.harga_detjual 
      WHERE jual.id_jual='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $bayar=$bayar+$baris2['total_jumlah_detjual'];
        $produk=$baris2['id_produk'];
        $vou=$baris2['voucher_jual'];
        $totju=$baris2['total_jual'];
        $dibayar=$baris2['dibayar_jual'];
        $kembali=$baris2['kembalian_jual']
        
    ?>
      <tr>
        <td align="center"><?php echo $baris2['qty_detjual']; ?></td>
        <td><?php echo $baris2['id_produk']; ?></td>
        <td><?php echo $baris2['nama_produk']; ?></td>
        <td><?php echo rupiah($baris2['harga_harian']); ?></td>
        <td><?php echo $baris2['diskon_detjual']."%"; ?></td>
        <td><?php echo rupiah($baris2['total_jumlah_detjual']); ?></td>
      </tr>
    <?php
      }
    ?>  
    </table>
    <br>

    <table align="left">
      <tr>
        <td>Subtotal</td><td>:</td><td><?php echo rupiah($bayar); ?></td>
      </tr>
      <tr>
        <td>Voucher</td><td>:</td><td><?php echo rupiah($vou); ?></td>
      </tr>
      <tr>
        <td>Total</td><td>:</td><td><?php echo rupiah($totju); ?></td>
      </tr>
      <tr>
        <td>Dibayar</td><td>:</td><td><?php echo rupiah($dibayar); ?></td>
      </tr>
      <tr>
        <td>Kembali</td><td>:</td><td><?php echo rupiah($kembali); ?></td>
      </tr>
    </table>
    <br><br><br><br><br><br><br><br><br><br>
    
    <table width="100%" align="center">
      <tr>
        <th width="25%" scope="col">Dikeluarkan Oleh : <?php echo strtoupper($rowre['nama_pegawai']);	 ?></th>
        <th width="25%" scope="col">Diterima Oleh : </th>
      </tr>
    </table>
    

    <table align="left">
      <tr>
        <td>Jenis Transaksi</td><td>:</td><td><?php echo $rowre['jenis_jual']." - ".$rowre['cara_bayar_jual']; ?></td>
      </tr>
      <tr>
        <td>Tanggal dan Waktu</td><td>:</td><td><?php echo date("d-m-Y H:i:s", strtotime($rowre['tgl_order_jual'])); ?></td>
      </tr>
    </table>
    <br><br>

    <p><div align="center"><b>=== Terimakasih Atas Kunjungan Anda ===<b></div></p>
    


    

    <script>
      window.print();
    </script>
  </body>
</html>
