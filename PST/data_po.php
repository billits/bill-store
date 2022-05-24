
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
                      <th>Kantor</th>
                      <th>Staff</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode</th>
                      <th>Tanggal</th>
										  <th>Total</th>
                      <th>Kantor</th>
                      <th>Staff</th>
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
      
      $query="SELECT * FROM tb_po INNER JOIN tb_staff ON tb_staff.kode_staff=tb_po.staff_po 
      INNER JOIN tb_office ON tb_office.id_office=tb_po.kantor_po 
      WHERE tb_po.event_po='OFFICE' AND tb_po.status_po='REQUEST' AND tb_po.kantor_po!=' $kantor' AND tb_po.total_po!=0";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                      <td><?php echo $baris['id_po']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_po'])); ?></td>
                      <td><?php echo rupiah($baris['total_po']); ?></td>
                      <td><?php echo $baris['nama_office']; ?></td>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris['id_po']; ?>"> Detail</a>
                        <a href="#" class="btn btn-danger" id="hapus_nota" data-id="<?php echo $baris['id_po']; ?>"> Hapus</a>
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

          