<?php
  include "../db_proses/koneksi.php";
  $nota=$_POST['nota1'];
  $pdk=$_POST['pdk'];
  $evt=$_POST['evt1'];
  $ret=$_POST['ret'];
  $laku=$_POST['laku'];
  $pc=$_POST['pc'];
  $qty=$_POST['qty'];

  $maks_ret=$qty-$laku-$ret;

  $query = "SELECT * FROM tb_produk WHERE id_produk='$pdk'";
	$result = mysqli_query($kon, $query);
	
	while($baris = mysqli_fetch_assoc($result)){
?>

                  <form method="post" id="form-edit">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="kode">Kode Produk*</label>
                      <input class="form-control" type="text" name="kode_produk" readonly id="kode_produk" value="<?php echo $baris['id_produk']; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="nama">Nama Produk*</label>
                      <input class="form-control" type="text" name="nama_produk" readonly id="nama_produk" value="<?php echo $baris['nama_produk']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="total">Maksimal Retur*</label>
                      <input class="form-control" type="text" name="total" id="total" readonly value="<?php echo $maks_ret; ?>" required/>  
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="jumlah">Qty Produk*</label>
                      <input class="form-control" type="text" name="qty" id="qty" placeholder="Qty" onkeyup="myFunction()" required/>  
                    </div>
                      <input class="form-control" type="hidden" name="nota" id="nota" value="<?php echo $nota; ?>"/>
                      <input class="form-control" type="hidden" name="evt" id="evt" value="<?php echo $evt; ?>"/>
                      <input class="form-control" type="hidden" name="ret" id="ret" value="<?php echo $ret; ?>"/>
                      <input class="form-control" type="hidden" name="laku" id="laku" value="<?php echo $laku; ?>"/>
                      <input class="form-control" type="hidden" name="pc" id="pc" value="<?php echo $pc; ?>"/>
                      <input class="form-control" type="hidden" name="jum_pdk" id="jum_pdk" value="<?php echo $qty; ?>"/>
                  </form>

<?php
  }
?>