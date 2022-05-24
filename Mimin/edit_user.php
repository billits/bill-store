<?php
  include "../db_proses/koneksi.php";
  $id=$_POST['id'];

	$query = "SELECT * FROM tb_staff INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff WHERE tb_staff.kode_staff='$id'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
    $min=$baris['create_staff'];
?>

                  <form method="post" id="form-edit"> 
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Pegawai*</label>
                      <input class="form-control" type="text" name="id_pegawai" id="id_pegawai" readonly value="<?php echo $baris['kode_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Pegawai*</label>
                      <input class="form-control" type="text" name="nama_pegawai" id="nama_pegawai" value="<?php echo $baris['nama_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="username">Username Pegawai*</label>
                      <input class="form-control" type="text" name="username_pegawai" id="username_pegawai" value="<?php echo $baris['uname_staff']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="password">Password Pegawai*</label>
                      <input class="form-control" type="text" name="passwd_pegawai" id="passwd_pegawai" value="<?php echo $baris['pass_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="office">Office Pegawai*</label>
                      <input class="form-control" type="text" name="office_pegawai2" readonly id="office_pegawai2" value="<?php echo $baris['nama_office']; ?>" required/>
                      <input type="hidden" name="office_pegawai" id="office_pegawai" value="<?php echo $baris['office_staff']; ?>">
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="office1">Office Pegawai Baru*</label>
                      <select class="form-control" name="office_pegawai1" id="office_pegawai1">
                        <option value="">Pilih Office</option>
    <?php
      $query1 = "SELECT * FROM tb_office INNER JOIN tb_region ON tb_region.id_region=tb_office.region_office";
      $result1 = mysqli_query($kon, $query1);

      while($baris1 = mysqli_fetch_assoc($result1)){
    ?>
                      <option value="<?php echo $baris1['id_office']; ?>"><?php echo $baris1['nama_office']; ?></option>
    <?php
        }
    ?>
                      </select>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="act">Active Pegawai*</label>
                      <input class="form-control" type="text" name="active_pegawai" readonly id="active_pegawai" value="<?php echo $baris['active_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="act1">Active Pegawai Baru*</label>
                      <select class="form-control" name="active_pegawai1" id="active_pegawai1">
                        <option value="">Pilih Aktif Pegawai</option>
                        <option value="ON">ON</option>                        
                        <option value="OFF">OFF</option>
                      </select>
                    </div>
      <?php
        $sqlre= "SELECT * FROM tb_staff WHERE kode_staff='$min'";
        $resultre = mysqli_query($kon,$sqlre);	  
        $rowre = mysqli_fetch_array($resultre,MYSQLI_ASSOC);
      ?>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="update">Updated By*</label>
                      <input class="form-control" type="text" name="created_by1" readonly id="created_by1" value="<?php echo $rowre['nama_staff']; ?>" required/>
                      <input class="form-control" type="hidden" name="created_by" readonly id="created_by" value="<?php echo $baris['create_staff']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>