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
    private BasketProductService $productService;

    public function __construct(BasketProductService $productService)
    {
        $this->productService = $productService;
    }
    public function create(CreateOrderDTO $orderDTO)
    {
        $pdo = Model::getPdo();
        $pdo->beginTransaction();
         try {


             UserAddress::createUserAddress(
                 $orderDTO->getUserId(),
                 $orderDTO->getCountry(),
                 $orderDTO->getCity(),
                 $orderDTO->getStreet(),
                 $orderDTO->getBuilding()
             );
             $address = UserAddress::getById($orderDTO->getUserId());
             $address_id = $address->getId();

             $products = $this->productService->getUserProduct($orderDTO->getUserId());
             $total = $this->productService->getTotal($products);
             $delivery = $this->productService->getDelivery($total);
             $subtotal = $this->productService->getSubtotal($delivery, $total);


             Order::createOrder($orderDTO->getUserId(), $address_id, $orderDTO->getNumber(), $total);
             //throw new Exception();


             $userOrder = Order::getOneByUserId($orderDTO->getUserId());

             $userProducts = UserProduct::getByUserId($orderDTO->getUserId());

             $productIds = [];
             foreach ($userProducts as $userProduct) {
                 $productIds[] = $userProduct->getProductId();
             }

             $products = Product::getAllByIds($productIds);

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
                 OrderProduct::createOrderProduct($order_id, $product_id, $amount, $price);
             }

             UserProduct::deleteAllByUserId($orderDTO->getUserId());
         } catch (\PDOException $exception) {
             $pdo->rollBack();

             throw $exception;
         }

         $pdo->commit();

    }



}