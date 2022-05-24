
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
              List Paket Produk   
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Paket</th>
                      <th>Nama Paket</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Paket</th>
                      <th>Nama Paket</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";

      $query = "SELECT * FROM tb_produk WHERE kategori_produk='PKT'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td>
                        <a href="#" id="detail" class="btn btn-small text-success" data-id="<?php echo $baris['id_produk']; ?>"><i class="fa fa-info"></i> Detail Paket</a>
                        <a href="#" id="setharga" class="btn btn-small text-warning" data-id="<?php echo $baris['id_produk']; ?>"><i class="fa fa-tag"></i> Set Produk</a>
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

          