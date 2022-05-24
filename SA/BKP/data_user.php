
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
                <i class="fas fa-plus"></i> Tambah Data Pegawai    
              </a>
            </div>      

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Office</th>
                      <th>Telepon</th>
                      <th>Status</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Office</th>
                      <th>Telepon</th>
                      <th>Status</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      $sumber = "http://localhost/BillServer/data_user.php";
      $konten = file_get_contents($sumber);
      $json = json_decode($konten, true);
                      
      for($a=0; $a < count($json); $a++)
        {
    ?>
                    <tr>
                      <td><?php echo $json[$a]['id_pegawai']; ?></td>
                      <td><?php echo $json[$a]['nama_pegawai']; ?></td>
                      <td><?php echo $json[$a]['nama_office']; ?></td>
                      <td><?php echo $json[$a]['tlp_pegawai']; ?></td>
                      <td><?php echo $json[$a]['status_pegawai']; ?></td>
                      <td><?php echo $json[$a]['active_pegawai']; ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit" data-id="<?php echo $json[$a]['id_pegawai']; ?>"><i class="fas fa-edit"></i> Edit </a>
                        <a href="#" id="hapus" class="btn btn-small text-danger" data-id="<?php echo $json[$a]['id_pegawai']; ?>"><i class="fas fa-trash"></i> Hapus</a>
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