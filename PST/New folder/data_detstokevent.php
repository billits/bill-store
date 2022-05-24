
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
              <a href="#" class="btn btn-primary" id="addstok" data-et="<?php echo $_GET['evt'] ?>">              
                <i class="fas fa-plus"></i> Tambah Stok Produk <?php echo $_GET['evt'] ?>
              </a>
            </div>  

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>kategori Produk</th>
                      <th>Jumlah Produk</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
                      <th>kategori Produk</th>
                      <th>Jumlah Produk</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      
      $kantor = $_COOKIE['id_office'];
      $evt = $_GET['evt'];
      $query="SELECT * FROM gudang INNER JOIN produk ON produk.id_produk=gudang.kode_produk_gudang 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
      WHERE gudang.kode_office_gudang='$kantor' AND gudang.event_gudang='$evt'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['kode_produk_gudang']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $baris['nama_kategori']; ?></td>
                      <td><?php echo $baris['jml_produk_gudang']; ?></td> 
                    </tr>              
    <?php
      }
  
      $query1="SELECT * FROM produk INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk WHERE produk.kategori_produk='PKT'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                  <tr>
                    <td><?php echo $baris1['id_produk']; ?></td>
                    <td><?php echo $baris1['nama_produk']; ?></td>
                    <td><?php echo $baris1['nama_kategori']; ?></td>
                    <td>~</td> 
                  </tr>              
  <?php
    }
  ?>             
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <a href="#" class="btn btn-danger" id="kembali">              
                Kembali
              </a>
            </div> 