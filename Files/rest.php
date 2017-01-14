<?php
    
    function headerFoo() {
        
        header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
    }

    function fetchAll() {
        
        $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
        $connection->exec("set names utf8");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $queryText = "SELECT * FROM `posts`";
        
        try {
            
            $result = $connection->query($queryText);
            $forJSON = $result->fetchAll(PDO::FETCH_OBJ);
            $connection = null;
            
            echo '{"Posts":'.json_encode($forJSON).'}';
        }
        catch (PDOException $e) {
            
            echo '{"Exception":{"message":'.$e->getMessage().'}}';
        }
    }

    function fetchByID($passID) {
        
        $connection = new PDO("mysql:dbname=wt-spirala4-v2;host=localhost;charset=utf8", "anjakin", "clonerino");
        $connection->exec("set names utf8");
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $queryText = "SELECT * FROM `posts` WHERE `id`='$passID'";
        
        try {
            
            $result = $connection->query($queryText);
            $forJSON = $result->fetchAll(PDO::FETCH_OBJ);
            $connection = null;
            
            echo '{"Posts":'.json_encode($forJSON).'}';
        }
        catch (PDOException $e) {
            
            echo '{"Exception":{"message":'.$e->getMessage().'}}';
        }
    }

    $method = $_SERVER['REQUEST_METHOD'];
    switch($method) {
        
        case 'GET':
            headerFoo();
            if (isset($_GET['q']))
                fetchByID($_GET['q']);
            else if ($_GET['q'] == '')
                fetchAll();
            
            break;
        
        default: header("{$_SERVER['SERVER_PROTOCOL']} 404 not found");
            break;
    }
?>