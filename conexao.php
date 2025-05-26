<?php

$conexao = new PDO("mysql:host=localhost;dbname=xxx", "xxx", "xxx", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
return $conexao;	

?>
