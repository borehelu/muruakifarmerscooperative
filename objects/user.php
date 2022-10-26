<?php

class User{

  // database connection and table name
  private $conn;
  private $table_name = "users";

  // object properties
	public $id;
	public $name;
	public $password;
	public $phone;
	public $status;
	public $date;
	public $email;
	public $password_updated;
	public $accesss_right;
	public $access_code;
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	// create new student record
	function addUser() {

		$this->date=date('Y-m-d H:i:s');

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                name = :name,
                email = :email,
                password= :password,
                date = :date,
                phone = :phone,
                status = 1,
                password_updated = 0,
                route = :route,
                access_right = :access_right,
				access_code = :access_code";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email)); 
    $this->access_right=htmlspecialchars(strip_tags($this->access_right)); 


	// hash the password before saving to database
	$password_hash = password_hash($this->password, PASSWORD_BCRYPT);

		// bind the values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':password', $password_hash);
    $stmt->bindParam(':date', $this->date);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':route', $this->route);
    $stmt->bindParam(':access_right', $this->access_right);
	$stmt->bindParam(':access_code', $this->access_code);
   


		// execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }else{
        $this->showError($stmt);
        return false;
    }

	}
  public function showError($stmt){
    echo "<pre>";
      print_r($stmt->errorInfo());
    echo "</pre>";
  }

  public function readAllUsers(){
    // query select all classes
    $query = "SELECT *
    FROM " . $this->table_name . "
    ORDER BY id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
  }

	public function readOneUser(){

			// query select all classes
      $query = "SELECT *
      FROM " . $this->table_name . "
      WHERE id = :id";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );
      $stmt->bindParam(":id", $this->id);


      // execute query
      $stmt->execute();
      $count = $stmt->rowCount();

      if($count > 0){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->route = $route;
        $this->status = $status;
        $this->password_updated = $password_updated;

      }

      else{
        return false;
      }

   }


	public function readAllFarmers(){

    // query select all classes
    $query = "SELECT *
    FROM " . $this->table_name . "
    WHERE access_right = 2";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    
    // execute query
    $stmt->execute();

    // return values
    return $stmt;
 }

 function validateEmailandPhone($criteria){

    $query = "SELECT * FROM ". $this->table_name . " WHERE phone = ? OR email = ?";
    
    //prepare query statement
    $stmt = $this->conn->prepare( $query );

    $stmt->bindParam( 1,$criteria);
    $stmt->bindParam( 2,$criteria);
    

    // execute query
    $stmt->execute();

    

	if($stmt->rowCount() > 0){
		return true;
	}else{
		return false;
	}

		
	}

  // check if given email exist in the database
	function emailExists(){

		// query to check if email exists
		$query = "SELECT * FROM " . $this->table_name . "
				WHERE email = ?
				LIMIT 0,1";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->email=htmlspecialchars(strip_tags($this->email));

		// bind given email value
		$stmt->bindParam(1, $this->email);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){
			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// assign values to object properties
			$this->id = $row['id'];
			$this->name = $row['name'];
			$this->access_right = $row['access_right'];
			$this->access_code = $row['access_code'];
			$this->password = $row['password'];
			$this->status = $row['status'];
      		$this->password_updated = $row['password_updated'];
			  

			// return true because email exists in the database
			return true;
		}

      // return false if email does not exist in the database
      return false;
	}


  	// update the product
	function updateUserDetails(){

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					name = :name,
					email = :email,
					phone  = :phone,
					status  = :status,
          route = :route
				WHERE
					id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->email=htmlspecialchars($this->email);
		$this->phone=htmlspecialchars(strip_tags($this->phone));
		$this->status=htmlspecialchars(strip_tags($this->status));
   		$this->route=htmlspecialchars(strip_tags($this->route));
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind variable values
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':phone', $this->phone);
		$stmt->bindParam(':status', $this->status);
    	$stmt->bindParam(':route', $this->route);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function updateUserPassword(){

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password = :password,
					password_updated = 1
				WHERE
					access_code = :access_code";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->id=htmlspecialchars(strip_tags($this->id));


	// hash the password before saving to database
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		// bind variable values
		$stmt->bindParam(':password', $password_hash);
		$stmt->bindParam(':access_code', $this->access_code);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
	
	// used in forgot password feature
	function updateAccessCode(){
	
		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					access_code = :access_code
				WHERE
					email = :email";
	
		// prepare the query
		$stmt = $this->conn->prepare($query);
	
		// sanitize
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));
		$this->email=htmlspecialchars(strip_tags($this->email));
	
		// bind the values from the form
		$stmt->bindParam(':access_code', $this->access_code);
		$stmt->bindParam(':email', $this->email);
	
		// execute the query
		if($stmt->execute()){
			return true;
		}
	
		return false;
	}

	
// check if given access_code exist in the database
function accessCodeExists(){
 
    // query to check if access_code exists
    $query = "SELECT id
            FROM " . $this->table_name . "
            WHERE access_code = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->access_code=htmlspecialchars(strip_tags($this->access_code));
 
    // bind given access_code value
    $stmt->bindParam(1, $this->access_code);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // if access_code exists
    if($num>0){
 
        // return true because access_code exists in the database
        return true;
    }
 
    // return false if access_code does not exist in the database
    return false;
 
}

  
}

?>