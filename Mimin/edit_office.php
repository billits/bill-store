<?php
  include "../db_proses/koneksi.php";
  
  $id=$_POST['id'];
	$query = "SELECT * FROM tb_office INNER JOIN tb_region ON tb_region.id_region=tb_office.region_office WHERE tb_office.id_office='$id'";
  $result = mysqli_query($kon, $query);
  
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit-office">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Office*</label>
                      <input class="form-control" type="text" name="kode_office" readonly id="kode_office" value="<?php echo $baris['id_office']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Office*</label>
                      <input class="form-control" type="text" name="nama_office" id="nama_office" value="<?php echo $baris['nama_office']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kota">Kota Office*</label>
                      <input class="form-control" type="text" name="kota_office" id="kota_office" value="<?php echo $baris['kota_office']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Region Office*</label>
                      <input class="form-control" type="text" name="region_office2" readonly id="region_office2" value="<?php echo $baris['nama_region']; ?>" required/>
                      <input class="form-control" type="hidden" name="region_office" readonly id="region_office" value="<?php echo $baris['id_region']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Region Office Baru*</label>
                      <select class="form-control" name="region_office1" id="region_office1">
                        <option value="">Pilih Region</option>
    <?php
      $query1 = "SELECT * FROM tb_region";
      $result1 = mysqli_query($kon, $query1);
      
      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                      <option value="<?php echo $baris1['id_region']; ?>"><?php echo $baris1['nama_region']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                  </form>

<?php
  }
?>