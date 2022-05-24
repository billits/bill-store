<?php
  include ('akses.php');
  include ('../_partials/partial_pic.php');
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
            <li class="breadcrumb-item">
              <a href="home.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active"> Inbox PO dari Pusat</li>
          </ol>

          <!-- DataTables Example -->
          <div id="DataBTB">
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
        var databtb = "data_btb.php";
        $('#DataBTB').load(databtb); 

        $(document).on('click','#detail',function(e){
          e.preventDefault();
          //PDF or load DataBTB
          var datatmp = $(this).attr('data-id');
          var datapi = $(this).attr('data-pi');
          var datalap = "data_detpo.php?id="+datatmp+"&pi="+datapi;
          $('#DataBTB').load(datalap); 
        });
        
        $(document).on('click','#kembali',function(e){
          e.preventDefault();
        $('#DataBTB').load(databtb); 
        });
        
        $(document).on('click','#aprov',function(e){
          e.preventDefault();
          var dataform = $("#form-app").serialize();
          $.ajax({
            url: "../db_proses/update_pocl.php",
            type: "POST",
            data: dataform,
            success:function(result){
              var obj= JSON.parse(result);
              if(obj.nilai===1){
                // alert(obj.error); 
                // location.reload();
                var nota_tmp = obj.kode_nota;
                window.open(
                  '../Print Nota BTB.php?nota='+nota_tmp,
                  '_blank' // <- This is what makes it open in a new window.
                );
                window.location= 'inboxpo.php'; 
              }else{
                alert(obj.error); 
              }
            }
          });
        });

        $(document).on('click','#cetak',function(e){
          e.preventDefault();
          var nota_tmp = $(this).attr('data-id');
          window.open(
            '../Print Nota NPO Cabang.php?nota='+nota_tmp,
            '_blank' // <- This is what makes it open in a new window.
          );
        });

      })
    </script>

  </body>
  
</html>

