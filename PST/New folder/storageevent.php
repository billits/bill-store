<?php
  include ('akses.php');
  include ('../_partials/partial_pusat.php');
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php echo $csjs1; ?>
  </head>


  <body id="page-top">
    <?php echo $topnav; ?>

    <div id="wrapper">
      <?php echo $topside; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
          <!-- Breadcrumbs-->
          <ol class="breadcrumb">
            Stok Produk Gudang Event <?php echo $_COOKIE['nama_office']; ?>
          </ol>

          <!-- DataTables Example -->
          <div id="DataStok">          
          </div>

          <!-- Modal Popup untuk Pilih Data Event--> 
          <div id="ModalEv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class='modal-title' id='exampleModalLabel'>Pilih Event</h5>
                  <button class='close' type='button' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form method="post" id="form-ev">
                    <div class="form-group" style="padding-bottom: 20px;">
                      <label for="keterangan">Data Event*</label>
                        <select class="form-control m-bot15" name="event" id="event">
                          <option value="BEST">BEST</option>
                          <option value="BIG">BIG</option>
                          <option value="RTS">RTS</option>
                          <option value="ELITE">ELITE</option>
                          <option value="BMW">BMW</option>
                          <option value="BOOTCAMP">BOOTCAMP</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-success" id="btn-save" type="submit">Pilih</button>
                      <button type="reset" class="btn btn-danger"  data-dismiss="modal" aria-hidden="true">Batal</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

        <?php
          echo $footer;
        ?>
        
      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
		<?php
      echo $logout;
    ?>

    <?php
      echo $csjs2;
    ?>

    <script type="text/javascript">
      $(document).ready(function(){
        var datastok = "data_stokevent.php";
        $('#DataStok').load(datastok); 

        $('#form-ev').submit(function(e){
          e.preventDefault();          
          $('#ModalEv').modal('hide');
          var datatmp = document.getElementById("event").value;
          var dataevt = "data_detstokevent.php?evt="+datatmp;
          $('#DataStok').load(dataevt); 
        })

        $(document).on('click','#addstok',function(e){
          e.preventDefault();
          var evt =$(this).attr('data-et');
          var tmp = {event : evt}
          $.ajax({
            url:"../db_proses/add_stokevt.php",
            type:"POST",
            data: tmp,
            success:function(data){
              var obj= JSON.parse(data);
              if(obj.nilai===1){
                window.location= 'add_stokevt.php?nota='+obj.nota+"&evn="+obj.acara;
              }else{
                alert(obj.error); 
              }
            }
          })
        });

        $(document).on('click','#kembali',function(e){
          e.preventDefault();
          $('#DataStok').load(datastok); 
        });
        
      })
    </script>

  </body>
  
</html>

