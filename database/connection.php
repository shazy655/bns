
<?php 
//Database connection, replace with your connection string.. Used PDO
$conn = new PDO("mysql:host=localhost;dbname=bns", 'root', '');   

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
