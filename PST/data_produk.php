
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
              <a href="#" class="btn btn-primary" data-target="#ModalAdd" data-toggle="modal">               
                <i class="fas fa-plus"></i> Tambah Data Produk   
              </a>
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Nama</th>
										  <th>Kategori</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode</th>
                      <th>Nama</th>
										  <th>Kategori</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";

      $query = "SELECT * FROM tb_produk INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk";
      $result = mysqli_query($kon, $query);
      
      while($data = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $data['id_produk']; ?></td>
                      <td><?php echo $data['nama_produk']; ?></td>
                      <td><?php echo strtoupper($data['nama_kategori']); ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit" data-id="<?php echo $data['id_produk']; ?>"><i class="fas fa-edit"></i> Edit</a>
                        <a href="#" id="detail" class="btn btn-small text-success" data-id="<?php echo $data['id_produk']; ?>"><i class="fa fa-info"></i> Detail</a>
                        <a href="#" id="setharga" class="btn btn-small text-warning" data-id="<?php echo $data['id_produk']; ?>"><i class="fa fa-tag"></i> Harga</a>
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

          