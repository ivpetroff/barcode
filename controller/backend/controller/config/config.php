<?php
 
/*
 * DB Connect 
 */
$username_DB = 'root';
$password_DB = '';
$name_DB     = 'mercari_barcode';
$localhost   = 'localhost';
 
//CONNECTION DB
$conn = new mysqli($localhost, $username_DB, $password_DB, $name_DB);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$DS = DIRECTORY_SEPARATOR;

//  PATH DIRECTORY
$BASEPATH  = $_SERVER['DOCUMENT_ROOT'];

// SITE NAME
$DOMAIN = $_SERVER['SERVER_NAME'];


 







