<?php
$temp = array();
    
function iCannnotBelieveIHadtoWriteThisFunctionMyselfPHPhasFAILEDME($var) {
        for( $i = 0; $i < count($_SESSION['cart']); $i++) {
            echo "<script> console.log('".$_SESSION['cart'][$i]['flowerName']."'); </script>";
            if ($var == $_SESSION['cart'][$i]['flowerName']) {
                return true;
            }
        }
        return false;
}

function verifyInDisplayData($var) {
        for( $i = 0; $i < count($_SESSION['display']); $i++) {
            if ($var == $_SESSION['display'][$i]['flowerName']) {
                return true;
            }
        }
        return false;
}

function displayCategories() {
    global $dbConn;
    $sql = "SELECT * FROM categories ORDER BY category ASC";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetchALL(PDO::FETCH_ASSOC);
    //print_r($record);
        
    foreach($record as $rec) {
        echo "<option>" . $rec['category'] . "</option><br/>";
    }
}

function displayColors() {
    global $dbConn;
    $sql = "SELECT DISTINCT flowerColor FROM flowers";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $record = $stmt->fetchALL(PDO::FETCH_ASSOC);
        
    foreach($record as $rec) {
        echo "<option>" . $rec['flowerColor'] . "</option><br/>";
    }
}
    
function filterProducts() {
    global $dbConn;
    global $temp;
        if (!empty($_GET['searchForm'])) {
        
            $flowerName = $_GET['flowerName'];
            $category = $_GET['category'];
            $priceFrom = $_GET['priceFrom'];
            $priceTo = $_GET['priceTo'];
            $flowerColor = $_GET['flowerColor'];
            
            //echo "Yeah That's THE STUFF!!!!<br/><br/>";
            
            $np = array();
            $sql = "SELECT * FROM flowers NATURAL JOIN categories WHERE 1 ";
            
            if(!empty($_GET['flowerName'])) {
                $sql .= " AND (flowerName LIKE :flowerName OR flowerDesc LIKE :flowerName)";
                $np[':flowerName'] = "%$flowerName%";
            }
            if(!empty($_GET['category'])) {
                $sql .= " AND category = :category";
                $np[':category'] = $category;
            }
            if(!empty($_GET['priceFrom'])) {
                $sql .= " AND flowerPrice >= :priceFrom";
                $np[':priceFrom'] = $priceFrom;
            }
            if(!empty($_GET['priceTo'])) {
                $sql .= " AND flowerPrice <= :priceTo";
                $np[':priceTo'] = $priceTo;
            }
            if(!empty($_GET['flowerColor'])) {
                $sql .= " AND flowerColor = :flowerColor";
                $np[':flowerColor'] = $flowerColor;
            }
            if(isset($_GET['order'])) {
                if($_GET['order'] == "asc") {
                    $sql .= " ORDER BY flowerName ASC";
                } else if ($_GET['order'] == "desc") {
                    $sql .= " ORDER BY flowerName DESC";
                } else if ($_GET['order'] == "ascPrice") {
                    $sql .= " ORDER BY flowerPrice ASC";
                } else if ($_GET['order'] == "descPrice"){
                    $sql .= " ORDER BY flowerPrice DESC";
                }
            }
            
        $stmt = $dbConn->prepare($sql);
        $stmt->execute($np);
        $record = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($record);
        $temp = $record;
        //print_r($temp);
        return $temp;
        }
}

