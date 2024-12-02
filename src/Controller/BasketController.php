<?php



class BasketController
{

    public function getAddProduct()
    {

        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        require_once './../view/addProduct.php';
    }

    public function addProduct()
    {
        $error = $this->validateAddProduct($_POST);


        if (empty($error)) {
            session_start();
            if(!isset($_SESSION['user_id'])) {
                header("Location: /login");
            }
            $user_id=$_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];

            require_once './../model/UserProduct.php';
            $data = new UserProduct();
            $productIsset = $data->getByProductIdAndUserId($product_id, $user_id);

            if ($productIsset === false) {
                $data =new UserProduct();
                $data->create($user_id, $product_id, $amount);
            } else {
                $data = new UserProduct();
                $data->update($user_id,$product_id,$amount);
            }




            header("Location: /basket");
            exit;
        } else {

            require_once './get_add_product.php';
        }

    }

    private function validateAddProduct(array $arrPost): array
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
                require_once './../model/UserProduct.php';
                $data = new UserProduct;
                $res = $data->getById($product_id);

                if ($res === false) {
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

    public function getBasket()
    {

        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $user_id = $_SESSION['user_id'];

            $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

            $stmt = $pdo->prepare("SELECT amount, nameproduct, price, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $userProducts = $stmt->fetchAll();


        }

        require_once './../view/basket.php';

    }
}