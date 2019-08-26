<?php
  error_reporting(0);
  session_start();
  session_destroy();
  echo "<script>
      alert('Anda berhasil logout'); 
      window.location = 'index.php';
      </script>";
?>
