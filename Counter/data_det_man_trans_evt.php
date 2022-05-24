
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

  <?php
    include "../db_proses/koneksi.php";

    $temp=$_GET['evt'];

    $query = "SELECT * FROM tb_detail_events 
    INNER JOIN tb_events ON tb_events.id_events=tb_detail_events.event_det_event WHERE tb_detail_events.id_det_event='$temp' AND tb_detail_events.status_det_event='ON'";
    $result = mysqli_query($kon, $query);
    $baris = mysqli_fetch_array($result,MYSQLI_ASSOC);
  ?>
          <div class="card mb-3">
            <div class="card-header">
              <a href="#" class="btn btn-primary" id="addtrans" data-evn="<?php echo $_GET['evt']; ?>" data-jenis="<?php echo $baris['id_events']; ?>">               
                <i class="fas fa-plus"></i> Tambah Manual Transaksi Baru 
              </a>
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
      $temp_jenis = $baris['id_events'];
      $kantor = $_COOKIE['office_bill'];     

      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      
      $query1="SELECT * FROM tb_man_trans INNER JOIN tb_staff ON tb_staff.kode_staff=tb_man_trans.counter_mt 
      WHERE tb_man_trans.acara_mt='$temp' AND tb_man_trans.kantor_mt='$kantor' AND tb_man_trans.total_mt!='0'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                    <tr>
                      <td><?php echo $baris1['id_mt']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris1['tgl_order_mt'])); ?></td>
                      <td><?php echo rupiah($baris1['total_mt']); ?></td>
                      <td><?php echo $baris1['status_mt']; ?></td>
                      <td><?php echo $baris1['cs_mt']; ?></td>
                      <td><?php echo $baris1['nama_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris1['id_mt']; ?>"> Detail</a>
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
          <div class="card mb-3">
            <div class="card-header">
              <a href="#" class="btn btn-danger" id="kembali">              
                Kembali
              </a>
            </div> 