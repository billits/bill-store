<?php
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_data_user.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-edit"> 
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Pegawai*</label>
                      <input class="form-control" type="text" name="id_pegawai" id="id_pegawai" readonly value="<?php echo $json[$a]['id_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Pegawai*</label>
                      <input class="form-control" type="text" name="nama_pegawai" id="nama_pegawai" value="<?php echo $json[$a]['nama_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="telepon">Telepon Pegawai*</label>
                      <input class="form-control" type="text" name="tlp_pegawai" id="tlp_pegawai" value="<?php echo $json[$a]['tlp_pegawai']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="alamat">Alamat Pegawai*</label>
                      <input class="form-control" type="text" name="alamat_pegawai" id="alamat_pegawai" value="<?php echo $json[$a]['alamat_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="username">Username Pegawai*</label>
                      <input class="form-control" type="text" name="username_pegawai" id="username_pegawai" value="<?php echo $json[$a]['username_pegawai']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="password">Password Pegawai*</label>
                      <input class="form-control" type="text" name="passwd_pegawai" id="passwd_pegawai" value="<?php echo $json[$a]['passwd_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="gender">Jenis Kelamin Pegawai*</label>
                      <input class="form-control" type="text" name="jenis_kelamin_pegawai" readonly id="jenis_kelamin_pegawai" value="<?php echo $json[$a]['jenis_kelamin_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="gender1">Jenis Kelamin Pegawai Baru*</label>
                      <select class="form-control" name="jenis_kelamin_pegawai1" id="jenis_kelamin_pegawai1">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="status">Status Pegawai*</label>
                      <input class="form-control" type="text" name="status_pegawai" readonly id="status_pegawai" value="<?php echo $json[$a]['status_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="status1">Status Pegawai Baru*</label>
                      <select class="form-control" name="status_pegawai1" id="status_pegawai1">
                        <option value="">Pilih Status Pegawai</option>
                        <option value="Admin">Admin</option>                        
                        <option value="GudangPusat">Gudang Pusat</option>
                        <option value="PICCounter">PIC Counter</option>                        
                        <option value="Counter">Counter</option>
                        <option value="Gudang">Gudang</option> 
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="office">Office Pegawai*</label>
                      <input class="form-control" type="text" name="office_pegawai2" readonly id="office_pegawai2" value="<?php echo $json[$a]['nama_office']; ?>" required/>
                      <input type="hidden" name="office_pegawai" id="office_pegawai" value="<?php echo $json[$a]['office_pegawai']; ?>">
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="office1">Office Pegawai Baru*</label>
                      <select class="form-control" name="office_pegawai1" id="office_pegawai1">
                        <option value="">Pilih Office</option>
    <?php
      $sumber1 = "http://localhost/BillServer/data_office.php";
      $konten1 = file_get_contents($sumber1);
      $json1 = json_decode($konten1, true);
                      
      for($a1=0; $a1 < count($json1); $a1++)
        {
    ?>
                      <option value="<?php echo $json1[$a1]['id_office']; ?>"><?php echo $json1[$a1]['nama_office']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="act">Active Pegawai*</label>
                      <input class="form-control" type="text" name="active_pegawai" readonly id="active_pegawai" value="<?php echo $json[$a]['active_pegawai']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="act1">Active Pegawai Baru*</label>
                      <select class="form-control" name="active_pegawai1" id="active_pegawai1">
                        <option value="">Pilih Aktif Pegawai</option>
                        <option value="ON">ON</option>                        
                        <option value="OFF">OFF</option>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="update">Updated By*</label>
                      <input class="form-control" type="text" name="created_by" readonly id="created_by" value="<?php echo $json[$a]['created_by']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>