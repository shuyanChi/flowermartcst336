<?php

    session_start();
    include 'inc/dbConnection.php';
    //include 'inc/functions.php';
    $dbConn = startConnection("tp_flowers");
    
    
    $flowerName = $_GET['flowerName'];
    //echo "FLOWER NAME IS $flowerName";
    $sql = "SELECT * FROM flowers
            NATURAL JOIN purchaseHistory  
            WHERE flowerName LIKE :fName";  //Using named parameters to avoid sql injection
                                      //the natural join gives us purchase information too.
  
    //echo "SQL IS $sql";
    //echo "<br/>";
    $np = array();
    $np[':fName'] = "%$flowerName%";
    
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($np);
    $record = $stmt->fetchALL(PDO::FETCH_ASSOC);
    //print_r($record);
    echo "<br/><br/>";
    //echo "flower image = " . $_GET['flower_img'];
    echo "<strong>" . $_GET['flowerName'] . "</strong><br/>";
    echo "<strong> History: " . $_GET['flowerDesc'] . "</strong> <br/>";
    // echo "<img class=images src=' " . $_GET['flower_img'] . "' /><br/>"; 
    echo "<img src=' " . $_GET['flower_img'] . " 'style = 'width: 250px; height: 200px;' /><br/>"; 
    if (empty($record[0]['purchaseDate'])) {
        echo "No purchase info.";
    } else {
        
        foreach($record as $rec) {
            echo "Purchase Date: " . $rec['purchaseDate'] . "<br/>";
            echo "Unit Price: " . $rec['flowerPrice'] . "<br/>";
            echo "Quantity: " . $rec['quantity'] . "<br/>";
        }
        
    }
    
?>

