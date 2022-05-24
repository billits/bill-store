<?php
  $id=$_POST['id'];
  $sumber = "http://localhost/BillServer/detail_data_events.php?id=".$id;
  $konten = file_get_contents($sumber);
  $json = json_decode($konten, true);
                    
  for($a=0; $a < count($json); $a++) {
?>

                  <form method="post" id="form-edit-region">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Modal Name">Kode Events</label>
                      <input type="text" name="kode_events"  id="kode_events" class="form-control" readonly value="<?php echo $json[$a]['id_events']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Nama Events</label>
                      <input type="text" name="nama_events" id="nama_events" class="form-control" value="<?php echo $json[$a]['nama_events']; ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Time Update Events</label>
                      <input type="text" name="time_events" id="time_events" class="form-control" readonly value="<?php echo date('d-m-Y H:i:s', strtotime($json[$a]['time_events'])); 
                      ?>" required/>
                    </div>
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="Description">Keterangan Events</label>
                      <input type="text" name="ket_events" id="ket_events" class="form-control" value="<?php echo $json[$a]['keterangan_events']; ?>" required/>
                    </div>
                  </form>

<?php
  }
?>