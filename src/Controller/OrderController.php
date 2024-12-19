<?php
require_once './../model/UserAddress.php';
require_once './../model/User.php';
require_once './../model/Product.php';
require_once './../model/OrderProduct.php';
require_once './../model/UserProduct.php';
require_once './../model/Order.php';
class OrderController
{
    private UserProduct $userProductModel;
    private Product $productModel;
    private User $userModel;
    private UserAddress $userAddressModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->userModel = new User();
        $this->userAddressModel = new UserAddress();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
    }

    public function getOrder()
    {
        session_start();

        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $user_id = $_SESSION['user_id'];

        $email = $this->userModel->getEmailById($user_id);

        $userProducts = $this->userProductModel->getByUserId($user_id);

        $products =[];
        $total=0;

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];
            $product = $this->productModel->getById($productId);
            $product['amount'] = $userProduct['amount'];
            $products[] =$product;
            $sum = $product['amount']*$product['price'];
            $total = $total+$sum;

        }

        if ($total >= 250000) {
            $delivery = 0;
        } else {
            $delivery = 500;
        }

        $subtotal = $delivery+$total;

        require_once './../view/order.php';
    }

    public function handleOrder()
    {
        $error = $this->validateOrderForm($_POST);



        if (empty($error)) {

            session_start();

            if(!isset($_SESSION['user_id'])) {
                header("Location: /login");
            }

            $user_id = $_SESSION['user_id'];
            $number = $_POST['number'];
            $name = $_POST['name'];

            $country = $_POST['country'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $building = $_POST['building'];



            $this->userAddressModel->createUserAddress($user_id,$country,$city,$street,$building);
            $address = $this->userAddressModel->getById($user_id);
            $address_id=$address['id'];

            $userProducts = $this->userProductModel->getByUserId($user_id);

            $products =[];
            $subtotal=0;

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct['product_id'];
                $product = $this->productModel->getById($productId);
                $product['amount'] = $userProduct['amount'];
                $products[] =$product;
                $sum = $product['amount']*$product['price'];
                $subtotal = $subtotal+$sum;

            }

            if ($subtotal >= 250000) {
                $delivery = 0;
            } else {
                $delivery = 500;
            }

            $total = $delivery+$subtotal;

            $this->orderModel->createOrder($user_id,$address_id,$number,$total);

            $userOrder = $this->orderModel->getOneByUserId($user_id);

            $productIds = [];
            foreach ($userProducts as $userProduct) {
                $productIds[] = $userProduct['product_id'];
            }

            $products = $this->productModel->getAllByIds($productIds);

            foreach ($products as $product) {
                foreach ($userProducts as &$userProduct) {
                    if ($userProduct['product_id'] === $product['id']) {
                        $userProduct['price'] = $product['price'];

                    }
                }
                unset($userProduct);
            }

            foreach ($userProducts as $userProduct) {
                $order_id = $userOrder['id'];
                $product_id = $userProduct['product_id'];
                $amount = $userProduct['amount'];
                $price = $userProduct['price'];
                $this->orderProductModel->createOrderProduct($order_id,$product_id,$amount,$price);
            }

            $this->userProductModel->deleteAllByUserId($user_id);




            header("Location: /completedOrder");




        } else {

            require_once './../view/order.php';
        }


    }

    public function completedOrder()
    {

        session_start();

        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $user_id = $_SESSION['user_id'];

        $userData = $this->orderModel->getOneByUserId($user_id);
        require_once './../view/completedOrder.php';
    }

    private function validateOrderForm(array $arrPost): array
    {
        $error = [];

        if (isset($arrPost['name'])) {
            $name = $arrPost['name'];

            if (empty($name)) {
                $error['name'] = 'имя не может быть пустым';
            } elseif (strlen($name) < 2) {
                $error['name'] = 'имя не может содержать меньше двух букв';
            } elseif (is_numeric($name)) {
                echo $error['name'] = 'имя не может быть числом';
            }
        } else {
            $error['name'] = 'name is required';
        }


        if (isset($arrPost['email'])) {
            $email = $arrPost['email'];

            if (empty($email)) {
                $error['email'] = 'email не может быть пустым';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'email указан неверно';
            }
        } else {
            $error['email'] = 'email is required';
        }

        if (isset($arrPost['number'])) {
            $number = $arrPost['number'];

            if (empty($number)) {
                $error['number'] = 'номер телефона не может быть пустым';
            } elseif (!is_numeric($number)) {
                echo $error['number'] = 'номер телефона не может быть символом';
            }elseif ($number<69999999999) {
                $error['number'] = 'номер телефона должен содержать 11 цифр';
            }
        } else {
            $error['number'] = 'number is required';
        }

        if (isset($arrPost['country'])) {
            $country = $arrPost['country'];

            if (empty($country)) {
                $error['country'] = 'страна не может быть пустой';
            } elseif (strlen($country) < 2) {
                $error['country'] = 'страна не может содержать меньше двух букв';
            } elseif (is_numeric($country)) {
                echo $error['country'] = 'страна не может быть числом';
            }
        } else {
            $error['country'] = 'country is required';
        }

        if (isset($arrPost['city'])) {
            $city = $arrPost['city'];

            if (empty($city)) {
                $error['city'] = 'город не может быть пустым';
            } elseif (strlen($city) < 2) {
                $error['city'] = 'город не может содержать меньше двух букв';
            } elseif (is_numeric($city)) {
                echo $error['city'] = 'город не может быть числом';
            }
        } else {
            $error['city'] = 'city is required';
        }

        if (isset($arrPost['street'])) {
            $street = $arrPost['street'];

            if (empty($street)) {
                $error['street'] = 'улица не может быть пустым';
            } elseif (strlen($street) < 2) {
                $error['street'] = 'улица не может содержать меньше двух символов';
            }
        } else {
            $error['street'] = 'street is required';
        }

        if (isset($arrPost['building'])) {
            $building = $arrPost['building'];

            if (empty($building)) {
                $error['building'] = 'номер здания не может быть пустым';
            } elseif ($building< 0) {
                $error['building'] = 'номер здания не может быть отрицательным числом';
            } elseif (!is_numeric($building)) {
                echo $error['building'] = 'номер здания не может быть символом';
            }
        } else {
            $error['building'] = 'building is required';
        }

        return $error;





    }

}