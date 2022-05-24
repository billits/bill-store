
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
                      <th>Kode Transaksi</th>
                      <th>Tanggal</th>
										  <th>Total Jumlah</th>
                      <th>Status</th>
                      <th>Customer</th>
                      <th>Counter</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Transaksi</th>
                      <th>Tanggal</th>
										  <th>Total Jumlah</th>
                      <th>Status</th>
                      <th>Customer</th>
                      <th>Counter</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
	    session_start();
      $kantor = $_COOKIE['id_office'];      
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $data=date('Y-m-d H:i:s', strtotime('-30 days', strtotime( date("Y-m-d H:i:s") )));
      $query="SELECT * FROM jual INNER JOIN pegawai ON pegawai.id_pegawai=jual.counter_jual 
      WHERE jual.acara_jual='OFFICE' AND jual.kantor_jual='$kantor' AND jual.tgl_order_jual between '$data' AND NOW()";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['id_jual']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_order_jual'])); ?></td>
                      <td><?php echo rupiah($baris['total_jual']); ?></td>
                      <td><?php echo $baris['status_jual']; ?></td>
                      <td><?php echo $baris['nama_customer']; ?></td>
                      <td><?php echo $baris['nama_pegawai']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris['id_jual']; ?>"> Detail</a>
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

          