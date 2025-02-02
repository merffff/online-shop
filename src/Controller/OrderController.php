<?php

namespace Controller;
use DTO\CreateOrderDTO;
use model\Product;
use model\User;
use model\UserAddress;
use model\Order;
use model\OrderProduct;
use Request\OrderRequest;
use Service\AuthService;
use Service\BasketProductService;
use Service\OrderService;


class OrderController
{
    private Product $productModel;
    private UserAddress $userAddressModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private OrderService $orderService;
    private BasketProductService $productService;
    private AuthService $authService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userAddressModel = new UserAddress();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->orderService = new OrderService();
        $this->productService = new BasketProductService();
        $this->authService = new AuthService();

    }

    public function getOrder()
    {
        $this->checkSession();
        $user_id = $this->authService->getCurrentUser()->getId();


        $products = $this->productService->getUserProduct($user_id);
        $total = $this->productService->getTotal($products);
        $delivery = $this->productService->getDelivery($total);
        $subtotal = $this->productService->getSubtotal($delivery, $total);


        require_once './../view/order.php';
    }

    public function handleOrder(OrderRequest $request)
    {
        $error = $request->validate();



        if (empty($error)) {

            $this->checkSession();

            $user_id = $this->authService->getCurrentUser()->getId();
            $number = $request->getNumber();
            $name = $request->getName();

            $country = $request->getCountry();
            $city = $request->getCity();
            $street = $request->getStreet();
            $building = $request->getBuilding();

            $dto = new CreateOrderDTO($user_id,$number,$name,$country,$city,$street,$building);
            $this->orderService->create($dto);

            header("Location: /completedOrder");

        } else {

            require_once './../view/order.php';
        }


    }

    public function completedOrder()
    {

        $this->checkSession();

        $user_id = $this->authService->getCurrentUser()->getId();

        $userData = $this->orderModel->getOneByUserId($user_id);
        require_once './../view/completedOrder.php';
    }


    public function getOrders()
    {
        $this->checkSession();

        $user_id = $this->authService->getCurrentUser()->getId();
        $userOrders = $this->orderModel->getAllByUserId($user_id);


        $products = [];

        foreach ($userOrders as $userOrder) {
            $orderProducts = $this->orderProductModel->getByOrderId($userOrder->getId());
            foreach ($orderProducts as &$orderProduct) {

                    $productId = $orderProduct->getProductId();
                    $product = $this->productModel->getById($productId);
                    $product->setAmount($orderProduct->getAmount());
                    $product->setPrice($orderProduct->getPrice());
                    $product->setOrderId($orderProduct->getOrderId());
                    $products[] = $product;


            }
            unset($orderProduct);
            $userOrder->setProducts($products);
            $products = [];
        }


        foreach ($userOrders as &$userOrder) {
            if ($userOrder->getTotal() >= 250000) {
                $userOrder->setDelivery(0);
            } else {
                $userOrder->setDelivery(500);
            }

            $userOrder->setSubtotal($userOrder->getDelivery()+$userOrder->getTotal());
        } unset ($userOrder);


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

        if (!$this->authService->check()) {
            header("Location: /login");
        }
    }

}