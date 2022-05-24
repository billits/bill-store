    
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

      $org = $_COOKIE['idstaff_bill'];
      $kantr = $_COOKIE['office_bill'];
      $nota = $_REQUEST['id'];       
      $pi = $_REQUEST['pi'];   
      $tgl=0;

      $query="SELECT * FROM tb_beli_event INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli_event.supplier_beli_event 
      INNER JOIN tb_office ON tb_office.id_office=tb_beli_event.kantor_beli_event 
      INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_beli_event.event_beli_event
      WHERE tb_beli_event.id_beli_event='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $tgl=date("Y-m-d H:i:s", strtotime($baris['tgl_beli_event']));
    ?>
              <table width=100%>
          <tr>
            <td>
              <table>
                <tr>
                  <th>ID Invoice </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_beli_event']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal Order</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_beli_event'])); ?></td>
                </tr>
                <tr>
                  <th>Supplier </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']." - ".$baris['nama_office']; ?></td>
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
            </td>
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
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;
      $query2="SELECT * FROM tb_detail_beli_event INNER JOIN tb_beli_event ON tb_beli_event.id_beli_event=tb_detail_beli_event.nota_detbelev 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli_event.produk_detbelev 
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli_event.harga_detbelev 
      WHERE tb_beli_event.id_beli_event='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris1 = mysqli_fetch_assoc($result2)){
        $evn=$baris1['event_beli_event'];
        $totju=$baris1['total_beli_event'];
        
    ?>
                    <tr>
                      <td><?php echo $baris1['id_produk']; ?></td>
                      <td><?php echo $baris1['nama_produk']; ?></td>
                      <td><?php echo rupiah($baris1['harga_harian']); ?></td>
                      <td><?php echo $baris1['qty_detbelev']; ?></td>
                      <td><?php echo rupiah($baris1['total_jumlah_detbelev']); ?></td>
                    </tr>    
                    
    <?php
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
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <form id="form-app" method="post">
                  <input type="hidden" name="nota" value="<?php echo $nota; ?>">
                  <input type="hidden" name="evn" value="<?php echo $evn; ?>">
                  <input type="hidden" name="off" value="<?php echo $kantr; ?>">
                  <input type="hidden" name="staff" value="<?php echo $org; ?>">
              <?php
                if ($pi==1){
              ?>
                  <button type="submit" class="btn btn-success" name="aprov" id="aprov">Approve</button>      
              <?php
                }else{}
              ?>
                  <button type="submit" class="btn btn-primary" data-id="<?php echo $nota; ?>" name="cetak" id="cetak">Cetak</button>       
                  <button type="submit" class="btn btn-danger" name="kembali" id="kembali" >Kembali</button>  
              </form> 
            </div>
          </div>

          
