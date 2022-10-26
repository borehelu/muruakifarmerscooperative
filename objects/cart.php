<?php
// 'cart_item' object
class CartItem{

	// database connection and table name
	private $conn;
	private $table_name = "cart";

	// object properties
	public $id;
	public $input_id;
	public $quantity;
	public $farmer_id;
	public $created;

	// constructor
	public function __construct($db){
		$this->conn = $db;

	}

	// delete the product
	function removeFromCart(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ? AND farmer_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->farmer_id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete the product
	function deleteAllByUser(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE farmer_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->farmer_id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}




	// update the cart_item
	function updateCart(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET quantity = :quantity
				WHERE farmer_id = :farmer_id AND id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(':quantity', $this->quantity);
		$stmt->bindParam(':farmer_id', $this->farmer_id);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// create cart_item
	function addToCart(){

		$this->created= date('Y-m-d H:i:s');

		// insert query
		$query = "INSERT INTO " . $this->table_name . "
					SET input_id=:input_id, quantity=:quantity,farmer_id=:farmer_id, created=:created";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->input_id=htmlspecialchars(strip_tags($this->input_id));
		$this->quantity=htmlspecialchars(strip_tags($this->quantity));
		$this->farmer_id=htmlspecialchars(strip_tags($this->farmer_id));
		
		// bind values
		$stmt->bindParam(":input_id", $this->input_id);
		$stmt->bindParam(":quantity", $this->quantity);
		$stmt->bindParam(":farmer_id", $this->farmer_id);
		$stmt->bindParam(":created", $this->created);

		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

    public function readCart(){

        // query select all classes
        $query = "SELECT c.id, c.input_id, c.quantity as cart_quantity, f.name, f.description, f.price, f.quantity as input_quantity, f.unit_of_measure, f.sold, f.photo
					FROM " . $this->table_name . " c
						LEFT JOIN farm_inputs f
							ON c.input_id = f.id
					WHERE farmer_id = :farmer_id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":farmer_id", $this->farmer_id);


        // execute query
        $stmt->execute();

		// return values
        return $stmt;
        
    }

	public function readSingleCart(){

        // query select all classes
        $query = "SELECT c.id, c.input_id, c.quantity, f.name, f.description, f.price, f.unit_of_measure, f.sold, f.photo
					FROM " . $this->table_name . " c
						LEFT JOIN farm_inputs f
							ON c.input_id = f.id
					WHERE c.id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );
		$stmt->bindParam(":id", $this->id);


        // execute query
        $stmt->execute();

		
		// return values
        return $stmt;
        
    }


    public function inputExistsInCart(){

        // query select all classes
        $query = "SELECT * FROM " . $this->table_name . "
                    WHERE farmer_id = :farmer_id AND input_id = :input_id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":farmer_id", $this->farmer_id);
		$stmt->bindParam(":input_id", $this->input_id);


        // execute query
        $stmt->execute();

        // return values
		if($stmt->rowCount() > 0){
			return true;
		}else{
			return false;
		}
        
    }



	

}
?>
