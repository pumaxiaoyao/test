<?php
session_start();
require './ValidateCode.class.php';
$_vc = new ValidateCode();
$_vc->doimg();		
$_SESSION['Verifycode'] = $_vc->getCode();
?>