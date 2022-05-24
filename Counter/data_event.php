
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
                <i class="fas fa-plus"></i> Pilih Events    
              </a>
            </div>      

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Event</th>
                      <th>Nama Event</th>
                      <th>Keterangan Event</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Event</th>
                      <th>Nama Event</th>
                      <th>Keterangan Event</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      session_start();
      include "../db_proses/koneksi.php";   
      $kantor=$_COOKIE["office_bill"];
      $query = "SELECT * FROM tb_detail_events INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event
      WHERE tb_detail_events.status_det_event='ON' AND tb_detail_events.office_det_event='$kantor'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['event_det_event']; ?></td>
                      <td><?php echo $baris['nama_det_event']; ?></td>
                      <td><?php echo $baris['keterangan_det_event']; ?></td>
                    </tr>              
    <?php
      }
    ?>             
                  </tbody>
                </table>
              </div>
            </div>
          </div>