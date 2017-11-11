<?php 

class Sql extends PDO{
	private $con;

	# Quando fizer o "new", quando instanciar essa classe, será feito automaticamente o código abaixo, o método mágico construtor.
	public function __construct(){
		$this->con = new PDO("mysql: host=localhost; dbname=db_php7", "root", "");
	}

	private function setParams($statment, $parameters){
		foreach ($parameters as $key => $value) {
			
			$this->setParam($statment, $key, $value);
			
		}
	}

	private function setParam($statment, $key, $value){
		$statment->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array()){
		$stmt = $this->con->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt;
	}

	public function select($rawQuery, $params = array()):array{
		$stmt = $this->query($rawQuery, $params);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

}

?>