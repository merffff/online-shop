<?php


function validateAddProduct(array $arrPost): array
{
    $error = [];

    if (isset($arrPost['product_id'])) {
        $product_id = $arrPost['product_id'];

        if (empty($product_id)) {
            $error['product_id'] = 'id не может быть пустым';
        } elseif (!is_numeric($product_id)) {
            echo $error['product_id'] = 'id не может быть символом';
        }elseif ($product_id<1) {
            $error['product_id'] = 'id должно быть положительным числом';
        }else {
            $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute(['id' => $product_id]);
            $data = $stmt->fetch();

            if ($data === false) {
                $error['product_id'] = 'продукта с указанным id не существует';
            }
        }
    } else {
        $error['product_id'] = 'product-id is required';
    }


    if (isset($arrPost['amount'])) {
        $amount = $arrPost['amount'];

        if (empty($amount)) {
            $error['amount'] = 'количество не может быть пустым';
        } elseif (!is_numeric($amount)) {
            $error['amount'] = 'введите целое число';
        } elseif ($amount<1) {
            $error['amount'] = 'количество должно быть положительным числом';
        }
    } else {
        $error['amount'] = 'amount is required';
    }


    return $error;
}

$error = validateAddProduct($_POST);


//print_r($name);
//print_r($email);
//print_r($password);
//print_r($passwordRep);
if (empty($error)) {
    session_start();
    if(!isset($_SESSION['user_id'])) {
        header("Location: /login");
    }
    $user_id=$_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];

    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
    $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
    $productIsset = $stmt->fetch();

    if ($productIsset === false) {
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    } else {

        $stmt = $pdo->prepare("UPDATE user_products SET amount = amount + :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }




    header("Location: /basket");
    exit;
} else {

    require_once './get_add_product.php';
}

