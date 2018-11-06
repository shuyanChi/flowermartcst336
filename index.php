<?php
    session_start();
?>
<!DOCTYPE html>
<?php
    include 'inc/dbConnection.php';
    include 'inc/functions.php';
    $_SESSION['temp'] = array ();
    
    $dbConn = startConnection('tp_flowers');  //Make sure dbConnection.php file knows about this.
    
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if (isset($_GET['flowerName'])) {
        $items = filterProducts();
    }
    
    //***This condition stops the shopping items from vanishing.
    //***displayResults() now uses data stored in a session 
    //***array.  The session array is only updated if the user hits enter while the cursor is
    //***in the input box, or if the user clicks on the proper submit button.  The add and added buttons
    //***are also named 'searchForm', because filterProducts() has a condition that requires it, but I am wondering
    //***if it even needs that condition now (look into it later).
    if($_GET['searchForm'] == 'submit') {
        $_SESSION['display'] = $items;
    }
    
    //print_r($_SESSION['display']);
    
    //echo "<br/><br/><br/>";
    //echo "HEY SESSION display is " . $_SESSION['display'][0]['flowerName']; 
    //echo "<br/>";
 
    //Without we must check to see if $_GET['flowerName'] is in the display data or it will add
    //anything the user searches for to the cart.
    if (isset($_GET['flowerName'])  && ($_GET['searchForm'] == 'Add' || $_GET['searchForm'] == 'Added')) {
        
        $newItem = array();
        //This condition is needed to keep a null record out of the cart.
        if ($_GET['flowerName'] != '') {  
            $newItem['flowerName'] = $_GET['flowerName'];
            //$newItem['flower_Id'] = $_GET['flower_Id'];
            $newItem['flowerPrice'] = $_GET['flowerPrice'];
            $newItem['flower_img'] = $_GET['flower_img'];
            //array_push($_SESSION['cart'], $newItem );
            //print_r($_SESSION['cart']);
            //move these next 2 inside if statement to fix duplicates.
            //and blank entries
            
            $found = false;
            foreach($_SESSION['cart'] as &$item) {
                if ($newItem['flowerName'] == $item['flowerName']){
                    $item['quantity'] += 1;
                    $_SESSION['count'] += 1;
                    $found = true;
                    break;
                }
            }
            
            if ($found == false) {
                    $newItem['quantity'] = 1;
                    $_SESSION['count'] += 1;
                    array_push($_SESSION['cart'], $newItem);
            }
            
        }
        
    }
    
?>

<html>
    <head>
        <title> EAS-C Elite Floural </title>
        <style>
            @import url('css/styles.css');
        </style>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class='container'>
        <div class='text-center'>
            <!-- Bootstrap Navagation Bar -->
            <nav class='navbar navbar-default - navbar-fixed-top'>
                <div class='container-fluid'>
                    <div class='navbar-header'>
                        <a class='navbar-brand' href='#'>EAS-C Flowers for the Elite</a>
                    </div>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='admin/adminLogin.php'>Admin</a></li>
                        <li><a href='fscart.php'><span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'>
                        </span>Cart (<?php displayCartCount(); ?>)</a></li>
                    </ul>
                </div>
            </nav>
            <br/><br/><br/>
            <?php  //print_r($_SESSION['cart']);  ?>
        <h1></h1>
        
        <form>
            <p>
                Key Word <input type='text' name='flowerName' value=''  />
            </p>
            <p>
                Categories <select name='category'>
                                <option value=""> Select One</option>
                                <?=displayCategories()?>
                           </select>
            </p>
            <p>
                Colors <select name='flowerColor'>
                                <option value=""> Select One</option>
                                <?=displayColors()?>
                           </select>
            </p>
            <p>
                
            </p>
            <p>
                Price From <input type='text' name='priceFrom' value='' /> To <input type='text' name='priceTo' value='' />
            </p>
            <p>
                Order: <input type='radio' name='order' value='asc' /> A-Z  <input type='radio' name='order' value='desc' /> Z-A
                       <br>
                       <input type='radio' name='order' value='descPrice' /> Price high-low  <input type='radio' name='order' value='ascPrice' /> Price low-high
            </p>
            <p>
                <input type='submit' name='searchForm' value='submit' />
            </p>
            
        </form>
                <?php if (!empty($items)) { displayResults(); } ?>
                
    </body>
    <footer>
        cst336. 2018 &copy; <br />
        <strong>Disclaimer: </strong> The information in this webpage is fictious. <br />
        It is used for acdemic purposes only. <br />
        <img src = "img/csumb2-300x190.png" alt = "csumb logo" /> 
    </footer>
</html>