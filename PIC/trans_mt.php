
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
      
      $kantor = $_COOKIE['office_bill'];      

      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $tgl_start = $_REQUEST['tgl_start'];
      $tgl_end = $_REQUEST['tgl_end'];
      $event = $_REQUEST['event'];

      $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
      $tgl_temp=date('Y-m-d', strtotime($tgl_end));
      $tgl_selesai = $tgl_temp." 23:59:59";

      if($event != 'OFFICE'){
        $sqlre= "SELECT * FROM tb_detail_events WHERE id_det_event = '$event'";
        $resultre = mysqli_query($kon,$sqlre);	  
        $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);	
        $nama_event = $rowre['nama_det_event'];
      }else{
        $nama_event = "OFFICE";
      }

      ?>

          <div class="card mb-3">
            <div class="card-header">
              Manual Transaksi <?php echo $nama_event." ".$_COOKIE['office_bill']; ?>
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
      
      $query="SELECT * FROM tb_man_trans INNER JOIN tb_staff ON tb_staff.kode_staff=tb_man_trans.counter_mt 
      WHERE tb_man_trans.acara_mt='$event' AND tb_man_trans.total_mt!='0' AND tb_man_trans.kantor_mt='$kantor' AND tb_man_trans.tgl_order_mt between '$tgl_mulai' AND '$tgl_selesai'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                  
                    <tr>
                      <td><?php echo $baris['id_mt']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_order_mt'])); ?></td>
                      <td><?php echo rupiah($baris['total_mt']); ?></td>
                      <td><?php echo $baris['status_mt']; ?></td>
                      <td><?php echo $baris['cs_mt']; ?></td>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris['id_mt']; ?>"> Detail</a>
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
              <form id="form-app" method="post">  
                <button type="submit" class="btn btn-danger" name="back" id="back" >Kembali</button>  
              </form> 
            </div>
          </div>

          