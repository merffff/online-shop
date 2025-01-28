<?php

namespace Service;

use DTO\CreateOrderDTO;
use model\Model;
use model\Order;
use model\OrderProduct;
use model\Product;
use model\UserAddress;
use model\UserProduct;
use mysql_xdevapi\Exception;


class OrderService
{
    private UserProduct $userProductModel;
    private Product $productModel;
    private UserAddress $userAddressModel;
    private Order $orderModel;
    private OrderProduct $orderProductModel;
    private BasketProductService $productService;
    private Model $model;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
        $this->userAddressModel = new UserAddress();
        $this->orderModel = new Order();
        $this->orderProductModel = new OrderProduct();
        $this->productService = new BasketProductService();
        $this->model = new Model();
    }
    public function create(CreateOrderDTO $orderDTO)
    {
        $this->model->getPdo()->beginTransaction();
         try {


             $this->userAddressModel->createUserAddress(
                 $orderDTO->getUserId(),
                 $orderDTO->getCountry(),
                 $orderDTO->getCity(),
                 $orderDTO->getStreet(),
                 $orderDTO->getBuilding()
             );
             $address = $this->userAddressModel->getById($orderDTO->getUserId());
             $address_id = $address->getId();

             $products = $this->productService->getUserProduct($orderDTO->getUserId());
             $total = $this->productService->getTotal($products);
             $delivery = $this->productService->getDelivery($total);
             $subtotal = $this->productService->getSubtotal($delivery, $total);


             $this->orderModel->createOrder($orderDTO->getUserId(), $address_id, $orderDTO->getNumber(), $total);
             //throw new Exception();


             $userOrder = $this->orderModel->getOneByUserId($orderDTO->getUserId());

             $userProducts = $this->userProductModel->getByUserId($orderDTO->getUserId());

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
                 $this->orderProductModel->createOrderProduct($order_id, $product_id, $amount, $price);
             }

             $this->userProductModel->deleteAllByUserId($orderDTO->getUserId());
         } catch (\PDOException $exception) {
             $this->model->getPdo()->rollBack();

             throw $exception;
         }

         $this->model->getPdo()->commit();
    }



}