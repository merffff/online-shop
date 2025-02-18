<?php

namespace Service;

use model\Review;

class ReviewService
{
    public function getRate()
    {
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

    }

}