<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: /login");
} else {
    $user_id = $_SESSION['user_id'];

    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("SELECT amount, nameproduct, price, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
    $stmt ->execute(['user_id' => $user_id]);
    $userProducts = $stmt->fetchAll();


}

?>



<h1>Ваша Корзина</h1>

<div class="shopping-cart">

    <div class="column-labels">
        <label class="product-image"></label>
        <label class="product-details">Наименование продукта</label>
        <label class="product-price">Цена</label>
        <label class="product-quantity">Количество</label>

        <label class="product-line-price">Итого:</label>
    </div>
    <?php $total=0;
    foreach ($userProducts as $product) :?>
    <div class="product">
        <div class="product-image">
            <img src="<?php echo $product['image'] ?>">
        </div>
        <div class="product-details">
            <div class="product-title"><?php echo $product['nameproduct']?></div>

        </div>
        <div class="product-price"><?php echo $product['price']?></div>
        <div class="product-quantity">
            <?php echo $product['amount']?>
        </div>


        <div class="product-line-price"><?php
            $sum = $product['amount']*$product['price'];
            $total = $total+$sum;
            echo $sum ?>
        </div>
    </div>
    <?php endforeach;?>




    <div class="totals">
        <div class="totals-item">
            <label>Итого:</label>
            <div class="totals-value" id="cart-subtotal"><?php echo $total ?></div>
        </div>

    </div>

    <a href="/catalog">Вернуться к катологу</a>



</div>
<style>

    $color-border: #eee;
    $color-label: #aaa;
    $font-default: 'HelveticaNeue-Light', 'Helvetica Neue Light', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    $font-bold: 'HelveticaNeue-Medium', 'Helvetica Neue Medium';



    .product-image { float: left; width: 20%; }
    .product-details { float: left; width: 37%; }
    .product-price { float: left; width: 12%; }
    .product-quantity { float: left; width: 10%; }
    .product-add { float: left; width: 9%; }
    .product-removal { float: left; width: 9%; }




    .group:before,
    .group:after {
        content: '';
        display: table;
    }
    .group:after {
        clear: both;
    }
    .group {
        zoom: 1;
    }



    .shopping-cart, .column-labels, .product, .totals-item {
        @extend .group;
    }


    /* Apply dollar signs */
    .product .product-price:after, .product .product-line-price:after, .totals-value:after {
        content: '₽';
    }


    /* Body/Header stuff */
    body {
        padding: 0px 30px 30px 20px;
        font-family: $font-default;
        font-weight: 100;
    }

    h1 {
        font-weight: 100;
    }

    label {
        color: $color-label;
    }

    .shopping-cart {
        margin-top: -45px;
    }


    /* Column headers */
    .column-labels {
        label {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid $color-border;
        }

        .product-image, .product-details, .product-removal {
            text-indent: -9999px;
        }
    }


    /* Product entries */
    .product {
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid $color-border;

        .product-image {
            text-align: center;
            img {
                width: 100px;
            }
        }

        .product-details {
            .product-title {
                margin-right: 20px;
                font-family: $font-bold;
            }
            .product-description {
                margin: 5px 20px 5px 0;
                line-height: 1.4em;
            }
        }

        .product-quantity {
            input {
                width: 40px;

            }
        }

        .add-product {
            border: 0;
            padding: 4px 8px;
            background-color: #00ff00;
            color: #fff;
            font-family: $font-bold;
            font-size: 12px;
            border-radius: 3px;
        }

        .add-product:hover {
            background-color: #006400;
        }
    }

    .remove-product {
        border: 0;
        padding: 4px 8px;
        background-color: #c66;
        color: #fff;
        font-family: $font-bold;
        font-size: 12px;
        border-radius: 3px;
    }

    .remove-product:hover {
        background-color: #a44;
    }

    /* Totals section */
    .totals {
        .totals-item {
            float: right;
            clear: both;
            width: 100%;
            margin-bottom: 10px;

            label {
                float: left;
                clear: both;
                width: 79%;
                text-align: right;
            }

            .totals-value {
                float: right;
                width: 21%;
                text-align: right;
            }
        }

        .totals-item-total {
            font-family: $font-bold;
        }
    }

    .checkout {
        float: right;
        border: 0;
        margin-top: 20px;
        padding: 6px 25px;
        background-color: #6b6;
        color: #fff;
        font-size: 25px;
        border-radius: 3px;
    }

    .checkout:hover {
        background-color: #494;
    }
</style>


