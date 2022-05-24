
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
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Kategori Produk</th>
										  <th>Harga Produk</th>
										  <th>Stok Produk</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Kategori Produk</th>
										  <th>Harga Produk</th>
										  <th>Stok Produk</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $nota=$_GET['nota'];
      
      $region=$_COOKIE["region"];
      $off=$_COOKIE["id_office"];

      $sqlre= "SELECT * FROM jual INNER JOIN detail_events ON detail_events.id_det_event=jual.acara_jual WHERE jual.id_jual='$nota'";
      $resultre = mysqli_query($kon,$sqlre);
      $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);

      $temp = $rowre['event_det_event'];  

      $query = "SELECT * FROM gudang 
        INNER JOIN produk ON produk.id_produk=gudang.kode_produk_gudang 
        INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
        INNER JOIN harga_produk ON harga_produk.produk_harga=produk.id_produk 
        WHERE gudang.kode_office_gudang='$off' AND gudang.event_gudang='$temp' AND harga_produk.region_harga='$region' AND harga_produk.status_harga='ON'";

      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $baris['nama_kategori']; ?></td>
                      <td><?php echo rupiah($baris['harga_harian']); ?></td>
                      <?php
                        if ($baris['id_kategori']=="PKT"){
                      ?>
                        <td>~</td>
                      <?php
                        }else{
                      ?>
                        <td><?php echo $baris['jml_produk_gudang']; ?></td>
                      <?php
                        }
                      ?>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="jum" data-id="<?php echo $baris['id_produk']; ?>"><i class="fas fa-edit"></i> Pilih</a>
                      </td>
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
              <a href="#" class="btn btn-danger btn-small-block" id="kembali"> Kembali</a>
            </div>
          </div>

          