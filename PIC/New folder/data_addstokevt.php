
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
              <a href="#" class="btn btn-primary" id="addpro">              
                <i class="fas fa-plus"></i> Tambah Produk    
              </a>
            </div>  

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Produk</th>
										  <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php      
	    include "../db_proses/koneksi.php";
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $nota = $_GET['nota'];
      $evt = $_GET['evt'];
      $bayar=0;

      $query="SELECT * FROM detail_beli_event INNER JOIN beli_event ON beli_event.id_beli_event=detail_beli_event.nota_detbelev 
      INNER JOIN produk ON produk.id_produk=detail_beli_event.produk_detbelev 	
      INNER JOIN harga_produk ON harga_produk.id_harga=detail_beli_event.harga_detbelev 
      WHERE beli_event.id_beli_event='$nota'";
      $result = mysqli_query($kon, $query);
        
      while($baris = mysqli_fetch_assoc($result)){
        $bayar=$bayar+$baris['total_jumlah_detbelev'];
    ?>
                    <tr>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo rupiah($baris['total_jumlah_detbelev']/$baris['qty_detbelev']); ?></td>
                      <td><?php echo $baris['qty_detbelev']; ?></td>    
                      <td><?php echo rupiah($baris['total_jumlah_detbelev']); ?></td>                   
                      <td>
                        <a href="#" id="hapus" class="btn btn-small text-danger" data-nota="<?php echo $nota; ?>" data-pdk="<?php echo $baris['id_produk']; ?>"><i class="fas fa-trash"></i> Hapus</a>
                      </td>
                    </tr>              
    <?php
      }
    ?>             
                  </tbody><tfoot>
                    <tr>
                      <th colspan="3">Total Bayar</th>
                      <th><?php echo rupiah($bayar); ?></th>
										  <th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <a href="#ModalApp" class="open-ModalApp btn btn-success btn-small-block" data-idnota="<?php echo $nota; ?>" data-tot="<?php echo $bayar; ?>" data-toggle="modal">Order</a>
              <a href="#" class="btn btn-danger btn-small-block" data-nota="<?php echo $nota; ?>" id="batal">Batal</a>
            </div>
          </div>