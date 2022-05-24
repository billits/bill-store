
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
          
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }

      $tgl_start = $_REQUEST['tgl_start'];
      $tgl_end = $_REQUEST['tgl_end'];
      $kantor = $_REQUEST['kantor'];

      $tgl_mulai = date('Y-m-d', strtotime($tgl_start));
      $tgl_temp=date('Y-m-d', strtotime($tgl_end));
      $tgl_selesai = $tgl_temp." 23:59:59";

      
      $sqlre= "SELECT * FROM tb_office WHERE id_office = '$kantor'";
      $resultre = mysqli_query($kon,$sqlre);	  
      $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);	
      $nama_kantor = $rowre['nama_office'];
    ?>

          <div class="card mb-3">
            <div class="card-header">
              Data Konsinyasi Office Cabang <?php echo $nama_kantor; ?>
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
                      <th>Staff</th>
										  <th>Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode</th>
                      <th>Tanggal</th>
										  <th>Total</th>
                      <th>Status</th>
                      <th>Staff</th>
										  <th>Action</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      

      $query="SELECT * FROM tb_po INNER JOIN tb_staff ON tb_staff.kode_staff=tb_po.staff_po 
      WHERE tb_po.kantor_po='$kantor' AND tb_po.beli_po='0' AND tb_po.total_po!='0' AND tb_po.tgl_po between '$tgl_mulai' AND '$tgl_selesai'";
      $result = mysqli_query($kon, $query);
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                    <td><?php echo $baris['id_po']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_po'])); ?></td>
                      <td><?php echo rupiah($baris['total_po']); ?></td>
                      <td><?php echo $baris['status_po']; ?></td>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail1" data-id="<?php echo $baris['id_po']; ?>" > Detail</a>
                      </td>
                    </tr>    
                    
    <?php
      }

      $query="SELECT * FROM tb_beli INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli.staff_beli 
      WHERE tb_beli.kantor_beli='$kantor' AND tb_beli.total_beli!='0' AND tb_beli.tgl_beli between '$tgl_mulai' AND '$tgl_selesai'";
      $result = mysqli_query($kon, $query);
      while($baris = mysqli_fetch_assoc($result)){
    ?>
                    <tr>
                    <td><?php echo $baris['id_beli']; ?></td>
                      <td><?php echo date("d-m-Y H:i:s", strtotime ($baris['tgl_beli'])); ?></td>
                      <td><?php echo rupiah($baris['total_beli']); ?></td>
                      <td><?php echo $baris['status_beli']; ?></td>
                      <td><?php echo $baris['nama_staff']; ?></td>
                      <td>
                        <a href="#" class="btn btn-primary" id="detail" data-id="<?php echo $baris['id_beli']; ?>" > Detail</a>
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

          