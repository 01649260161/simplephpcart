<?php
session_start();
require_once 'database.php';
$database = new Database();
if(isset($_POST) && !empty($_POST)){

    if(isset($_POST['action'])){
        switch ($_POST['action']){
            case 'add':
                if (isset($_POST['quantity']) && isset($_POST['product_id'])){
                    $sql ="SELECT * FROM products where id = ".(int)$_POST['product_id'];
                    $products = $database->runQuery($sql);
                    $products = current($products);
                    echo '<br> $products';
                    echo '<pre>';
                    print_r($products);
                    echo '</pre>';
                    $product_id = $products['id'];

                    if(isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])){


                        if (isset($_SESSION['cart_item'][$product_id])){
                            $exit_cart_item = $_SESSION['cart_item'][$product_id];
                            $exit_quantity =$exit_cart_item['quantity'];
                            $cart_item = array();
                            $cart_item['product_id'] = $products['id'];
                            $cart_item['product_name'] = $products['product_name'];
                            $cart_item['product_image'] = $products['product_image'];
                            $cart_item['price'] = $products['price'];
                            $cart_item['quantity'] =$exit_quantity + $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id]=$cart_item;
                        }else{
                            $cart_item = array();
                            $cart_item['product_id'] = $products['id'];
                            $cart_item['product_name'] = $products['product_name'];
                            $cart_item['product_image'] = $products['product_image'];
                            $cart_item['price'] = $products['price'];
                            $cart_item['quantity'] = $_POST['quantity'];
                            $_SESSION['cart_item'][$product_id]=$cart_item;
                        }

                    }else{
                        $_SESSION['cart_item'] = array();
                        $cart_item = array();
                        $cart_item['product_id'] = $products['id'];
                        $cart_item['product_name'] = $products['product_name'];
                        $cart_item['product_image'] = $products['product_image'];
                        $cart_item['price'] = $products['price'];
                        $cart_item['quantity'] =$_POST['quantity'];
                        $_SESSION['cart_item'][$product_id]=$cart_item;
                    }
                }
                break;
            case 'remove':
                echo '<br> $_POST';
                echo '<pre>';
                print_r($_POST);
                echo '</pre>';
                echo 'remove';
                if (isset($_POST['product_id'])) {
                    $product_id = $_POST['product_id'];
                    if (isset($_SESSION['cart_item'][$product_id])) {
                        unset($_SESSION['cart_item'][$product_id]);
                    }
                }
                break;
            default:
                echo 'action không tồn tại';
                die;
        }
    }
    echo '<br> $_POST';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    echo '<br> $_SESSION';
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';

    echo '<br> $_SESSION [\'cart_item\']';
    echo '<pre>';
    print_r($_SESSION['cart_item']);
    echo '</pre>';
}



/*$sql ="SELECT * FROM products";
$products = $database->runQuery($sql);*/
header("Location: http://localhost/simplephpcart/templace/index.php");
die;