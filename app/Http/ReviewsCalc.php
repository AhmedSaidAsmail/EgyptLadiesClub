<?php

namespace App\Http;

use App\Models\Item;

class ReviewsCalc {

    private static $instance;
    protected $itemModel;
    private $confirm;
    private $reviews_count;
    private $reviews_rate_sum;

    public function __construct(Item $item, $confirm = false) {
        $this->itemModel = $item;
        $this->confirm = $confirm;
    }

    public static function getInstance(Item $item, $confirm = false) {
        if (is_null(self::$instance)) {
            self::$instance = new static($item, $confirm);
        }
        return self::$instance;
    }

    public function setReviewsCount() {
        switch ($this->confirm)
        {
            case false:
                $this->reviews_count = $this->itemModel->reviews()->where('confirm', 1)->count();
                break;
            case true:
                $this->reviews_count = $this->itemModel->reviews()->count();
                break;
        }

        return $this;
    }

    public function setReviewsRateSum() {

        switch ($this->confirm)
        {
            case FALSE:
                $this->reviews_rate_sum = $this->itemModel->reviews()->where('confirm', 1)->sum('overall_rating');
                break;
            case "all":
                $this->reviews_rate_sum = $this->item->reviews()->sum('overall_rating');
                break;
        }
        return $this;
    }

    public function getRate() {
        if ($this->reviews_count > 0) {
            $rate = $this->reviews_rate_sum / $this->reviews_count;
            return $this->roundRate($rate);
        }
        return 0;
    }

    public function roundRate($rate) {
        $x = floor($rate * 2) / 2;
        return $x;
    }

    public static function calc(Item $item, $confirm = false) {
        $instance = self::getInstance($item, $confirm);
        return $instance->setReviewsCount()
                        ->setReviewsRateSum()
                        ->getRate();
    }

    public static function getRateStar(Item $item, $confirm = false) {
        $rate = self::calc($item, $confirm);
        for ($i = 0; $i < 5; $i++) {
            if ($rate > .5) {
                echo '<i class="fa fa-star"></i>';
                $rate -= 1;
            }
            elseif ($rate == .5) {
                echo '<i class="fa fa-star-half-o"></i>';
                $rate -= .5;
            }
            else {
                echo '<i class="fa fa-star-o"></i>';
            }
        }
    }
        public static function printStars($rate) {
        for ($i = 0; $i < 5; $i++) {
            if ($rate > .5) {
                echo '<i class="fa fa-star"></i>';
                $rate -= 1;
            }
            elseif ($rate == .5) {
                echo '<i class="fa fa-star-half-o"></i>';
                $rate -= .5;
            }
            else {
                echo '<i class="fa fa-star-o"></i>';
            }
        }
    }

}
