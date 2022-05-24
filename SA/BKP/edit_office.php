<?php
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_data_office.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-edit-office">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Office*</label>
                      <input class="form-control" type="text" name="kode_office" readonly id="kode_office" value="<?php echo $json[$a]['id_office']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Office*</label>
                      <input class="form-control" type="text" name="nama_office" id="nama_office" value="<?php echo $json[$a]['nama_office']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kota">Kota Office*</label>
                      <input class="form-control" type="text" name="kota_office" id="kota_office" value="<?php echo $json[$a]['kota_office']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Alamat Office*</label>
                      <input class="form-control" type="text" name="alamat_office" id="alamat_office" value="<?php echo $json[$a]['alamat_office']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Telepon Office*</label>
                      <input class="form-control" type="text" name="telepon_office" id="telepon_office" value="<?php echo $json[$a]['tlp_office']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Region Office*</label>
                      <input class="form-control" type="text" name="region_office" readonly id="region_office" value="<?php echo $json[$a]['nama_region']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Region Office Baru*</label>
                      <select class="form-control" name="region_office1" id="region_office1">
                        <option value="pr">Pilih Region</option>
    <?php
      $sumber1 = "http://localhost/BillServer/data_region.php";
      $konten1 = file_get_contents($sumber1);
      $json1 = json_decode($konten1, true);
                      
      for($a1=0; $a1 < count($json1); $a1++)
        {
    ?>
                      <option value="<?php echo $json1[$a1]['id_region']; ?>"><?php echo $json1[$a1]['nama_region']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                  </form>

<?php
  }
?>