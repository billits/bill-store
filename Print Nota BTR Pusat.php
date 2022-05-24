<?php
  include "db_proses/koneksi.php";
  
  $nota = $_REQUEST['nota'];   
	$kantor = $_COOKIE['office_bill'];  

  $sqlre= "SELECT * FROM tb_retur_event 
  INNER JOIN tb_staff ON tb_staff.kode_staff=tb_retur_event.staff_returevt 
  INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff 
  WHERE tb_retur_event.id_returevt='$nota'";
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
  <font face="verdana" size="-2">
    <p>
      <div align="center">
        <img src="img/Logo bill full HP.png" width="145" height="45"><br>
        Billionaires Indonesia <br>
        <font face="verdana" size="5">Retur</font><br><br>
      </div>
      <table width="100%">
        <tr>
          <td>
            <table>
              <tr><td>No.Order</td><td>:</td><td><?php echo $nota; ?></td>
              <tr><td>Tanggal</td><td>:</td><td><?php echo date("d-m-Y H:i:s", strtotime($rowre['waktu_returevt'])); ?></td>
              <!-- <tr><td>Retur</td><td>:</td><td><?php echo $kantor." Ke Pusat"; ?></td> -->
            </table>
          </td>
          <td>
            <table>
              <tr><td>Status</td><td>:</td><td><?php echo $rowre['status_returevt']; ?></td>
              <tr><td>Staff</td><td>:</td><td><?php echo $rowre['nama_staff']; ?></td>
              <tr><td>Keterangan</td><td>:</td><td><?php echo $rowre['keterangan_returevt']; ?></td>
            </table>
          </td>
        </tr>
      </table>

    </p>

    <table width="100%" border="1" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;">
      <tr>
        <th width="18%" scope="col">Kode Produk</th>
        <th width="34%" scope="col">Nama Produk</th>
        <th width="7%" scope="col">Qty</th>
        <th width="15%" scope="col">Price</th>
        <th width="20%" scope="col">SubTotal</th>
      </tr>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $satuan=0;
      $bayar=0;
      $query2="SELECT * FROM tb_detail_retur_event 
      INNER JOIN tb_retur_event ON tb_retur_event.id_returevt=tb_detail_retur_event.id_detretevt 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_retur_event.produk_detretevt 
      WHERE tb_retur_event.id_returevt='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $satuan=$baris2['totjum_detretevt']/$baris2['jumret_detretevt'];
        $bayar=$bayar+$baris2['totjum_detretevt'];
        
    ?>
      <tr>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['id_produk']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['nama_produk']; ?></td>
        <td align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo $baris2['jumret_detretevt']; ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($satuan); ?></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"><?php echo rupiah($baris2['totjum_detretevt']); ?></td>
      </tr>
    <?php
      }
    ?>  
      <tr>
        <td colspan="4" align="center" style="border:1px solid black; padding:5px; border-collapse: collapse;"><b>Total<b></td>
        <td style="border:1px solid black; padding:5px; border-collapse: collapse;"> <?php echo rupiah($bayar); ?> </td>
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
