<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/

// Define a destination
$targetFolder = '/uploads'; // Relative to the root
// var_dump($_FILES['Filedata']);
$tempFile = $_FILES['Filedata']['tmp_name'];
$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
$urlPath = $targetFolder . "/". $_FILES['Filedata']['name'];
// Validate the file type
$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
$fileParts = pathinfo($_FILES['Filedata']['name']);

if (in_array($fileParts['extension'],$fileTypes)) {
	move_uploaded_file($tempFile,$targetFile);
	
	echo json_encode(["path" => $urlPath]);
} else {
	echo 'Invalid file type.';
}

?>