
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
                <i class="fas fa-plus"></i> Tambah Data Detail Events    
              </a>
            </div>      

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Time</th>
                      <th>Event</th>
                      <th>Nama Event</th>
                      <!-- <th>Keterangan Event</th> -->
                      <th>Kantor Cabang</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Time</th>
                      <th>Event</th>
                      <th>Nama Event</th>
                      <!-- <th>Keterangan Event</th> -->
                      <th>Kantor Cabang</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      
      $query = "SELECT * FROM tb_detail_events INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event 
      INNER JOIN tb_office ON tb_office.id_office=tb_detail_events.office_det_event";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo date("d-m-Y H:i:s", strtotime($baris['time_det_event'])); ?></td>
                      <td><?php echo $baris['event_det_event']; ?></td>
                      <td><?php echo $baris['nama_det_event']; ?></td>
                      <!-- <td><?php echo $baris['keterangan_det_event']; ?></td> -->
                      <td><?php echo $baris['nama_office']; ?></td>
                      <td><?php echo $baris['status_det_event']; ?></td>
                      <td>
                        <a href="#" class="btn btn-small text-primary" id="edit" data-id="<?php echo $baris['id_det_event']; ?>"><i class="fas fa-edit"></i> Edit </a>
                        <a href="#" class="btn btn-small text-danger" id="down" data-id="<?php echo $baris['id_det_event']; ?>" data-nama="<?php echo $baris['nama_det_event']; ?>"><i class="fas fa-trash"></i> Nonaktifkan </a>
                        <a href="#" class="btn btn-small text-success" id="upkan" data-id="<?php echo $baris['id_det_event']; ?>" data-nama="<?php echo $baris['nama_det_event']; ?>"><i class="fas fa-check"></i> Aktifkan </a>
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