<?php

class Delivery{

  // database connection and table name
  private $conn;
  private $table_name = "deliveries";

  // object properties
	public $id;
	public $farmer_id;
	public $litres_delivered;
  public $date;
  
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function addDelivery() {
        
    $this->date = date('Y-m-d H:i:s');

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                farmer_id = :farmer_id,
                litres_delivered = :litres_delivered,
                date = :date";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

   
		// bind the values
    $stmt->bindParam(':farmer_id', $this->farmer_id);
    $stmt->bindParam(':litres_delivered', $this->litres_delivered);
    $stmt->bindParam(':date', $this->date);
   


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

  public function readDailyDeliveries(){

    // query select all classes
    $query = "SELECT SUM(litres_delivered) as total_daily_delivery FROM " . $this->table_name . "
                WHERE DATE(date) = CURRENT_DATE()";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );
    


    // execute query
    $stmt->execute();

    // return values
    return $stmt;
    
}

public function readCumulativeDeliveries(){

  // query select all classes
  $query = "SELECT SUM(litres_delivered) as total_delivery FROM " . $this->table_name;
              

  // prepare query statement
  $stmt = $this->conn->prepare( $query );
  


  // execute query
  $stmt->execute();

  // return values
  return $stmt;
  
}


 public function readDeliveriesForReport(){

   $query = "SELECT date, litres_delivered, (SELECT SUM(litres_delivered) FROM deliveries WHERE farmer_id = :farmer_id) AS total_delivered 
              FROM `deliveries` WHERE farmer_id = :farmer_id";

    // prepare the query
		$stmt = $this->conn->prepare($query);

		// bind the values
    $stmt->bindParam(':farmer_id', $this->farmer_id);

    // execute query
    $stmt->execute();

    // return values
    return $stmt;



 }





  
}

?>