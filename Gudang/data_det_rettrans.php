    
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
    <?php
      include "../db_proses/koneksi.php";
      
      $org = $_COOKIE['idstaff_bill'];
      $kantr = $_COOKIE['office_bill'];
      $nota = $_REQUEST['id'];      
      $tgl=0;
      $query="SELECT * FROM tb_retur_transaksi INNER JOIN tb_staff ON tb_staff.kode_staff=tb_retur_transaksi.staff_retur 
      INNER JOIN tb_office ON tb_office.id_office=tb_retur_transaksi.kantor_retur 
      WHERE tb_retur_transaksi.id_retur='$nota'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        $tgl=date("Y-m-d H:i:s", strtotime($baris['waktu_retur']));
    ?>
              <table width=100%>
          <tr>
            <td>
              <table>
                <tr>
                  <th>Kode </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_retur']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal Retur</th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['waktu_retur'])); ?></td>
                </tr>
                <tr>
                  <th>Counter </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']." - ".$baris['nama_office']; ?></td>
                </tr>
              </table>  
            </td>
            <td>
              <table>              
                <tr>
                  <th>Status </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['status_retur']; ?></td>
                </tr>         
                <tr>
                  <th>Kode NTJ </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['notajual_retur']; ?></td>
                </tr>
                <tr>
                  <th>Keterangan </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['keterangan_retur']; ?></td>
                </tr>
              </table>  
            </td>
          </tr>
        </table>                 
    <?php
      }
    ?> 
            </div>              
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode</th>
                      <th>Produk</th>
                      <th>kategori</th>
										  <th>Harga</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
    <?php
      function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $bayar=0;
      $query2="SELECT * FROM tb_detail_retur_transaksi INNER JOIN tb_retur_transaksi ON tb_retur_transaksi.id_retur=tb_detail_retur_transaksi.id_detrettrans 
      INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_retur_transaksi.produk_detrettrans
      INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
      INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_retur_transaksi.harga_detrettrans 
      WHERE tb_retur_transaksi.id_retur='$nota'";
      $result2 = mysqli_query($kon, $query2);
      
      while($baris2 = mysqli_fetch_assoc($result2)){
        $bayar=$bayar+$baris2['totjum_detrettrans'];
        $produk=$baris2['id_produk'];
        $totju=$baris2['total_retur'];
        
    ?>
                    <tr>
                      <td><?php echo $baris2['id_produk']; ?></td>
                      <td><?php echo $baris2['nama_produk']; ?></td>
                      <td><?php echo $baris2['nama_kategori']; ?></td>
                      <td><?php echo rupiah($baris2['harga_harian']); ?></td>
                      <td><?php echo $baris2['jumret_detrettrans']; ?></td>
                      <td><?php echo rupiah($baris2['totjum_detrettrans']); ?></td>
                    </tr>    
                    
    <?php
      }
    ?>             
                  </tbody>
                  <tfoot>
                      <th colspan="5">Total </th>
                      <th><?php echo rupiah($totju); ?></th>
                    </tr> 
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <form id="form-app" method="post">
                  <input type="hidden" name="nota" value="<?php echo $nota; ?>">
                  <input type="hidden" name="total" value="<?php echo $totju; ?>">
                  <input type="hidden" name="staff" value="<?php echo $org; ?>">
                  <input type="hidden" name="off" value="<?php echo $kantr; ?>">
                  <button type="submit" class="btn btn-success" name="aprov" id="aprov" onClick="return confirm('Yakin Approve ?');">Approve</button>        
                  <button type="submit" class="btn btn-danger" name="kembali" id="kembali" >Kembali</button>  
              </form> 
            </div>
          </div>

          
