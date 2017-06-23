<?php

// include mylib.php (contains Logging class)
include('mylib.php');

// Logging class initialization
$log = new FilesLib();

// set path and name of log file (optional)
$log->lfile('C:\Program Files (x86)\RGB&\LP1000H_M\tdtd.txt');

// write message to the log file
$log->lwrite('Test message1');
$log->lwrite('Test message2');
$log->lwrite('Test message3');

// close log file
$log->lclose();

?>