<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
ob_start();

//Mengecek status login
if(!isset($_SESSION['username']) or !isset($_SESSION['password'])){
  session_start();
  session_destroy();
   echo "<script>
      window.location = 'index.php';
      </script>";
}
include 'koneksi.php'; 
include 'helper.php'; 
?>
<!doctype html>
<html lang="en">

<head>
  <title>Buat Kelas</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/animate.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet"href="./css/bootstrap-datepicker.css">
</head>

<body>
  <a href="logout.php" class="btn-sm btn btn-danger" style="position: absolute; top: 0;right: 0;margin-top: 10px;margin-right: 10px;"
  >Logout</a>
  <div class="container-fluid gradient-2">
    <div class="row border-button-yn">
      <div class="col-12 text-center mt-5 mb-3">
        <h1 class="animated fadeInDown presensi ">presensi</h1>
        <h1 class="display-3 animated fadeInDown">Kelas Eksekutif #YukNgaji</h1>
      </div>
    </div>

    <!-- line -->
    <div class="row position-relative">
      <div class="col-4 position-absolute d-inline-block line animated fadeInRight">
        <img src="./assets/logoBG.png" class="d-flex mx-auto w-50">
        <img src="./assets/logo-bawah.png" style="position: absolute; top:45%">
      </div>
    </div>

    <div class="row">

      <div class="col-4 mt-5">
        <div class="row justify-content-center mt-4">
          <div class="col-10 mt-3">
            <form  onsubmit="return kelasBaru()">

              <div class="input-group mb-3 animated fadeInRight">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="sesi_kelas">Sesi Kelas</label>
                </div>
                <select class="custom-select" id="sesi_kelas" name="sesi_kelas" required>
                  <option value="">-- Pilih --</option>
                    <?php 
                        $sql= "SELECT id_sesi,nama_sesi FROM tbl_sesi";
                        $stmt = $dbh->query($sql);
                        while($row = $stmt->fetchObject()){
                          echo "<option value='".$row->id_sesi."'>".$row->nama_sesi."</option>";    
                        }
                     ?>
                </select>
              </div>

              <div class="input-group mb-3 animated fadeInRight">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="episode_sesi">Episode &nbsp;&nbsp;&nbsp;</label>
                </div>
                <select class="custom-select" id="episode_sesi" required>
                   <option value="">-- Pilih --</option>
                </select>
              </div>

              <div class="input-group mb-3 animated fadeInRight">
                <div class="input-group-prepend">
                  <span class="input-group-text__mod">Tempat &nbsp;</span>
                </div>
                <input type="text" class="form-control transparent__input" name="tempat" id="tempat" required>
              </div>

              <div class="input-group mb-3 animated fadeInRight">
                <div class="input-group-prepend">
                  <span class="input-group-text__mod">Tanggal</span>
                </div>
                <input data-provide="datepicker"  data-date-format="dd-mm-yyyy" class="datepicker form-control transparent__input" name="tanggal" id="tanggal" onkeydown="return false" required>
              </div>

              <button class="btn btn-light rounded-lg float-right mt-3 w-50 animated fadeInLeft" type="submit">Kelas
                Baru</button>

            </form>
          </div>
        </div>
      </div>

      <div class="col-8">
        <h1 class="mb-4 text-center pt-3">Riwayat Kelas</h1>

        <div class="row justify-content-center">
          <div class="col-11 table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
            <table class="table table-bordered table-hover table-sm bg-light">
              <thead>
                <tr>
                  <th scope="col" class="text-center">No</th>
                  <th scope="col" class="text-center">Sesi kelas</th>
                  <th scope="col" class="text-center">Episode</th>
                  <th scope="col" class="text-center">Tempat</th>
                  <th scope="col" class="text-center">Tanggal</th>
                  <th scope="col" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  $no = 1;
                  $sql  = "SELECT * FROM tbl_presensi tp join tbl_episode te on tp.id_episode = te.id_episode join tbl_sesi ts on te.id_sesi = ts.id_sesi";
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $no = 1;
                  while($row = $stmt->fetchObject()){    ?>
                     <tr>
                      <td class="text-center"><?php echo $no; ?></td>
                      <td class="text-center"><?php echo $row->nama_sesi; ?></th>
                      <td class="text-center"><?php echo $row->nama_episode; ?></td>
                      <td class="text-center"><?php echo $row->tempat; ?></td>
                      <td class="text-center"><?php echo tglindonesia($row->tanggal); ?></td>
                      <td class="text-center"><button class="btn-sm btn btn-success" onclick="cetak(<?php echo $row->id_presensi; ?>)">Cetak</button> <button class="btn-sm btn btn-danger" onclick="hapus(<?php echo $row->id_presensi; ?>)">Hapus</button></td>
               
                     </tr>  

                <?php 
                  $no++;
                } 
                ?>
                
               
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>

  <script src="./js/jquery-3.3.1.min.js"></script>
  <script src="./js/bootstrap.bundle.min.js"></script>
  <script src="./js/bootstrap-datepicker.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){ // Ketika halaman sudah siap (sudah selesai di load)
  
  
    $("#sesi_kelas").change(function(){ // Ketika user mengganti atau memilih data provinsi
      $.ajax({
        type: "GET", // Method pengiriman data bisa dengan GET atau POST
        url: "ajax/ajax_kelas.php?action=option_episode&sesi_kelas="+$("#sesi_kelas").val(), // Isi dengan url/path file php yang dituju
        dataType: "json",
        beforeSend: function(e) {
          if(e && e.overrideMimeType) {
            e.overrideMimeType("application/json;charset=UTF-8");
          }
        },
        success: function(response){ // Ketika proses pengiriman berhasil
          console.log(response.data_episode);
          $("#episode_sesi").html(response.data_episode).show();
        },
        error: function (xhr, ajaxOptions, thrownError) { // Ketika ada error
          alert(thrownError); // Munculkan alert error
        }
      });
      });
  });

    function kelasBaru(){
        url = "ajax/ajax_kelas.php?action=insert";
          var data=new FormData();
          
           // var sesi_kelas      = document.getElementById("sesi_kelas").value;
           var episode_sesi     = document.getElementById("episode_sesi").value;
           var tempat            = document.getElementById("tempat").value;
           var tanggal            = document.getElementById("tanggal").value;
           
           // data.append('sesi_kelas',sesi_kelas);
           data.append('episode_sesi',episode_sesi);
           data.append('tempat',tempat);
           data.append('tanggal',tanggal);    
           
          
          $.ajax({
            url : url,
            type : "POST",
            data : data,
            dataType : "json",
            processData: false,
            contentType: false,        
            success : function(data){
              if(data.hasil==true){
                  window.location = 'presensi.php?episode='+episode_sesi;
              }else{
                alert("Something Error");
                window.location = 'kelas.php';  
              }
              
            },
            error : function(){
                alert("Tidak dapat menyimpan data!");
            }        
          });
          return false;
    }
    function cetak(id_presensi){
      window.open("ajax/ajax_kelas.php?action=cetak&id_presensi="+id_presensi, "Cetak");
      return false;
    }
    function hapus(id_presensi){
         if(confirm("Apakah yakin data akan dihapus?")){
            $.ajax({
               url : "ajax/ajax_kelas.php?action=hapus&id_presensi="+id_presensi,
               type : "GET",
               success : function(data){
                 window.location = 'kelas.php';  
               },
               error : function(){
                  alert("Gagal Hapus");
               }
            });
         }
     }
  </script>

</body>

</html>