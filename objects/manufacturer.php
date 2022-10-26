<?php

class Manufacturer{

  // database connection and table name
  private $conn;
  private $table_name = "manufacturer";

  // object properties
	public $id;
	public $name;
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function addManufacturer() {

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                name = :name";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    


		// bind the values
    $stmt->bindParam(':name', $this->name);
    
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

  public function readAllManufacturers(){
    // query
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

  public function getNumberOfManufacturers(){
    // query
    $query = "SELECT *
    FROM " . $this->table_name . "
    ORDER BY id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    $manufacturers = $stmt->rowCount();

    // return values
    return $manufacturers;

  }

	public function readOneManufacturer(){

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

      }

      else{
        return false;
      }

      // return values
      return $stmt;
   }





  
}

?>