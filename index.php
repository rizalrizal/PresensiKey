<?php 
error_reporting(0);
session_start();
ob_start();

if(isset($_SESSION['username']) || isset($_SESSION['password'])){
    echo "<script>
      window.location = 'kelas.php';
      </script>";
}
include 'koneksi.php'; 

?>
<!doctype html>
<html lang="en">

<head>
  <title>PresensiKEY</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="./css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/animate.css">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="container-fluid gradient-1">
    <!-- line -->
    <div class="row position-relative">
      <div class="col-8 position-absolute d-inline-block line animated fadeInLeft text-center">
        <img src="./assets/logoBG.png" class="d-flex mx-auto w-50">

        <!-- img bottom -->
        <img class="img-fluid animated fadeInDown w-30" style="margin-top: 100px;" src="./assets/sosmed.png" alt="">
      </div>
    </div>

    <div class="row h-100 ">
      <div class="my__center col-8 pl-5">
        <h2 class="animated fadeInLeft  presensi__animate">presensi</h2>
        <h1 class="animated fadeInLeft">Kelas Eksekutif #YukNgaji</h1>
      </div>

      <div class="my__center text-center col-4">
        <img class="w-75 img-fluid animated fadeInDown mb-3" src="./assets/logo.png" alt="">
        <form id="frm_login" class="w-75 mx-auto mb-5">
          <div class="alert alert-danger" role="alert" style="font-size: 0.8rem !important;"></div>
          <div class="input-group input-group-lg mb-3 animated fadeInRight user__animate">
            <div class="input-group-prepend">
              <span class="input-group-text__mod">USER</span>
            </div>
            <input type="text" class="form-control transparent__input" name="username">
          </div>
          <div class="input-group input-group-lg mb-3 animated fadeInRight pass__animate">
            <div class="input-group-prepend">
              <span class="input-group-text__mod">PASS</span>
            </div>
            <input type="password" class="form-control transparent__input" name="password">
          </div>
          <button type="submit"  class="btn btn-light rounded-lg btn-block btn__mod animated fadeInLeft btn__animate">LOGIN</button>
        </form>

        


      </div>
    </div>
  </div>

  <script src="./js/jquery-3.3.1.min.js"></script>
     <script type="text/javascript">
    
    $(function(){
       $('.alert').hide();
       $('#frm_login').submit(function(){
          $('.alert').hide();
          if($('input[name=username]').val() == ""){
             $('.alert').fadeIn().html('<b>USER</b> masih kosong!');
          }else if($('input[name=password]').val() == ""){
             $('.alert').fadeIn().html('<b>PASS</b> masih kosong!');
          }else{
             $.ajax({
                type : "POST",
                url : "ajax/ajax_login_cek.php?action=cek_login",
                data : $(this).serialize(),
                success : function(data){
                   if(data == "ok") window.location = "kelas.php";  
                   else $('.alert').fadeIn().html(data);  
                }
             });
          }
          return false;
       });
    });
    </script>
  <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>