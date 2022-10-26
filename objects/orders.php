<?php

class Order{

  // database connection and table name
  private $conn;
  private $table_name = "orders";

  // object properties
    public $id;
    public $farmer_id;
    public $status;
    public $total;
    public $created;
    public $modified;
  
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function addNewOrder() {

		$this->created=date('Y-m-d H:i:s');

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                farmer_id = :farmer_id,
                status = :status,
                total = :total,
                created = :created,
                modified = :modified";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    $this->modified = $this->created;
    
  

		// bind the values
    $stmt->bindParam(':farmer_id', $this->farmer_id);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':total', $this->total);
    $stmt->bindParam(':created', $this->created);
    $stmt->bindParam(':modified', $this->modified);
   


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

  	// update the cart_item
	public function updateOrderTotal(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET total = :total
				WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(':total', $this->total);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

		// update the cart_item
		public function changeOrderStatus(){

			// update query
			$query = "UPDATE " . $this->table_name . "
					SET status = :status
					WHERE id = :id";
	
			// prepare query statement
			$stmt = $this->conn->prepare($query);
	
			// bind values
			$stmt->bindParam(':status', $this->status);
			$stmt->bindParam(':id', $this->id);
	
			// execute the query
			if($stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

    	// delete the product
	function deleteAllByUser(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE farmer_id = ? AND id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->farmer_id);
        $stmt->bindParam(2, $this->id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function readAllOrdersByUser(){

		// query select all classes
		$query = "SELECT *
		FROM " . $this->table_name . "
		WHERE farmer_id = ?";
	
		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		$stmt->bindParam(1, $this->farmer_id);
		
		// execute query
		$stmt->execute();
	
		// return values
		return $stmt;
	 }

	 public function readAllOrdersByUserReport(){

		// query select all classes
		$query = "SELECT id, total, modified, (SELECT SUM(total) FROM orders WHERE farmer_id = ?) AS total_value
		FROM " . $this->table_name . "
		WHERE farmer_id = ? AND status = 2";
	
		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		$stmt->bindParam(1, $this->farmer_id);
		$stmt->bindParam(2, $this->farmer_id);
		
		// execute query
		$stmt->execute();
	
		// return values
		return $stmt;
	 }

	 public function readAllOrders(){

		// query select all classes
		$query = "SELECT *
		FROM " . $this->table_name ;
	
		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();
	
		// return values
		return $stmt;
	 }

	 public function readSingleOrderByUser(){

		// query select all classes
		$query = "SELECT * FROM " . $this->table_name . "
					WHERE farmer_id = ? AND id = ?";
	
		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		$stmt->bindParam(1, $this->farmer_id);
		$stmt->bindParam(2, $this->id);
		
		// execute query
		$stmt->execute();
	
		// return values
		return $stmt;
	 }

	// update the cart_item
	public function updateOrderTotalOnCancel(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET total = (SELECT total FROM orders WHERE id = :id) - :total
				WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(':total', $this->total);
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