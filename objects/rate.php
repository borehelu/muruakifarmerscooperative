<?php

class MilkRate{

  // database connection and table name
  private $conn;
  private $table_name = "milkrate";

  // object properties
	public $rate;
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function setRate() {

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                rate = :rate";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    // sanitize
    $this->rate=htmlspecialchars(strip_tags($this->rate));
    


		// bind the values
    $stmt->bindParam(':rate', $this->rate);
    
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

  public function readMilkRate(){
    // query
    $query = "SELECT *
    FROM " . $this->table_name ;

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    // return values
    if($stmt->rowCount() > 0){
      extract($row = $stmt->fetch(PDO::FETCH_ASSOC));
      return $rate;
    }else{
      return 0;

    }
    
  }

  




  
}

?>