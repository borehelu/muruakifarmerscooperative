<?php

class OrderedInput{

  // database connection and table name
  private $conn;
  private $table_name = "ordered_inputs";

  // object properties
    public $id;
    public $input_id;
    public $order_id;
    public $quantity;
    public $total;
    public $status;
    public $created;
    public $modified;
  
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function newInputOrder() {

		$this->created=date('Y-m-d H:i:s');

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                input_id = :input_id,
                order_id = :order_id,
                quantity = :quantity,
                total = :total,
                status = 0,
                created = :created,
                modified = :modified";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    $this->modified = $this->created;
    
  

		// bind the values
    $stmt->bindParam(':input_id', $this->input_id);
    $stmt->bindParam(':order_id', $this->order_id);
    $stmt->bindParam(':quantity', $this->quantity);
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

  public function readAllOrderedInputsByFarmer(){
    // query
    $query = "SELECT o.id, o.input_id, o.order_id, o.total, (SELECT SUM(total) FROM ordered_inputs WHERE order_id = ?) AS sum_total, o.quantity,o.status, o.created, o.modified, f.name ,f.description, f.price, f.photo, f.unit_of_measure
                FROM " . $this->table_name . " as o
                LEFT JOIN
                      farm_inputs f
                      ON
                          o.input_id = f.id
                WHERE order_id = ?
               
                ORDER BY o.id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    
    $stmt->bindParam(1, $this->order_id);
    $stmt->bindParam(2, $this->order_id);

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
  }

  public function readAllOrderedInputsByAllFarmers(){
    // query
    $query = "SELECT o.id, o.input_id, o.order_id, o.total, (SELECT SUM(total) FROM ordered_inputs) AS sum_total, o.quantity,o.status, o.created, o.modified, f.name ,f.description, f.price, f.photo, f.unit_of_measure
                FROM " . $this->table_name . " as o
                LEFT JOIN
                      farm_inputs f
                      ON
                          o.input_id = f.id
                WHERE created = ?
                ORDER BY o.id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    
    $stmt->bindParam(1, $this->created);
    

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
  }

  
  public function readMostDemandedInput(){
    // query
    $query = "SELECT  SUM(o.quantity) as total_ordered, SUM(o.total) as total_generated,f.name, f.price
              FROM ordered_inputs as o
              LEFT JOIN
                    farm_inputs f
                    ON
                        o.input_id = f.id
                        GROUP BY input_id
              ORDER BY o.id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
  }

	public function deleteAllByOrderID(){
        // delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE order_id = ? ";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->order_id);
        

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
    }


  public function readSingleOrderedItem(){
    // query
    $query = "SELECT * FROM " . $this->table_name . "
                WHERE order_id = :order_id AND input_id = :input_id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    
    $stmt->bindParam(':order_id', $this->order_id);
    $stmt->bindParam(':input_id', $this->input_id);

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
  }

    public function deleteOrderedItem(){
      // delete query
      $query = "DELETE FROM " . $this->table_name . " WHERE order_id = ? AND input_id = ?";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // bind record id
      $stmt->bindParam(1, $this->order_id);
      $stmt->bindParam(2, $this->input_id);
          

      // execute the query
      if($result = $stmt->execute()){
        return true;
      }else{
        return false;
      }
  }


  public function readAllDeliveredOrderedInputs(){
    // query
    $query = "SELECT SUM(quantity) as delivered_inputs FROM ordered_inputs
              WHERE status = 2 
              ORDER BY id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    
    // $stmt->bindParam(1, $this->order_id);

    // execute query
    $stmt->execute();

    
    if($stmt->rowCount() > 0){
      extract($stmt->fetch(PDO::FETCH_ASSOC));
      return $delivered_inputs;

    } else{
      return 0;
    }
    return 0;

  }

	// update order inputs
	function cancelOrder(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET status = 3
				WHERE order_id = :order_id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(':order_id', $this->order_id);
		

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
            WHERE order_id = :order_id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // bind values
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':order_id', $this->order_id);
    
        // execute the query
        if($stmt->execute()){
          return true;
        }else{
          return false;
        }
      }



  
}

?>