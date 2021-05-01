<?php
    include "OrdersClass.php";
    $orderArr = array(
        new Order(1, 1, 1, "Antwerp", "Detroit", "28-2-2021", null, "in transit", 500, true),
        new Order(2, 2, 2, "Tokyo", "Delhi", "7-2-2021", "20-2-2021", "arrived", 800, true),
        new Order(3, 3, 3, "Cairo", "Shanghai", "27-2-2021", null, "in transit", 200, false),
        new Order(4, 1, 4, "Beijing", "Brussels", "23-2-2021", "28-2-2021", "arrived", 1050, true),
        new Order(5, 4, 5, "Osaka", "Frankfurt", "2-3-2021", null, "sorted", 1280, false),
        new Order(6, 5, 6, "Buenos Aires", "Dubai", "23-2-2021", null, "in transit", 740, true),
        new Order(7, 3, 7, "Los Angeles", "Kuala Lumpur", "27-2-2021", null, "in transit", 960, true),
        new Order(8, 6, 8, "Lagos", "Madrid", "27-2-2021", null, "in transit", 820, true),
        new Order(9, 7, 9, "Rio de Janeiro", "Toronto", "25-2-2021", null, "in transit", 1260, true),
        new Order(10, 8, 10, "Guangzhou", "Hong Kong", "26-2-2021", null, "in transit", 420, true),
        new Order(11, 7, 11, "Paris", "London", "24-2-2021", null, "in transit", 690, false),
        new Order(12, 9, 12, "London", "Barcelona", "25-2-2021", null, "in transit", 850, true),
        new Order(13, 6, 13, "Bankok", "Singapore", "28-2-2021", null, "in transit", 930, true),
        new Order(14, 10, 14, "Madrid", "Seoul", "27-2-2021", null, "in transit", 1120, false),
        new Order(15, 11, 15, "Amsterdam", "Rome", "28-2-2021", null, "in transit", 350, true),
        new Order(16, 12, 16, "Taipei", "Abu Dhabi", "26-2-2021", null, "in transit", 440, true),
        new Order(17, 13, 17, "Munic", "Antwerp", "26-2-2021", null, "in transit", 680, false),
        new Order(18, 14, 2, "Tokyo", "Delhi", "7-2-2021", "20-2-2021", "in transit", 780, true),
    );

    $customer = new Customer(1, "John", "Doe", "23-5-1978", "johndoe@gmail.com", "0478123456", "private");

    $packages = array(
        new Product(1, "Coffee", 10, 10),
        new Product(1, "Tea", 50, 25),
        new Product(1, "Sugar", 2, 15),
        new Product(1, "Salt", 25, 50)
    );
?>