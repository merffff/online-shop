<?php

namespace Controller;
use model\UserProduct;
use model\Product;
use model\User;
use model\UserAddress;
use model\Order;
use model\OrderProduct;
use Request\OrderRequest;


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
        $this->checkSession();

        $user_id = $_SESSION['user_id'];

        $email = $this->userModel->getEmailById($user_id);

        $userProducts = $this->userProductModel->getByUserId($user_id);

        $products =[];
        $total=0;

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $product = $this->productModel->getById($productId);
            $product->setAmount($userProduct->getAmount());
            $products[] =$product;
            $sum = $product->getAmount()*$product->getPrice();
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

    public function handleOrder(OrderRequest $request)
    {
        $error = $request->validate();



        if (empty($error)) {

            $this->checkSession();

            $user_id = $_SESSION['user_id'];
            $number = $request->getNumber();
            $name = $request->getName();

            $country = $request->getCountry();
            $city = $request->getCity();
            $street = $request->getStreet();
            $building = $request->getBuilding();



            $this->userAddressModel->createUserAddress($user_id,$country,$city,$street,$building);
            $address = $this->userAddressModel->getById($user_id);
            $address_id=$address->getId();

            $userProducts = $this->userProductModel->getByUserId($user_id);

            $products =[];
            $subtotal=0;

            foreach ($userProducts as $userProduct) {
                $productId = $userProduct->getProductId();
                $product = $this->productModel->getById($productId);
                $product->setAmount( $userProduct->getAmount());
                $products[] =$product;
                $sum = $product->getAmount()*$product->getPrice();
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
                $productIds[] = $userProduct->getProductId();
            }

            $products = $this->productModel->getAllByIds($productIds);

            foreach ($products as $product) {
                foreach ($userProducts as &$userProduct) {
                    if ($userProduct->getProductId() === $product->getId()) {
                        $userProduct->setPrice($product->getPrice());

                    }
                }
                unset($userProduct);
            }

            foreach ($userProducts as $userProduct) {
                $order_id = $userOrder->getId();
                $product_id = $userProduct->getProductId();
                $amount = $userProduct->getAmount();
                $price = $userProduct->getPrice();
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

        $this->checkSession();

        $user_id = $_SESSION['user_id'];

        $userData = $this->orderModel->getOneByUserId($user_id);
        require_once './../view/completedOrder.php';
    }


    public function getOrders()
    {
        $this->checkSession();

        $user_id = $_SESSION['user_id'];
        $userOrders = $this->orderModel->getAllByUserId($user_id);

        $orderIds = [];
        foreach ($userOrders as $userOrder) {
            $orderIds[]= $userOrder->getId();
        }



        $orderProducts = $this->orderProductModel->getAllByOrderId($orderIds);




        foreach ($orderProducts as $orderProduct) {

            foreach ($userOrders as &$userOrder) {
                if ($userOrder->getId() === $orderProduct->getOrderId()) {
                   $userOrder->setProductId($orderProduct->getProductId());
                   $userOrder->setAmount($orderProduct->getAmount());
                   $userOrder->setPrice( $orderProduct->getPrice());
                    if ($userOrder->getTotal() >= 250000) {
                        $userOrder->setDelivery(0);
                    } else {
                        $userOrder->setDelivery(500);
                    }

                    $userOrder->setSubtotal($userOrder->getDelivery()+$userOrder->getTotal());
                }
            }
            unset($userOrder);
        }



        $productIds = [];
        foreach ($userOrders as $userOrder) {
            $productIds[] = $userOrder->getProductId();
        }


        $products = $this->productModel->getAllByIds($productIds);


        foreach ($products as $product) {

            foreach ($userOrders as &$userOrder) {
                if ($userOrder->getProductId() === $product->getId()) {
                    $userOrder->setNameproduct( $product->getNameproduct());
                    $userOrder->setCategory($product->getCategory());
                    $userOrder->setImage($product->getImage());
                }
            }
            unset($userOrder);
        }

        $addressIds = [];
        foreach ($userOrders as $userOrder) {
            $addressIds[] = $userOrder->getAddressId();
        }





        $addresses = $this->userAddressModel->getAddressesByIds($addressIds);



        foreach ($addresses as $address) {

            foreach ($userOrders as &$userOrder) {
                if ($userOrder->getAddressId() === $address->getId()) {
                    $userOrder->setCountry($address->getCountry());
                    $userOrder->setCity($address->getCity());
                    $userOrder->setStreet($address->getStreet());
                    $userOrder->setBuilding($address->getBuilding());
                }
            }
            unset($userOrder);
        }







        require_once './../view/orders.php';

    }

    private function checkSession():void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
    }

}