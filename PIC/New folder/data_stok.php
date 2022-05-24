
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
              <a href="#" class="btn btn-primary" id="addstok">              
                <i class="fas fa-plus"></i> Tambah Stok Produk    
              </a>
            </div>  

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Kategori Produk</th>
										  <th>Harga Produk</th>
                      <th>Stok Office</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama Produk</th>
										  <th>Kategori Produk</th>
										  <th>Harga Produk</th>
                      <th>Stok Office</th>
                    </tr>
                  </tfoot>
                  <tbody>
    <?php
      include "../db_proses/koneksi.php";
      
      
      function rupiah($angka) {
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
      }
      $reg = $_COOKIE["region"];
      $off = $_COOKIE['id_office'];

      $query = "SELECT * FROM gudang 
      INNER JOIN produk ON produk.id_produk=gudang.kode_produk_gudang 
      INNER JOIN kategori ON kategori.id_kategori=produk.kategori_produk 
      INNER JOIN harga_produk ON harga_produk.produk_harga=produk.id_produk 
      WHERE gudang.kode_office_gudang='$off' AND gudang.event_gudang='OFFICE' AND harga_produk.region_harga='$reg' AND harga_produk.status_harga='ON'";
      $result = mysqli_query($kon, $query);
      
      while($baris = mysqli_fetch_assoc($result)){
        
        $pdk_tmp=$baris['id_produk'];
        $sql1= "SELECT * FROM paket_produk WHERE det_produk='$pdk_tmp' AND status_paket='ON'";
        $result1 = mysqli_query($kon,$sql1);
        $row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC);
        $count1 = mysqli_num_rows($result1);

        if ($count1>=1){
          $paket=$row1['produk_paket'];
          $jum_pro_paket=$row1['jum_pro_paket'];

          $sql2= "SELECT * FROM temp_jual 
          INNER JOIN produk ON produk.id_produk=temp_jual.produk_temp
          WHERE temp_jual.produk_temp='$paket' AND temp_jual.kantor_temp='$off' AND temp_jual.status_temp='BELUM'";
          $result2 = mysqli_query($kon,$sql2);
          $row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
          $count2 = mysqli_num_rows($result2);

          if ($count2>=1){
            $jum_pro=$jum_pro_paket*$row2['jml_pdk_temp'];
            $final_jml = $baris['jml_produk_gudang']+$jum_pro;
          }else{
            $sql3= "SELECT * FROM temp_jual 
            INNER JOIN produk ON produk.id_produk=temp_jual.produk_temp
            WHERE temp_jual.produk_temp='$pdk_tmp' AND temp_jual.kantor_temp='$off' AND temp_jual.status_temp='BELUM'";
            $result3 = mysqli_query($kon,$sql3);
            $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
            $final_jml = $baris['jml_produk_gudang']+$row3['jml_pdk_temp'];
          }
        }else{
          $sql3= "SELECT * FROM temp_jual 
          INNER JOIN produk ON produk.id_produk=temp_jual.produk_temp
          WHERE temp_jual.produk_temp='$pdk_tmp' AND temp_jual.kantor_temp='$off' AND temp_jual.status_temp='BELUM'";
          $result3 = mysqli_query($kon,$sql3);
          $row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC);
          $final_jml = $baris['jml_produk_gudang']+$row3['jml_pdk_temp'];
        }

    ?>
                    <tr>
                      <td><?php echo $baris['id_produk']; ?></td>
                      <td><?php echo $baris['nama_produk']; ?></td>
                      <td><?php echo $baris['nama_kategori']; ?></td>
                      <td><?php echo rupiah($baris['harga_harian']); ?></td>
                      <?php
                        if ($baris['id_kategori']=="PKT"){
                      ?>
                        <td>~</td> 
                      <?php
                        }else{
                      ?>
                        <td><?php echo $final_jml; ?></td> 
                      <?php
                        }
                      ?>
                    </tr>               
    <?php
      }
    ?>             
                  </tbody>
                </table>
              </div>
            </div>
          </div>