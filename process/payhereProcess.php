<?php
if (!isset($_SESSION)) session_start();
require_once "../db/connection.php";

header("Content-Type: application/json");



// Auth Check
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"] || ($_SESSION["active_account_type"] ?? "") != "buyer") {
    echo json_encode(["success" => false, "message" => "Unauthorized!"]);
    exit;
}

$userId = intval($_SESSION["user_id"] ?? 0);

 // Fetch cart items
    $cartItemsQ = Database::search(
        "SELECT c.`id` AS `cart_item_id`, p.*, u.`fname` AS `seller_fname`, u.`lname` AS `seller_lname`,
                sa.`city_id` AS `seller_city_id`, sa.`id` AS `seller_id`
            FROM `cart` c
            JOIN `product` p ON c.`product_id`=p.`id`
            JOIN `user` u ON p.`seller_id`=u.`id`
            LEFT JOIN `user_profile` up ON u.`id`=up.`user_id`
            LEFT JOIN `address` sa ON up.`address_id`=sa.`id`
            WHERE c.`user_id`=?
            ORDER BY c.`created_at` DESC",
        "i",
        [$userId]
    );

    if(!$cartItemsQ || $cartItemsQ->num_rows == 0){
        echo json_encode(["success" => false, "message" => "Cart is empty!"]);
        exit;
    }

     $buyerCityQ = Database::search(
        "SELECT a.`city_id` 
        FROM `user_profile` up 
        JOIN `address` a ON up.`address_id` = a.`id` 
        WHERE up.`user_id`=?",
        "i",
        [$userId]
    );
    $buyerCityId = ($buyerCityQ && $buyerCityQ->num_rows > 0) ? $buyerCityQ->fetch_assoc()["city_id"] : 0;

    $subTotal = 0;
    $totalDeliveryFee = 0;
    $sellersInCart = [];

    while ($item = $cartItemsQ?->fetch_assoc()) {
        $subTotal += floatval($item["price"]);

        $sellerId = $item["seller_id"];
        if (!isset($sellersInCart[$sellerId])) {
            $deliveryFee = ($item["seller_city_id"] == $buyerCityId && $buyerCityId != 0) ? 200 : 500;
            $totalDeliveryFee += $deliveryFee;
            $sellersInCart[$sellerId] = $deliveryFee;
        }
    }

    $total = $subTotal + $totalDeliveryFee;

  $merchantId = "1228353";
  $merchantSecret = "Mzc2NjgyNjcyMTMyNDIwMTg2MjE3NjI0NTgxODIxMzY3NDk5NjM4";
  $currency = "LKR";
  $formattedTotal = number_format($total,2,".","");
  $orderId = "ORD" . uniqid();

  $hash = strtoupper(
    md5(
        $merchantId .
        $orderId .
        $formattedTotal .
        $currency .
        strtoupper(md5($merchantSecret))
    )
  );

  $userQ = Database::search(
    "SELECT u.`fname`, u.`lname`, u.`email`,
    up.`mobile`,
    a.`line1`,a.`line2`,
    c.`name` AS `city_name`,
    co.`name` AS `country_name`
    FROM `user` u
    LEFT JOIN `user_profile` up ON u.`id`=up.`user_id`
    LEFT JOIN `address` a ON up.`address_id`=a.`id`
    LEFT JOIN `city` c ON a.`city_id`=c.`id`
    LEFT JOIN `country` co ON c.`country_id`=co.`id`
    WHERE u.`id`=?",
     "i",
     [$userId]
     );

  if(!$userQ || $userQ->num_rows == 0){
    echo json_encode(["success" => false, "message" => "User not found!"]);
    exit;
  }

  $user = $userQ->fetch_assoc();
  
  // Provide fallback values for missing profile data
  $user["fname"] = $user["fname"] ?? "User";
  $user["lname"] = $user["lname"] ?? "";
  $user["email"] = $user["email"] ?? "no-email@skillshop.com";
  $user["mobile"] = $user["mobile"] ?? "0000000000";
  $user["line1"] = $user["line1"] ?? "Online Address";
  $user["line2"] = $user["line2"] ?? "";
  $user["city_name"] = $user["city_name"] ?? "Online";
  $user["country_name"] = $user["country_name"] ?? "Sri Lanka";

  $paymentObject =[
     "sandbox" => true,
     "merchant_id" => $merchantId,
     "return_url" => "http://localhost/skillshop_test3/skillShop/buyer-dashboard.php",
     "cancel_url" => "http://localhost/skillshop_test3/skillShop/buyer-dashboard.php",
     "notify_url" => "",
     "order_id" => $orderId,
     "items" => "skillshop Purchase",
     "amount" => $formattedTotal,
     "currency" => $currency,
     "hash"=> $hash,
     "first_name" => $user["fname"],
     "last_name" => $user["lname"],
     "email" => $user["email"],
     "phone" => $user["mobile"] ?? "0000000000",
     "address" => trim($user["line1"]. " " . ($user["line2"] ?? "")),
     "city" => $user["city_name"],
     "country"  => $user["country_name"]
  ];

  echo json_encode(["success" => true, "payment" => $paymentObject]);

?>