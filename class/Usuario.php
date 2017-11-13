<?php 

class Usuario{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario(){
		return $this->idusuario;
	}
	public function setIdusuario($idusuario){
		$this->idusuario = $idusuario;
	}

	public function getDeslogin(){
		return $this->deslogin;
	}
	public function setDeslogin($deslogin){
		$this->deslogin = $deslogin;
	}

	public function getDessenha(){
		return $this->dessenha;
	}
	public function setDessenha($dessenha){
		$this->dessenha = $dessenha;
	}

	public function getDtcadastro(){
		return $this->dtcadastro;
	}
	public function setDtcadastro($dtcadastro){
		$this->dtcadastro = $dtcadastro;
	}

	//Metódo criado devido a utiliar várias vezes o "results" com os dados abaixo.
	public function setData($data){
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new Datetime($data['dtcadastro']));
	}

	public function loadById($id){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = :ID", array(
			":ID"=>$id
		));

		if (isset($result[0])) {
			$this->setData($result[0]);
		}
	}

	public function login($deslogin, $dessenha){
		$sql = new Sql();
		$result = $sql->select("SELECT * FROM tb_usuario WHERE deslogin = :DESLOGIN AND dessenha = :DESSENHA", array(
			":DESLOGIN"=>$deslogin,
			":DESSENHA"=>$dessenha
		));

		if (isset($result[0])) {
			$this->setData($result[0]);
		} else {
			throw new Exception("Login e/ou senha inválidos.");
		}
	}

	/* 
	## Não está funcionando chamar pela procedure como na video aula, então criei o método "isnert" que funciona.
	## Seria interessante fazer por procedure, pois não iria precisar fazer tantas requisições no banco, evitaria lentidão.

	public function cadastro(){
		$sql = new Sql();
		$result_test = $sql->select("CALL sp_usuarios_insert(:DESLOGIN, :DESSENHA)", array(
			':DESLOGIN'=>$this->getDeslogin(),
			':DESSENHA'=>$this->getDessenha()
		));

		$result = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = LAST_INSERT_ID();");

		if (isset($result[0])) {
			$this->setData($result[0]);
		}
	}
	## Meu método INSERT abaixo:           */
	public function insert(){
		$sql = new Sql();
		$test = $sql->select("INSERT INTO tb_usuario (deslogin, dessenha) VALUES (:DESLOGIN, :DESSENHA);", array(
			':DESLOGIN'=>$this->getDeslogin(),
			':DESSENHA'=>$this->getDessenha()
		));

		$result = $sql->select("SELECT * FROM tb_usuario WHERE idusuario = LAST_INSERT_ID();");

		if (isset($result[0])) {
			$this->setData($result[0]);
		}
	}

	public function update($login, $password){
		$this->setDeslogin($login);
		$this->setDessenha($password);
		$sql = new Sql();
		$sql->query("UPDATE tb_usuario SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdusuario()
		));
	}	
	public function delete(){
		$sql = new Sql();
		$sql->query("DELETE FROM tb_usuario WHERE idusuario = :ID", array(
			':ID'=>$this->getIdusuario()
		));

		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(new DateTime());
	}	

	public static function getList(){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuario ORDER BY deslogin");
	}

	public static function search($login){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuario WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%" . $login . "%"
		));
	}

	public function __toString(){
		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
		));
	}

}


?>