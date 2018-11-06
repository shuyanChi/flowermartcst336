<?php
session_start();

include '../inc/dbConnection.php';
$dbConn = startConnection("tp_flowers");
include '../inc/functions.php';
validateSession();

if (isset($_GET['addFlower'])) { //checks whether the form was submitted
    
    $flowerName = $_GET['flowerName'];
    $description =  $_GET['flowerDesc'];
    $price =  $_GET['flowerPrice'];
    $category = $_GET['category'];
    $Id =  $_GET['flower_Id'];
    $color = $_GET['flowerColor'];
    $image = $_GET['flowerImage'];
    
    
    $sql = "INSERT INTO `flowers`(`flowerPrice`, `flowerDesc`, `category`, `flower_img`, `flowerName`, `flowerColor`) 
    VALUES (:price, :flowerDescription, :category, :flowerImage, :flowerName, :color)";
    $np = array();
    $np[":flowerName"] = $flowerName;
    $np[":flowerDescription"] = $description;
    $np[":flowerImage"] = $image;
    $np[":price"] = $price;
    $np[":category"] = $category;
    $np[":color"] = $color;
    
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($np);
    echo "New Product was added";
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title> Admin Section: Add New Product </title>
    </head>
    <body>
        
        <h1> Adding New Product </h1>
        
        <form action="adminPage.php">
              <input type="submit" value="Back">
          </form>
        
        <form>
           Flower name: <input type="text" name="flowerName"><br>
           Description: <textarea name="flowerDesc" cols="50" rows="4"></textarea><br>
           Price: <input type="text" name="flowerPrice"><br>
           Color: <input type="text" name="flowerColor"><br>
           Category: 
           <select name="category">
              <option value="">Select One</option>
              <?php
              
              $categories = displayCategories();
              
              foreach ($categories as $category) {
                  
                  echo "<option value='". $category['category'] . "'</option>";
              }
              
              ?>
           </select> <br />
           Set Image Url: <input type="text" name="flowerImage"><br>
           <input type="submit" name="addFlower" value="Add Product">
        </form>

    </body>
</html>