function displayResults() {
        //global $items;
        
        echo "<table class='table'>";
        foreach($_SESSION['display'] as $t) {
        $flowerName = $t['flowerName'];
        $flowerPrice = $t['flowerPrice'];
        $flower_img = $t['flower_img'];
        $flower_Id = $t['flower_Id'];
        $flowerDesc = $t['flowerDesc'];
            
        //Display item as tablerow.
        echo '<tr>';
        echo "<td><img src='$flower_img' class=images></td>";
        echo "<td>";
        echo "<h4>$flowerName</h4>";
        
        "<a href=\"purchaseHistory.php?productId=". $rec['productId'] . "\"> History </a>";
        echo "<a href='extraInfo.php?flowerName=$flowerName&flowerDesc=$flowerDesc&flower_img=$flower_img' target='_blank'> History </a>";
        echo "</td>";
        echo "<td><h4>$flowerPrice</h4><br/>";
        if (iCannnotBelieveIHadtoWriteThisFunctionMyselfPHPhasFAILEDME($flowerName) && $flowerName == 'Kadupul Flower') {
                echo "Yeah right ... you must travel to Sri Lanka to see this flower. <br/>";
                echo "How western of you to think that such beauty can purchased and owned.";
            }
        echo "</td>";
            
        //A hidden input element containing the item name.
        echo "<form>";
        echo "<input type='hidden' name='flowerName' value='$flowerName'>";
        echo "<input type='hidden' name='flowerPrice' value='$flowerPrice'>";
        echo "<input type='hidden' name='flower_img' value='$flower_img'>";
        echo "<input type='hidden' name='flower_Id' value='$flower_Id'>";
        //** BUTTONS CAN HAVE NAMES ** 
        //** THE CONDITION IN THE FILTER PRODUCTS FUNCTION was expecting 'searchForm'.  The hidden inputs 
        //** did not submit that value, the condition did not pass any data into $items.
        // Problem:  the hidden values are being passed into the filter function.  
        // Save the primary form items in their own array, and display uses that.  
         //echo "$ GET FLOWER NAME IS " . $_GET['flowerName'];
    
        if (iCannnotBelieveIHadtoWriteThisFunctionMyselfPHPhasFAILEDME($flowerName)  && $flowerName!= 'Kadupul Flower') {
        //if (in_array($_GET['flowerName'], $_SESSION['display'], TRUE)) {
            echo "<td><button name='searchForm' value='Added' class='btn btn-success' >Added</button></td>";
        } else if ($flowerName == "Kadupul Flower") {
            echo "<td><button name='searchForm' value='Add' class='btn btn-warning'>Add</button></td>";
        } else {
            echo "<td><button name='searchForm' value='Add' class='btn btn-warning'>Add</button></td>";
            //echo "HEYEEYEYYEYE ";
        }
        echo "</form>";
        echo "</tr>";
    }
    echo "</table>";

} 
    
function displayCart() {
        if (isset($_SESSION['cart'])) {
            echo "<table class='table'>";
            foreach($_SESSION['cart'] as $item) {
                $flowerName = $item['flowerName'];
                $flowerPrice = $item['flowerPrice'];
                $flower_img = $item['flower_img'];
                $flower_Id = $item['flower_Id'];
                $quantity = $item['quantity'];
                // Display the item as a table row.
                echo "<tr>";
                echo "<td><img src='$flower_img'></td>";
                echo "<td><h4>$flowerName</h4></td>";
                echo "<td><h4>$$flowerPrice</h4></td>";
                //echo "<td><h4>$itemQuant</h4></td>";
                
               
                echo "<form>";
                echo "<input type='hidden' name='flowerName' value='$flowerName'>";
                echo "<td><input type='text' name='update' class='form-control' placeholder='$quantity (I am a placeholder = to 0)'></td>";
                echo "<td><button class='btn btn-danger'>Update</button></td>";
                echo "</form>";
                //echo "</td>";
                // Hidden input element containing the item name.
                echo "<td>";
                echo "<form>";
                echo "<input type='hidden' name='remove' value='$flowerName'";
                echo "<td><button class='btn btn-danger'>Remove</button></td>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            //echo "HEYYY item quant = $itemQuant";
        }
}

$_SESSION['count'];
function displayCartCount() {
    if (isset($_GET['bigredbutton'])) {
        $_SESSION['count'] = 0;
        
    }
    echo $_SESSION['count'];
}

function nuke() {
    if (isset($_GET['bigredbutton'])) {
        $_SESSION['count'] = 0;
        session_destroy();
        
    }
    else {
        $_SESSION['count'];
        displayCart();
    }
}

?>