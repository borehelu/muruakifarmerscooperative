<?php

class Account{

  // database connection and table name
  private $conn;
  private $table_name = "accounts";

  // object properties
    public $id;
    public $farmer_id;
    public $total_delivered;
    public $gross_pay;
    public $total_deduction;
    public $date;
  
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function initialiseAccount() {
        
        $this->date = date('Y-m-d H:i:s');

            // create query
            $query = "INSERT INTO " . $this->table_name . "
                            SET
                    farmer_id = :farmer_id,
                    total_delivered = 0,
                    gross_pay = 0,
                    total_deduction = 0,
                    date = :date";
            
        // prepare the query
            $stmt = $this->conn->prepare($query);

    
            // bind the values
        $stmt->bindParam(':farmer_id', $this->farmer_id);
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


  	// update the product
	function updateAccountDetailsOnDelivery($litres_delivered, $milkrate){

        $this->date = date('Y-m-d H:i:s');

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					total_delivered = :total_delivered,
                    gross_pay = :gross_pay,
                    date = :date

				WHERE
					farmer_id = :farmer_id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

        $details = $this->readAccountDetails();

        if($details->rowCount() > 0){

            extract($row = $details->fetch(PDO::FETCH_ASSOC));

            $this->total_delivered = $total_delivered + $litres_delivered;
            $this->gross_pay = $gross_pay + ($litres_delivered * $milkrate);

            // bind variable values
            $stmt->bindParam(':total_delivered', $this->total_delivered);
            $stmt->bindParam(':gross_pay', $this->gross_pay);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':farmer_id', $this->farmer_id);

            // execute the query
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        } else{
            return false;
        }
	
	}


      	// update the product
	function updateAccountDetailsOnOrder($new_deduction){

        $this->date = date('Y-m-d H:i:s');

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					total_deduction = :total_deduction,
                    date = :date

				WHERE
					farmer_id = :farmer_id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

        $details = $this->readAccountDetails();

        if($details->rowCount() > 0){

            extract($row = $details->fetch(PDO::FETCH_ASSOC));

            $this->total_deduction = $total_deduction + $new_deduction;
            

            // bind variable values
            $stmt->bindParam(':total_deduction', $this->total_deduction);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':farmer_id', $this->farmer_id);

            // execute the query
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        } else{
            return false;
        }
	
	}

          	// update the product
	function updateAccountDetailsOnCancelOrder($new_deduction){

        $this->date = date('Y-m-d H:i:s');

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					total_deduction = :total_deduction,
                    date = :date

				WHERE
					farmer_id = :farmer_id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

        $details = $this->readAccountDetails();

        if($details->rowCount() > 0){

            extract($row = $details->fetch(PDO::FETCH_ASSOC));

            $this->total_deduction = $total_deduction - $new_deduction;
            

            // bind variable values
            $stmt->bindParam(':total_deduction', $this->total_deduction);
            $stmt->bindParam(':date', $this->date);
            $stmt->bindParam(':farmer_id', $this->farmer_id);

            // execute the query
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        } else{
            return false;
        }
	
	}


	public function readAccountDetails(){

        // query select all classes
        $query = "SELECT * FROM " . $this->table_name . "
                    WHERE farmer_id = :farmer_id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":farmer_id", $this->farmer_id);


        // execute query
        $stmt->execute();

        // return values
        return $stmt;
        
    }

    public function readAccountDetailsForReport(){

        // query select all classes
        $query = "SELECT a.gross_pay,a.total_deduction,u.name, u.email, u.route
                    FROM `accounts` a
                    LEFT JOIN users u ON u.id = a.farmer_id    
                    WHERE a.farmer_id = :farmer_id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(":farmer_id", $this->farmer_id);


        // execute query
        $stmt->execute();

        // return values
        return $stmt;
        
    }



  
}

?>