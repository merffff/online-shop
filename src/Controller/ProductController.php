<?php

namespace Controller;
use http\Env\Request;
use model\Order;
use model\OrderProduct;
use model\Product;
use model\Review;
use model\UserProduct;
use Request\ProductRequest;
use Request\ReviewRequest;
use Service\Auth\AuthCookieService;
use Service\Auth\AuthServiceInterface;


class ProductController
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function getCatalog():void
    {
        $this->checkAuth();
        $user_id = $this->authService->getCurrentUser()->getId();

        $products = Product::getProducts();
        $totalAmount = UserProduct::getAmountByUserId($user_id);
        $response = ['success' => true, 'totalAmount' => $totalAmount->getTotalAmount()];
        echo json_encode($response);

        require_once './../view/catalog.php';

    }

    public function getProduct(ProductRequest $request):void
    {
        $this->checkAuth();
        $product_id = $request->getProductId();
        $nameProduct = Product::getById($product_id)->getNameproduct();
        $category = Product::getById($product_id)->getCategory();
        $price = Product::getById($product_id)->getPrice();
        $image = Product::getById($product_id)->getImage();
        $productCount = Product::getById($product_id)->getProductcount();

        $reviews = Review::getAllByProductId($product_id);
        $sum = 0;
        $i = 0;

        foreach ($reviews as $review) {
            $rate  = $review->getRate();

            $sum = $sum +$rate;
            $i++;
        }
        if ($i == 0) {
            $averageRate = 0;
        } else {
        $averageRate = $sum / $i;
        }



        require_once './../view/Product.php';







    }



    public function handleReview(ReviewRequest $request):void
    {
        $this->checkAuth();


        $product_id = $request->getProductId();
        $user_id = $this->authService->getCurrentUser()->getId();

        $error = $request->validate();

        if (empty ($error)) {


            $data = Order::getByUserIdAndProductId($user_id, $product_id);
            if ($data !== false) {
                $text = $request->getText();
                $rate = $request->getRate();
                $datetime = date("Y-m-d H:i:s");
                Review::createReview($product_id, $text, $rate, $user_id, $datetime);
            } else {
                $error['review'] = 'Для того чтобы оставить отзыв, нужно приобрести товар';
            }

        }

        header("Location: /catalog");










    }

    private function checkAuth():void
    {

        if (!$this->authService->check()) {
            header("Location: /login");
        }
    }
}