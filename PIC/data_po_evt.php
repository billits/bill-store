
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
                      <th>Kode</th>
                      <th>Tanggal</th>
										  <th>Total</th>
                      <th>Supplier</th>
                      <th>Event</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode</th>
                      <th>Tanggal</th>
										  <th>Total</th>
                      <th>Supplier</th>
                      <th>Event</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      
      $kantor = $_COOKIE['office_bill'];      

      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $seq=0;
      
      $query="SELECT * FROM tb_beli_event INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli_event.supplier_beli_event 
      INNER JOIN tb_office ON tb_office.id_office=tb_beli_event.kantor_beli_event
      INNER JOIN tb_detail_events ON tb_detail_events.id_det_event=tb_beli_event.event_beli_event
      WHERE tb_beli_event.stat_beli_event='SUCCESS' AND tb_beli_event.kantor_beli_event='$kantor'";
      $result = mysqli_query($kon, $query);
      while($baris = mysqli_fetch_assoc($result)){
        $seq++;
    ?>
                    <tr>
                      <td><?php echo $baris['id_beli_event']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_beli_event'])); ?></td>
                      <td><?php echo rupiah($baris['total_beli_event']); ?></td>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td><?php echo $baris['nama_det_event']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris['id_beli_event']; ?>" data-pi="<?php echo $seq; ?>"> Detail</a>
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

          