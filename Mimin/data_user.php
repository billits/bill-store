
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
                      <th>Nama</th>
                      <th>Office</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Nama</th>
                      <th>Office</th>
                      <th>Active</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      $query = "SELECT * FROM tb_staff 
      INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff ";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $id=$baris['kode_staff'];
        
        $sqlre= "SELECT * FROM tb_akses WHERE staff_akses= '$id' AND status_akses='ADMIN' OR status_akses='SUPERADMIN'";
        $resultre = mysqli_query($kon,$sqlre);
        $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
        $countre = mysqli_num_rows($resultre);
        if($countre<1){
    ?>
                    <tr>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td><?php echo $baris['nama_office']; ?></td>
                      <td><?php echo $baris['active_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit" data-id="<?php echo $baris['kode_staff']; ?>"><i class="fas fa-edit"></i> Edit </a>
                        <a href="#" id="detail" class="btn btn-small text-success" data-id="<?php echo $baris['kode_staff']; ?>"><i class="fa fa-info"></i> Detail</a>
                        <a href="#" id="setakses" class="btn btn-small text-warning" data-id="<?php echo $baris['kode_staff']; ?>"><i class="fa fa-tag"></i> Akses</a>
                      </td>
                    </tr>              
    <?php
        }else{}
      }
    ?>             
                  </tbody>
                </table>
              </div>
            </div>
          </div>