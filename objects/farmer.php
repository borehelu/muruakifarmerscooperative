<?php

class Farmer{

  // database connection and table name
  private $conn;
  private $table_name = "users";

  // object properties
	public $id;
	public $name;
	public $password;
	public $date;
	public $phone;
	public $route;
	public $email;
  public $access_right;
  public $status;
	
	
	
	// constructor
  public function __construct($db){
      $this->conn = $db;
  }

  //error handler
  public function showError($stmt){
    echo "<pre>";
      print_r($stmt->errorInfo());
    echo "</pre>";
  }
   

	
	function addFarmer() {

		$this->date = date('Y-m-d H:i:s');

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                name = :name,
                email = :email,
                password= :password,
                date = :date,
                phone = :phone,
                route = :route,
                access_right = 2,
                status = 1";

		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->phone=htmlspecialchars(strip_tags($this->phone));
    $this->route=htmlspecialchars(strip_tags($this->route));
    
    

    $this->password= $this->phone;

		// hash the password before saving to database
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
			
		

		// bind the values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':date', $this->date);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':route', $this->route);
    
   


		// execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }else{
        $this->showError($stmt);
        return false;
    }

	}
		

  public function readAllFarmers(){
    // query select all classes
    $query = "SELECT *
    FROM " . $this->table_name . " WHERE access_right = 2
    ORDER BY id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
	}
  

	public function readOneFarmer(){

			// query select all classes
      $query = "SELECT *
      FROM " . $this->table_name . "
      WHERE id = :id AND access_right = 2";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );
      $stmt->bindParam(":id", $this->id);


      // execute query
      $stmt->execute();

      // return values
      return $stmt;
   }

	function searchFarmer($criteria){

    $query = "SELECT * FROM ". $this->table_name . " WHERE access_right = 2 AND (phone = ? OR name = ? OR email = ?)";
    
    //prepare query statement
    $stmt = $this->conn->prepare( $query );

    $stmt->bindParam( 1,$criteria);
    $stmt->bindParam( 2,$criteria);
    $stmt->bindParam( 3,$criteria);

    // execute query
    $stmt->execute();

    // return values
    return $stmt;

		
	}

  
}

?>