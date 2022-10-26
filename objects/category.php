<?php

class Category{

  // database connection and table name
  private $conn;
  private $table_name = "input_category";

  // object properties
	public $id;
	public $name;
	public $description;
  
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function addCategory() {

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                name = :name,
                description = :description";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description)); 


		// bind the values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
   


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

  public function readAllCategories(){
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

  public function getNumberOfCategories(){
    // query
    $query = "SELECT *
    FROM " . $this->table_name . "
    ORDER BY id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    $categories = $stmt->rowCount();

    // return values
    return $categories;

  }

	public function readOneCategory(){

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
        $this->description = $description;
       
      }

      else{
        return false;
      }

      // return values
      return $stmt;
   }





  	// update the product
	function updateCategoryDetails(){

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					name = :name,
          description = :description
				WHERE
					id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
	  $this->description=htmlspecialchars(strip_tags($this->description));
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind variable values
		$stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}


  
}

?>