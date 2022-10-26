<?php

session_start();

// include classes
include_once "../../config/database.php";
include_once '../../objects/farmer.php';
include_once "../../objects/cart.php";
include_once '../../objects/input.php';
include_once '../../objects/accounts.php';
include_once '../../objects/orderedinputs.php';
include_once '../../objects/orders.php';





// get database connection
$database = new Database();
$db = $database->getConnection();

// // initialize objects
$farmer = new Farmer($db);
$cart = new CartItem($db);
$farminput = new FarmInput($db);
$account = new Account($db);
$ordered_input = new OrderedInput($db);
$order = new Order($db);



if (isset($_POST['addtocart'])) {
    if(isset($_POST['input_id'])){

        $farminput->id = $_POST['input_id'];
        $stmt_input = $farminput->readOneFarmInput();
        

        if($stmt_input){
            $cart->farmer_id = $_SESSION["user_id"];
            $cart->input_id = $_POST['input_id'];
            $cart->quantity = 1;
            $added = $cart->addToCart();
            if($added){
                echo json_encode(array("success"=>true));
                exit();

            }else{
                echo json_encode(array("success"=>false));
                exit();
            }

        } else{
            echo json_encode(array("success"=>false));
            exit();

        }

    }else{
        echo json_encode(array("success"=>false));
        exit();

    }
} elseif(isset($_POST['removecart'])){
    if(isset($_POST['id'])){
        $cart->farmer_id = $_SESSION["user_id"];
        $cart->id = $_POST["id"];
        $removed = $cart->removeFromCart();
        if($removed){
            echo json_encode(array("success"=>true));
            exit();

        }else{
            echo json_encode(array("success"=>false));
            exit();
        }

    } else{
        echo json_encode(array("success"=>false));
        exit();

    }

} elseif(isset($_POST['updatecart'])){
    if(isset($_POST['quantity']) && isset($_POST['id'])){

        $cart->farmer_id = $_SESSION["user_id"];
        $cart->id = $_POST['id'];
        $cart->quantity = $_POST["quantity"];

        $stmt_cart = $cart->readSingleCart();

        if($stmt_cart->rowCount() > 0){

			extract($row = $stmt_cart->fetch(PDO::FETCH_ASSOC));
			
		}


        $updated = $cart->updateCart();

        if($updated){
            echo json_encode(array("success"=>true,"price"=>$price));
            exit();

        }else{
            echo json_encode(array("success"=>false));
            exit();
        }

    } else{
        echo json_encode(array("success"=>false));
        exit();

    }

} elseif(isset($_POST['checkoff'])){
   
    $cart->farmer_id = $_SESSION["user_id"];
    $account->farmer_id = $_SESSION["user_id"];
    $account_results = $account->readAccountDetails();
    $available_balance = 0;
    $total = 0;

    if($account_results->rowCount() > 0){
        extract($account_results->fetch(PDO::FETCH_ASSOC));
        $available_balance = $gross_pay - $total_deduction;


    }else{
        echo json_encode(array("success"=>false,"message"=>"Account information not found."));
        exit();
    }
   
    $stmt_cart2 = $cart->readCart();

    if($stmt_cart2->rowCount() > 0){

        $order->farmer_id = $_SESSION['user_id'];
        $order->status = 0;
        $order->total = 0;
        $order_added = $order->addNewOrder();
        $current_order_id = $db->lastInsertId();

        if($order_added){
            $input_added = false;

            while($row = $stmt_cart2->fetch(PDO::FETCH_ASSOC)){ //looping through cart items
                extract($row);
                $total += $cart_quantity * $price;
                $ordered_input->input_id = $input_id;
                $ordered_input->order_id = $current_order_id;
                $ordered_input->quantity = $cart_quantity;
                $ordered_input->total =  $cart_quantity * $price;
                $farminput->sold = $cart_quantity;
                $farminput->id = $input_id;
                $inventoryupdated = $farminput->updateQuantity();
                $input_added = $ordered_input->newInputOrder();
    
            }

            $order->id = $current_order_id;
            $order->total = $total;
            $order_updated = $order->updateOrderTotal();

        }
      

        if($total > $available_balance){
            $order->deleteAllByUser();
            $ordered_input->deleteAllByOrderID();
            echo json_encode(array("success"=>false,"message"=>"Insufficient funds"));
            exit();

        }else{

           $accounts_updated = $account->updateAccountDetailsOnOrder($total);
           $cart_updated = $cart->deleteAllByUser();
           if($accounts_updated && $cart_updated){
            echo json_encode(array("success"=>true,"message"=>"Your order has been received."));
            exit();

           }else{
            echo json_encode(array("success"=>false,"message"=>"Error updating account info."));
            exit();

           }

        }

        
        
    }else{
        echo json_encode(array("success"=>false,"message"=>"No items found in cart!"));
        exit();

    }


 

   

} elseif(isset($_POST['cancelorder'])){
    if(isset($_POST['order_id'])){

        $order->id = $_POST['order_id'];
        $order->status = 3;
        $order->farmer_id  = $_SESSION['user_id'];

        $order_details = $order->readSingleOrderByUser();

        if($order_details->rowCount() > 0){
            extract($order_details->fetch(PDO::FETCH_ASSOC));
            $account->farmer_id = $_SESSION['user_id'];
            $accounts_updated = $account->updateAccountDetailsOnCancelOrder($total);

            if($accounts_updated){
                $ordercancelled = $order->changeOrderStatus();
                $ordered_input->order_id = $_POST['order_id'];
                $inputs_ordered = $ordered_input->readAllOrderedInputsByFarmer();

                if($inputs_ordered->rowCount() > 0){
                    
                    while($row = $inputs_ordered->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        $farminput->id = $input_id;
                        $farminput->sold = $quantity;
                        $updated_inputs = $farminput->updateQuantityOnCancelOrder();

                    }
                }
                $orderedinputscancelled = $ordered_input->cancelOrder();
                if($ordercancelled && $orderedinputscancelled){
                    echo json_encode(array("success"=>true));
                    exit();
                    
                } else{
                    echo json_encode(array("success"=>false));
                    exit();
                }
            }
            

           
        }
        
    }


} elseif(isset($_POST['cancelinputorder'])){
    

    if(isset($_POST['id'])){

        $order->id = $_POST['id'];
        $ordered_input->order_id = $_POST['id'];
        $ordered_input->input_id = $_POST['input_id'];

        $order_input_details = $ordered_input->readSingleOrderedItem();

        echo $order_input_details->rowCount();
        exit();
        if($order_input_details->rowCount() > 0){
            extract($order_input_details->fetch(PDO::FETCH_ASSOC));
            $farminput->id = $input_id;
            $farminput->sold = $quantity;
            $updated_inputs = $farminput->updateQuantityOnCancelOrder();

            if($updated_inputs){
                $account->farmer_id = $_SESSION['user_id'];
                $accounts_updated = $account->updateAccountDetailsOnCancelOrder($total);
                
                if($accounts_updated){
                    $order->total = $total;
                    $orders_updated = $order->updateOrderTotalOnCancel();

                    if($orders_updated){
                        $order_input_updated = $ordered_input->deleteOrderedItem();

                        if($order_input_updated){
                            echo json_encode(array("success"=>true));
                            exit();
                            
                        } else{
                            echo json_encode(array("success"=>false));
                            exit();
                        }
                        }
                    }
                }

            }

           

        }
       
        
    }



  
  






?>