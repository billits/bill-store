
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
              <a href="#" class="btn btn-primary" data-target="#ModalAddOffice" data-toggle="modal">               
                <i class="fas fa-plus"></i> Tambah Data Office   
              </a>
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Office</th>
                      <th>Nama Office</th>
										  <th>kota</th>
                      <th>Region</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Office</th>
                      <th>Nama Office</th>
										  <th>kota</th>
                      <th>Region</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      $query = "SELECT * FROM tb_office INNER JOIN tb_region ON tb_region.id_region=tb_office.region_office";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['id_office']; ?></td>
                      <td><?php echo $baris['nama_office']; ?></td>
                      <td><?php echo $baris['kota_office']; ?></td>
                      <td><?php echo $baris['nama_region']; ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit_off" data-id="<?php echo $baris['id_office']; ?>"><i class="fas fa-edit"></i> Edit </a>
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

          