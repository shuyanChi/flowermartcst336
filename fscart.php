<?php 
    session_start();
    include 'inc/functions.php';
    
    //To remove button
    if (isset($_GET['remove'])) {
        foreach($_SESSION['cart'] as $itemKey => $item) {
            if ($item['flowerName'] == $_GET['remove']) {
                $_SESSION['count'] -= $item['quantity'];
                unset($_SESSION['cart'][$itemKey]);
            }
        }
    }
    //To update quanitity
    if(isset($_GET['flowerName'])) {
        foreach($_SESSION['cart'] as &$item) {
            if ($item['flowerName'] == $_GET['flowerName']) {
                $_SESSION['count'] += ($_GET['update'] - $item['quantity']);
                $item['quantity'] = $_GET['update'];
                //break;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Shopping Cart</title>
    </head>
    <body>
        <div class='container'>
            <div class='text-center'>
                <!-- Bootstrap Navagation Bar -->
                <nav class='navbar navbar-default - navbar-fixed-top'>
                    <div class='container-fluid'>
                        <div class='navbar-header'>
                            <a class='navbar-brand' href='#'>EAS-C Shopping Carts... for the Elite</a>
                        </div>
                        <ul class='nav navbar-nav'>
                            <li><a href='index.php'>Home</a></li>
                            <li><a href='fscart.php'><span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span> Cart (<?php displayCartcount();?>)</a></li>
                        </ul>
                    </div>
                </nav>
                <br /> <br /> <br />
                <h2>How about, Flower Basket?</h2>
                <?php  //print_r($_SESSION['cart']);  ?>
                <!-- Cart Items -->
                <br/><br/><br/>
                <form><button name='bigredbutton' value='BOOM' >Nuke</button></form>
                <?php
                    nuke();
                ?>
            </div>
        </div>
    </body>
</html>