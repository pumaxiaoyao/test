<?php


class admin  
{  

  function verifycode()
  {   
      session_start();
      require dirname(__FILE__).'/ValidateCode.class.php';
      $_vc = new ValidateCode();		
      $_vc->doimg();		
      $_SESSION['authnum_session'] = $_vc->getCode();
      
  }  

  function test($ee)
  {
      echo $ee;
      echo "hello from index test.";
  }
}  

$aa = new admin();
$aa->verifycode();
?>  
