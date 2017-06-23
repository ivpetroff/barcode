<?php

header('Content-Type: application/json');

if(isset($_POST['FileName'])) {
	$sFilename = $_POST['FileName'];
} else {
	$sFilename = $_FILES['file']['name'];
}
$sPath = './Audio/'.$sFilename;
if(is_file($sPath)) {
	unlink($sPath);
}
move_uploaded_file($_FILES['file']['tmp_name'], $sPath);

echo json_encode(array('Error' => 0, 'Message' => 'Файлът "'.$sFilename.'" е успешно качен.'));