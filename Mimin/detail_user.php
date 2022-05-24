<?php
  include "../db_proses/koneksi.php";

  $id=$_POST['id'];
  $query = "SELECT * FROM tb_staff INNER JOIN tb_office ON tb_office.id_office=tb_staff.office_staff WHERE tb_staff.kode_staff='$id'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-det">
                  <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Pegawai*</label>
                      <input class="form-control" type="text" name="id_pegawai" id="id_pegawai" readonly value="<?php echo $baris['kode_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Pegawai*</label>
                      <input class="form-control" type="text" name="nama_pegawai" readonly id="nama_pegawai" value="<?php echo $baris['nama_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="username">Username Pegawai*</label>
                      <input class="form-control" type="text" name="username_pegawai" readonly id="username_pegawai" value="<?php echo $baris['uname_staff']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="password">Password Pegawai*</label>
                      <input class="form-control" type="text" name="passwd_pegawai" readonly id="passwd_pegawai" value="<?php echo $baris['pass_staff']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="office">Office Pegawai*</label>
                      <input class="form-control" type="text" name="office_pegawai2" readonly id="office_pegawai2" value="<?php echo $baris['nama_office']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="act">Active Pegawai*</label>
                      <input class="form-control" type="text" name="active_pegawai" readonly id="active_pegawai" value="<?php echo $baris['active_staff']; ?>" required/>
                    </div>

                  <?php
                    $query1 = "SELECT * FROM tb_akses WHERE staff_akses='$id'";
                    $result1 = mysqli_query($kon, $query1);
                    $nom=0;

                    while($baris1 = mysqli_fetch_assoc($result1)){
                      $nom=$nom+1;
                  ?>
                  
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kategori"><?php echo "Akses-".$nom; ?>*</label>
                      <input class="form-control" type="text" name="kategori2" readonly id="kategori2" value="<?php echo $baris1['status_akses']; ?>" required/>  
                    </div>

                  <?php
                    }
                  ?>

                  </form>

<?php
  }
?>