<?php

include_once('config.inc');

function get_quantity($item_id) {
  $sql="select * from purchases_sales";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $quantity = 0;
  while($row = mysqli_fetch_array($result)) {
   
    $sql="select sum(quantity) as 'sum' from purchases_sales_items where 
	   purchase_sales_id={$row['id']} and item_id=$item_id and type='purchases'";
    $resultx = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rowx = mysqli_fetch_array($resultx);
    $quantity += $rowx['sum'];
	
	$sql="select sum(quantity) as 'sum' from purchases_sales_items where 
	   purchase_sales_id={$row['id']} and type='purchase_returns' and item_id=$item_id";
    $resultx = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rowx = mysqli_fetch_array($resultx);
    $quantity -= $rowx['sum'];
   
    $sql="select sum(quantity) as 'sum' from purchases_sales_items where 
	   purchase_sales_id={$row['id']} and type='sales' and item_id=$item_id";
    $resultx = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rowx = mysqli_fetch_array($resultx);
    $quantity -= $rowx['sum'];
   
    $sql="select sum(quantity) as 'sum' from purchases_sales_items where 
	   purchase_sales_id={$row['id']} and type='sales_returns' and item_id=$item_id";
    $resultx = mysqli_query($con, $sql) or die(mysqli_error($con));
    $rowx = mysqli_fetch_array($resultx);
    $quantity += $rowx['sum'];
  }
  return $quantity;
}

function closeSale($type) {
  //deletes sessions vars 
		
  if($type == 'sales') {
    unset($_SESSION['current_sale_customer_id']);
    unset($_SESSION['items_in_sale']);
    unset($_SESSION['current_item_search']);
    unset($_SESSION['current_customer_search']);
  } else if ($type == 'sales_returns') {
    unset($_SESSION['current_sale_customer_id2']);
    unset($_SESSION['items_in_sale2']);
    unset($_SESSION['current_item_search2']);
    unset($_SESSION['current_customer_search2']);
  }
}

function closePurchase($type) {
  //deletes sessions vars 
  if ($type == 'purchases') {
    unset($_SESSION['current_purchase_supplier_id']);
    unset($_SESSION['items_for_purchase']);
    unset($_SESSION['current_item_search']);
    unset($_SESSION['current_supplier_search']);
  } else if ($type == 'purchase_returns') {
    unset($_SESSION['current_purchase_supplier_id2']);
    unset($_SESSION['items_for_purchase2']);
    unset($_SESSION['current_item_search2']);
    unset($_SESSION['current_supplier_search2']);
  }
}

?>
