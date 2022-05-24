<?php
  include "db_proses/koneksi.php";
  
  $nota = $_REQUEST['nota'];    

  $sqlre= "SELECT * FROM tb_beli_event 
  INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli_event.staff_beli_event
  INNER JOIN tb_office ON tb_office.id_office=tb_beli_event.kantor_beli_event 
  WHERE tb_beli_event.id_beli_event='$nota'";
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
  <style>
    div.separo {
      -webkit-column-count: 3;
      -moz-column-count: 3;
      column-count: 3;
    }
  </style>
  <font face='sans serif' size='1'>
  <br><br><br><br><br><br><br><br>
    <div class='separo' align="center">
      <center><img src="img/Logo bill full HP.png" width="145" height="48"></center>
    </div>

    <div class='separo' align="center"> <font face='sans serif' size='1'> Billionaires Indonesia</font></div>
    <div class='separo' align="center"> <font face='sans serif' size='2'> KONSINYASI EVENT</font></div>
    <p>&nbsp;</p>
    <font face='arial' size='2'>No.Invoice : <?php echo $nota; ?> <br> </font>
    <font face='arial' size='2'>Keterangan  : <?php echo $rowre['keterangan_beli_event']; ?> </font>

    <p><table width="50%" border="0" align="left">
      <tr>
        <th width="30%"><u><font face='verdana' size='2'>Qty/Kode Produk</font></u></th>
        <th width="30%"><font face='verdana' size='2'><u>Price </font></u></th>
        <th width="6%"><font face='verdana' size='2'><u>Disc. </font></u></th>
        <th width="30%"><font face='verdana' size='2'><u>SubTotal </font></u></center></th>
      </tr>

  <?php
    function rupiah($angka){
      $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
      return $hasil_rupiah;
    }
    
    $bayar=0;
    $ct=0;
    $query2="SELECT * FROM tb_detail_beli_event INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev 
    INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev 
    INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
    INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev 
    WHERE tb_beli_event.id_beli_event='$nota'";
    $result2 = mysqli_query($kon, $query2);
      
    while($baris2 = mysqli_fetch_assoc($result2)){
      $ct++;
      $bayar=$bayar+$baris2['total_jumlah_detbelev'];
      $produk=$baris2['id_produk'];
      $vou=0;
      $totju=$baris2['total_beli_event'];
      $dibayar=0;
      $kembali=0;    
  ?>
      <tr>
        <td width="30%"><font face='verdana' size='2'><?php echo $baris2['id_produk']; ?><br>(<?php echo $baris2['qty_detbelev']; ?>)</font></td>
        <td width="35%"><font face='verdana' size='2'><?php echo $baris2['nama_produk']; ?><br>(<?php echo rupiah($baris2['harga_harian']); ?>)</font></td>
        <td width="6%"><font face='verdana' size='2'><?php echo $baris2['diskon_detbelev']."%"; ?></font></td>
        <td width="20%"><font face='verdana' size='2'><?php echo rupiah($baris2['total_jumlah_detbelev']); ?></font></td>
      </tr>
  
  <?php
    }
  ?>  
      
      <tr></tr><tr></tr><tr></tr>
      <tr>
        <th align="left"><font face='verdana' size='2'>Subtotal </font></th>
        <td colspan="3"><font face='verdana' size='2'> : <?php echo rupiah($bayar); ?></font></td>
      </tr>
      <tr>
        <th align="left"><font face='verdana' size='2'>Voucher </font></th>
        <td colspan="3"><font face='verdana' size='2'>  : <?php echo rupiah($vou); ?></font></td>
      </tr>
      <tr>
        <th align="left"><font face='verdana' size='2'>Total </font></th>
        <td colspan="3"><font face='verdana' size='2'> : <?php echo rupiah($totju); ?></font></td>
      </tr>
      <tr>
        <th align="left"><font face='verdana' size='2'>Total Bayar </font></th>
        <td colspan="3"><font face='verdana' size='2'> : <?php echo rupiah($dibayar); ?></font></td>
      </tr>
      <tr>
        <th align="left"><font face='verdana' size='2'>Kembali </font></th>
        <td colspan="3"><font face='verdana' size='2'> : <?php echo rupiah($kembali); ?></font></td>
      </tr> 
      <tr> <td>&nbsp; </td> </tr> 
      <tr> <td>&nbsp;</td> </tr> 
      <tr> <td>&nbsp;</td> </tr> 
      <tr>
        <td width="25%" colspan="2"><font face='verdana' size='2'>Dikeluarkan Oleh :  </td>
        <td width="25%" colspan="2"><font face='verdana' size='2'>Diterima Oleh :   </td>
      </tr>
      <tr>
        <td width="25%" colspan="2"><font face='verdana' size='2'><?php echo strtoupper($rowre['nama_staff']);	 ?> </td>
        <td width="25%" colspan="2"><font face='verdana' size='2'>  </td>
      </tr>
      <tr></tr> <tr></tr> <tr></tr> 
      <tr>
        <td width="25%" colspan="4"><font face='verdana' size='2'>Jenis Transaksi : <?php echo $rowre['jenis_beli_event']." - ".$rowre['cara_bayar_beli_event']; ?></td>
      </tr>
      <tr>
        <td width="25%" colspan="4"><font face='verdana' size='2'>Macam Barang : <?php echo $ct; ?></td>
      </tr>
      <tr>
        <td width="25%" colspan="4"><font face='verdana' size='2'>Tanggal dan Waktu : <?php echo date("d-m-Y H:i:s", strtotime($rowre['tgl_beli_event'])); ?>  </td>
      </tr>
      <tr>
        <td width="25%" colspan="4" align="center"><font face='verdana' size='2'>=== Terimakasih === </td>
      </tr>
    </table></p>
  </font>
  <script>
    window.print();
  </script>
</html>
