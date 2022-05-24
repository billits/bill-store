
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
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Kategori Produk</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Kategori Produk</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      $sumber = "http://localhost/BillServer/data_produk.php";
      $konten = file_get_contents($sumber);
      $json = json_decode($konten, true);
      
      for($a=0; $a < count($json); $a++)
      {
    ?>
                    <tr>
                      <td><?php echo $json[$a]['id_produk']; ?></td>
                      <td><?php echo $json[$a]['nama_produk']; ?></td>
                      <td><?php echo $json[$a]['nama_kategori']; ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit" data-id="<?php echo $json[$a]['id_produk']; ?>"><i class="fas fa-edit"></i> Edit Produk</a>
                        <a href="#" id="hapus" class="btn btn-small text-danger" data-id="<?php echo $json[$a]['id_produk']; ?>"><i class="fas fa-trash"></i> Hapus</a>
                        <a href="#" id="detail" class="btn btn-small text-success" data-id="<?php echo $json[$a]['id_produk']; ?>"><i class="fa fa-info"></i> Detail</a>
                        <a href="#" id="setharga" class="btn btn-small text-warning" data-id="<?php echo $json[$a]['id_produk']; ?>"><i class="fa fa-tag"></i> Set Harga</a>
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

          