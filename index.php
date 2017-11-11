<?php 

require_once("config.php");

/*$sql = new Sql();
$usuarios = $sql->select("SELECT * FROM tb_usuario");

echo json_encode($usuarios);*/

$user = new Usuario();
$user->loadById(3);
echo $user;

?>