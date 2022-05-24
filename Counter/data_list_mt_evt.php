
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
            List Manual Transaksi Event <?php echo $_COOKIE['office_bill']; ?>
            </div> 
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Tanggal</th>
										  <th>Total</th>
                      <th>Status</th>
                      <th>Customer</th>
                      <th>Counter</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode</th>
                      <th>Tanggal</th>
										  <th>Total</th>
                      <th>Status</th>
                      <th>Customer</th>
                      <th>Counter</th>
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
      $ct=0;
      
      $query="SELECT * FROM tb_man_trans INNER JOIN tb_staff ON tb_staff.kode_staff=tb_man_trans.counter_mt
      WHERE tb_man_trans.kantor_mt='$kantor' AND tb_man_trans.total_mt!=0 AND tb_man_trans.manual_mt=0 AND tb_man_trans.acara_mt!='OFFICE'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        if ($baris['status_mt']=='PENDING'||$baris['status_mt']=='CANCEL'){
          $ct=$ct+1;
        }
    ?>
                    <tr>
                      <td><?php echo $baris['id_mt']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_order_mt'])); ?></td>
                      <td><?php echo rupiah($baris['total_mt']); ?></td>
                      <td><?php echo $baris['status_mt']; ?></td>
                      <td><?php echo $baris['cs_mt']; ?></td>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris['id_mt']; ?>" 
                        data-ct="<?php echo $ct; ?>"> Detail</a>
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

          