    
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
      
      $query="SELECT * FROM tb_beli INNER JOIN tb_staff ON tb_staff.kode_staff=tb_beli.supplier_beli INNER JOIN tb_office ON tb_office.id_office=tb_beli.kantor_beli 
      WHERE tb_beli.id_beli='$nota'";
      $result = mysqli_query($kon, $query);
      while($baris = mysqli_fetch_assoc($result)){
    ?>
             <table>
                <tr>
                  <th>Kode </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['id_beli']; ?></td>
                </tr>
                <tr>
                  <th>Tanggal </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo date("d-m-Y H:i:s", strtotime($baris['tgl_beli'])); ?></td>
                </tr>
                <tr>
                  <th>Supplier </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['nama_staff']; ?></td>
                </tr>
                <tr>
                  <th>Keterangan </th>
                  <th>&emsp;:</th>
                  <td>&emsp;<?php echo $baris['keterangan_beli']; ?></td>
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
      
      $query1="SELECT * FROM tb_detail_beli INNER JOIN tb_beli ON tb_beli.id_beli=tb_detail_beli.nota_detbeli 
        INNER JOIN tb_produk ON tb_produk.id_produk=tb_detail_beli.produk_detbeli 
        INNER JOIN tb_kategori ON tb_kategori.id_kategori=tb_produk.kategori_produk 
        INNER JOIN tb_harga_produk ON tb_harga_produk.id_harga=tb_detail_beli.harga_detbeli 
        WHERE tb_beli.id_beli='$nota'";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
        $bayar=$bayar+$baris1['total_jumlah_detbeli'];
        $produk=$baris1['id_produk'];
        
    ?>
                    <tr>
                      <td><?php echo $baris1['id_produk']; ?></td>
                      <td><?php echo $baris1['nama_produk']; ?></td>
                      <td><?php echo $baris1['nama_kategori']; ?></td>
                      <td><?php echo rupiah($baris1['harga_harian']); ?></td>
                      <td><?php echo $baris1['qty_detbeli']; ?></td>      
                      <td><?php echo rupiah($baris1['total_jumlah_detbeli']); ?></td>
                    </tr>    
                    
    <?php
      }
    ?>             
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="5">Total Bayar</th>
                      <th><?php echo rupiah($bayar); ?></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
          <div class="card mb-3">
            <div class="card-header">
              <form id="form-app" method="post">                    
                  <button type="submit" class="btn btn-success" name="cetak" id="cetak" data-id="<?php echo $nota; ?>">Cetak</button>    
                  <button type="submit" class="btn btn-danger" name="kembali" id="kembali" >Kembali</button>  
              </form> 
            </div>
          </div>

          
