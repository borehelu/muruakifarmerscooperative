<?php

class FarmInput{

  // database connection and table name
  private $conn;
  private $table_name = "farm_inputs";

  // object properties
	public $id;
	public $name;
	public $description;
  public $category;
  public $manufacturer;
  public $price;
  public $unit_of_measure;
  public $quantity;
  public $sold;
  public $photo;
  public $date;
  public $modified;
  
	
	
	
	// constructor
    public function __construct($db){
        $this->conn = $db;
    }
   

	
	function addFarmInput() {

		$this->date=date('Y-m-d H:i:s');

		// create query
		$query = "INSERT INTO " . $this->table_name . "
						  SET
                name = :name,
                description = :description,
                category_id= :category_id,
                manufacturer_id = :manufacturer_id,
                price = :price,
                quantity = :quantity,
                unit_of_measure = :unit_of_measure,
                sold = :sold,
                photo = :photo,
                date = :date,
                modified = :modified";
		
    // prepare the query
		$stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->description=htmlspecialchars(strip_tags($this->description)); 
    $this->unit_of_measure=htmlspecialchars(strip_tags($this->unit_of_measure)); 

    $this->modified = $this->date;
    $this->sold = 0;
    $this->uploadInputImage();
  

		// bind the values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':category_id', $this->category_id);
    $stmt->bindParam(':manufacturer_id', $this->manufacturer_id);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':unit_of_measure', $this->unit_of_measure);
    $stmt->bindParam(':quantity', $this->quantity);
    $stmt->bindParam(':sold', $this->sold);
    $stmt->bindParam(':photo', $this->photo);
    $stmt->bindParam(':date', $this->date);
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

  public function readAllFarmInputs(){
    // query
    $query = "SELECT i.id, i.photo, i.name, i.description, c.name as category_name, m.name as manufacturer_name, i.price, i.unit_of_measure, i.quantity, i.sold,  i.date, i.modified
                FROM " . $this->table_name . " as i
                LEFT JOIN
                      input_category c
                      ON
                          i.category_id = c.id
                LEFT JOIN
                      manufacturer m
                      ON
                          i.manufacturer_id = m.id
                ORDER BY i.id";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // execute query
    $stmt->execute();

    // return values
    return $stmt;
  }

	public function readOneFarmInput(){

			// query select all classes
      $query = "SELECT i.id, i.photo, i.name, i.description, c.id as category_id, c.name as category,m.id as manufacturer_id, m.name as manufacturer, i.price, i.unit_of_measure, i.quantity, i.sold,  i.date, i.modified
                  FROM " . $this->table_name . " as i
                  LEFT JOIN
                        input_category c
                        ON
                            i.category_id = c.id
                  LEFT JOIN
                        manufacturer m
                        ON
                            i.manufacturer_id = m.id
                  WHERE i.id = :id";

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
        $this->price = $price;
        $this->unit_of_measure = $unit_of_measure;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->manufacturer_id = $manufacturer_id;
        $this->photo = $photo;
        return true;
        

      }

      else{
        return false;
      }

      
   }




  	// update the product
	function updateFarmInput(){

    $this->modified=date('Y-m-d H:i:s');

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
          name = :name,
          description = :description,
          category_id= :category_id,
          manufacturer_id = :manufacturer_id,
          price = :price,
          quantity = :quantity,
          unit_of_measure = :unit_of_measure,
          modified = :modified
				WHERE
					id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
	  $this->description=htmlspecialchars(strip_tags($this->description));
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind variable values
			// bind the values
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':description', $this->description);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':manufacturer_id', $this->manufacturer_id);
      $stmt->bindParam(':price', $this->price);
      $stmt->bindParam(':unit_of_measure', $this->unit_of_measure);
      $stmt->bindParam(':quantity', $this->quantity);
      $stmt->bindParam(':modified', $this->modified);
      $stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

   	// update the product
	function updateQuantity(){

    $this->modified=date('Y-m-d H:i:s');

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
          sold = (SELECT sold FROM farm_inputs WHERE id = :id) + :sold, 
          modified = :modified
				WHERE
					id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

    
			// bind the values
      $stmt->bindParam(':sold', $this->sold);
      $stmt->bindParam(':modified', $this->modified);
      $stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}


  	// update the product
	function updateQuantityOnCancelOrder(){

    $this->modified=date('Y-m-d H:i:s');

		// product update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
          sold = (SELECT sold FROM farm_inputs WHERE id = :id) - :sold, 
          modified = :modified
				WHERE
					id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

    
			// bind the values
      $stmt->bindParam(':sold', $this->sold);
      $stmt->bindParam(':modified', $this->modified);
      $stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

 public function getNumberOfInputs(){
   // query
   $query = "SELECT *
   FROM " . $this->table_name . "
   ORDER BY id";

   // prepare query statement
   $stmt = $this->conn->prepare( $query );

   // execute query
   $stmt->execute();

   $inputs = $stmt->rowCount();

   // return values
   return $inputs;

  }

  public function uploadInputImage(){

    // specify valid image types / formats
    $valid_formats = array("jpg", "png");

    // specify maximum file size of file to be uploaded
    $max_file_size = 1024*3000; // 3MB

    // directory where the files will be uploaded
    $path = "../../assets/uploads/";

    // count or number of files
    $count = 0;

    // if files were posted
    if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){

      // Loop $_FILES to execute all files
      foreach ($_FILES['input_image']['name'] as $f => $name){

        if ($_FILES['input_image']['error'][$f] == 4) {
          continue; // Skip file if any error found
        }

        if ($_FILES['input_image']['error'][$f] == 0) {
          if ($_FILES['input_image']['size'][$f] > $max_file_size) {
            $message[] = "$name is too large!.";
            continue; // Skip large files
          }
          elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
            $message[] = "$name is not a valid format";
            continue; // Skip invalid file formats
          }

          // No error found! Move uploaded files
          else{
            if(move_uploaded_file($_FILES["input_image"]["tmp_name"][$f], $path.$name)){
              $count++; // Number of successfully uploaded file

              // save name to database
              $this->photo = $name;

              
            }
          }
        }
      }
    }
  }


  
}

?>