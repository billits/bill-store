    <?php
	    include "../db_proses/koneksi.php";
      $nota = $_REQUEST['id'];      

      $query="SELECT * FROM beli_event 
      INNER JOIN pegawai ON pegawai.id_pegawai=beli_event.staff_beli_event 
      INNER JOIN detail_events ON detail_events.id_det_event=beli_event.event_beli_event 
      INNER JOIN office ON office.id_office=pegawai.office_pegawai  
      WHERE beli_event.id_beli_event='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $supp =  $baris['supplier_beli_event'];

        $queryq = "SELECT * FROM pegawai INNER JOIN office ON office.id_office=pegawai.office_pegawai WHERE pegawai.id_pegawai='$supp'";
	      $resultq = mysqli_query($kon, $queryq);
        $barisq = mysqli_fetch_array($resultq,MYSQLI_ASSOC);
    ?>
          <h1>Purchase Order</h1>
          <hr>
          <table width="100%">
            <tr>
              <td>
                <table>
                  <tr>
                    <td><span><b>No Order</b></span></td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php echo $baris['id_beli_event']; ?></span></td>
                  </tr>
                  <tr>
                    <td><span><b>Tanggal Order </b></span></td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php $tgl=date("d-m-Y H:i:s",strtotime ($baris['tgl_beli_event'])); echo $tgl; ?></span></td>
                  </tr>       
                  <tr>
                    <td><span><b>Cabang</b></span></td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php echo $baris['nama_pegawai']." - ".$baris['nama_office']; ?></span></td>
                  </tr>
                  <tr>
                    <td> <span><b>Keterangan</b></span> </td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php echo $baris['keterangan_beli_event']; ?></span></td>
                  </tr>       
                </table>
              </td>
      <?php
        if ($baris['stat_beli_event']!="REQUEST"){
      ?>
              <td>
              <table>
                  <tr>
                    <td><span><b>Event</b></span></td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php echo $baris['nama_det_event']; ?></span></td>
                  </tr>  
                  <tr>
                    <td><span><b>Status Order</b></span></td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php echo $baris['stat_beli_event']; ?></span></td>
                  </tr>     
                  <tr>
                    <td><span><b>Supplier</b></span></td>
                    <td><span><b> : </b></span></td>
                    <td><span><?php echo $barisq['nama_pegawai']; ?></span></td>
                  </tr>     
                </table>
              </td>
      <?php
        }
      ?>
            </tr>
          </table>
          
      <?php
        }
      ?>   
          <br>
          <table class="table table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Kode</th>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>SubTotal</th>
              </tr>
            </thead>
            <tbody>
      <?php  
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;

      $query1="SELECT * FROM detail_beli_event INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev 
      INNER JOIN produk ON produk.id_produk=detail_beli_event.produk_detbelev 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
      INNER JOIN harga_produk ON harga_produk.id_harga=detail_beli_event.harga_detbelev 
      WHERE beli_event.id_beli_event='$nota'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
        $bayar=$bayar+$baris1['total_jumlah_detbelev'];
      ?>
            <tr>
              <td><?php echo $baris1['id_produk']; ?></td>
              <td><?php echo $baris1['nama_produk']; ?></td>
              <td><?php echo $baris1['qty_detbelev']; ?></td>
              <td><?php echo rupiah($baris1['harga_harian']); ?></td>
              <td><?php echo rupiah($baris1['total_jumlah_detbelev']); ?></td>
            </tr>
      <?php
        }
      ?>          
              <tfoot>
                <tr>
                  <th colspan="4" style="text-align: right;">Total Bayar</th>
                  <th><?php echo rupiah($bayar); ?></th>
                </tr>
              </tfoot>
            </tbody>
          </table>
          <br><br><br>
          <div class="card mb-3">
            <div class="card-header">      
                <a href="#" class="btn btn-success" id="cetak" data-id="<?php echo $nota; ?>">Cetak</a>
                <a href="#" class="btn btn-danger" id="kembali" >Kembali</a>
            </div>
          </div>