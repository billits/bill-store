
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
                      <th>Alamat</th>
                      <th>Telepon</th>
                      <th>Region</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Office</th>
                      <th>Nama Office</th>
										  <th>kota</th>
                      <th>Alamat</th>
                      <th>Telepon</th>
                      <th>Region</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      $sumber = "http://localhost/BillServer/data_office.php";
      $konten = file_get_contents($sumber);
      $json = json_decode($konten, true);
      
      for($a=0; $a < count($json); $a++)
      {
    ?>
                    <tr>
                      <td><?php echo $json[$a]['id_office']; ?></td>
                      <td><?php echo $json[$a]['nama_office']; ?></td>
                      <td><?php echo $json[$a]['kota_office']; ?></td>
                      <td><?php echo $json[$a]['alamat_office']; ?></td>
                      <td><?php echo $json[$a]['tlp_office']; ?></td>
                      <td><?php echo $json[$a]['nama_region']; ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit_off" data-id="<?php echo $json[$a]['id_office']; ?>"><i class="fas fa-edit"></i> Edit </a>
                        <a href="#" id="hapus_off" class="btn btn-small text-danger" data-id="<?php echo $json[$a]['id_office']; ?>"><i class="fas fa-trash"></i> Hapus</a>
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

          