    
    <!-- Core plugin JavaScript-->
    <script src='../vendor/jquery-easing/jquery.easing.min.js'></script>

    <!-- Page level plugin JavaScript-->
    <script src='../vendor/chart.js/Chart.min.js'></script>
    <script src='../vendor/datatables/jquery.dataTables.js'></script>
    <script src='../vendor/datatables/dataTables.bootstrap4.js'></script>

    <!-- Custom scripts for all pages-->
    <script src='../js/sb-admin.min.js'></script>

    <!-- Demo scripts for this page-->
    <script src='../js/demo/datatables-demo.js'></script>
    <script src='../js/demo/chart-area-demo.js'></script>

    <div class="card mb-3">
      <div class="card-header">
<?php
	    include "../db_proses/koneksi.php";
      $nota = $_REQUEST['id'];      

      $query="SELECT * FROM tb_beli_event 
      INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli_event.staff_beli_event 
      INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_beli_event.event_beli_event  
      WHERE tb_beli_event.id_beli_event='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
              <table>
                <tr>
                  <th>Kode</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_beli_event']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_beli_event'])); ?></td>
                </tr>
                <tr>
                  <th>Staff </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']; ?></td>
                </tr>
                <tr>
                  <th>Event </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_det_event']; ?></td>
                </tr>
                <tr>
                  <th>Keterangan </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['keterangan_beli_event']; ?></td>
                </tr>
              </table>   
              
      <?php
        }
      ?>   
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

      $query1="SELECT * FROM tb_detail_beli_event INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev 	
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev 
      WHERE tb_beli_event.id_beli_event='$nota'";
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
              </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="4">Total Bayar</th>
                      <th><?php echo rupiah($bayar); ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
                
          <div class="card mb-3">
            <div class="card-header">      
                <a href="#" class="btn btn-success" id="cetak" data-id="<?php echo $nota; ?>">Cetak</a>
                <a href="#" class="btn btn-danger" id="kembali" >Kembali</a>
            </div>
          </div>