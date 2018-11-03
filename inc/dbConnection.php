<?php
     //Creating a database connection
     function startConnection($dbname) {
        $host = "localhost";
        $dbname = "tp_flowers";
        $username = "root";
        $password = "";
        
        //Checks the url for heroku
        if(strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
            //This creates some kind of associative array and stores it in $url.
            $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
            $host = $url['host'];
            $dbname = substr($url["path"], 1);
            $username = $url["user"];
            $password = $url["pass"];
        }
        
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $dbConn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        
        return $dbConn;
     }










?>