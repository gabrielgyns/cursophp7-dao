<?php 

require_once("config.php");

/*$sql = new Sql();
$usuarios = $sql->select("SELECT * FROM tb_usuario");

echo json_encode($usuarios);*/

//Carrega um usuário
//$user = new Usuario();
//$user->loadById(3);
//echo $user;

//Carrega uma lista de usuário
//$lista = Usuario::getList();
//echo json_encode($lista);

//Carrega uma lista de usuarios buscando pelo login
//$busca = Usuario::search("y");
//echo json_encode($busca);

//Faz login no sistema
$login = new Usuario();
$login->login("gabriel", "254654");

echo $login;


?>