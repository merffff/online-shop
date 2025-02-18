

<body>
<div id="wrap">
    <div id="product_layout_1">
        <div class="top">
            <div class="product_images">
                    <div class="product_image">
                        <img src="<?php echo $image; ?>" width="200" alt="">
                    </div>

                </div>
            </div>
            <div class="product_info">
                <div class="catalog__product-body">
                    <h2 class="catalog__product-title"><?php echo $nameProduct;?>
                        <a href="/"><?php echo $category;?></a></h2>
                    <h2 class="catalog__product-title"><?php echo "Осталось: $productCount шт.";?>




                    <p class="catalog__product-price"><?php echo $price;?></p>
                    <a href="/add-product">Добавить в корзину</a>


                </div>

                <form action="/review" method="POST">

            </div>
        </div>
        <form class="bottom">
            <div class="reviews">

                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br
                <br> <br> <br> <br> <br> <br><br>

                <label style="font-size: 15px"> Рейтинг товара: <?php echo $averageRate?> /5 </label>
                <div class="head">
                    <h2>Отзывы</h2>
                    <details>
                        <summary style="font-size: 15px">Посмотреть отзывы на товар</summary>




                        <?php if (empty($reviews)): ?>

                        <p style="font-size: 15px"> Отзывов пока нет </p>

                        <?php else: ?>

                        <?php foreach ($reviews as $review): ?>




                        <div class="totals-item">
                            <label style="font-size: 14px">Пользователь:</label>
                            <div class="totals-value" id="cart-subtotal" style="font-size: 14px"><?php echo $review->getUserId(); ?></div>
                        </div>


                        <div class="totals-item">
                            <label style="font-size: 14px">Время:</label>
                            <div class="totals-value" id="cart-subtotal" style="font-size: 14px"><?php echo $review->getDatetime(); ?></div>
                        </div>
                        <div class="totals-item">
                            <label style="font-size: 14px">Оценка:</label>
                            <div class="totals-value" id="cart-subtotal" style="font-size: 14px"><?php echo $review->getRate(); ?></div>
                        </div>
                        <div class="totals-item">
                            <label style="font-size: 14px">Текст отзыва:</label>
                            <div class="totals-value" id="cart-subtotal" style="font-size: 14px"><?php echo $review->getText(); ?></div>
                        </div>







                        <?php endforeach;?>
                        <?php endif; ?>





                        </p>
                    </details>

                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?> " id="product_id"  />

                    <hr>


                    <form action="/review" method="POST">
                        <div class="container">
                            <h2>Напишите отзыв</h2>

                            <hr>


                            <label for="product_id" style="font-size: 14px">Имя</label>
                            <input type="text" placeholder="Enter your name" name="name" id="name" required style="color: #95999c">
                            <p><label style="color: darkred">
                                    <?php
                                    if (!empty($error['name'])) {
                                        print_r ($error['name']);
                                    }
                                    ?>
                                </label></p>

                            <label for="rating" style="font-size: 14px">Поставьте оценку:</label>
                            <select id="rate" name="rate" required>
                                <option value="5">5 - Отлично</option>
                                <option value="4">4 - Хорошо</option>
                                <option value="3">3 - Средне</option>
                                <option value="2">2 - Плохо</option>
                                <option value="1">1 - Очень плохо</option>
                            </select>

                            <p><label style="color: darkred">
                                    <?php
                                    if (!empty($error['rate'])) {
                                        print_r ($error['rate']);
                                    }
                                    ?>
                                </label></p>


                            <label for="amount" style="font-size: 14px">Отзыв</label>
                            <input type="text" placeholder="Напишите сюда ваш отзыв о товаре" name="text" id="text" required style="color: #95999c" >
                            <p><label style="color: darkred">
                                    <?php
                                    if (!empty($error['text'])) {
                                        print_r ($error['text']);
                                    }
                                    ?>  </label></p>






                            <hr>

                            <input type="hidden" name="product_id" value="<?php echo $request->getProductId(); ?> " id="product_id"  />
                            <p><label style="color: darkred">
                                    <?php
                                    if (!empty($error['review'])) {
                                        print_r ($error['review']);
                                    }
                                    ?>  </label></p>



                            <button type="submit" class="registerbtn">Отправить отзыв</button>
                        </div>

                        <a href="/catalog" style="font-size: 15px">Вернуться к каталогу</a>


                    </form>

                    <style>
                        * {box-sizing: border-box}

                        /* Add padding to containers */
                        .container {
                            padding: 16px;
                        }

                        /* Full-width input fields */
                        input[type=text], input[type=password] {
                            width: 100%;
                            padding: 15px;
                            margin: 5px 0 22px 0;
                            display: inline-block;
                            border: solid;
                            background: #f1f1f1;

                        }

                        input[type=text]:focus, input[type=password]:focus {
                            background-color: #ddd;
                            outline: none;
                        }

                        /* Overwrite default styles of hr */
                        hr {
                            border: 1px solid #f1f1f1;
                            margin-bottom: 25px;
                        }

                        /* Set a style for the submit/register button */
                        .registerbtn {
                            background-color: #04AA6D;
                            color: white;
                            padding: 16px 20px;
                            margin: 8px 0;
                            border: none;
                            cursor: pointer;
                            width: 100%;
                            opacity: 0.9;
                        }

                        .registerbtn:hover {
                            opacity:1;
                        }

                        /* Add a blue text color to links */
                        a {
                            color: dodgerblue;
                        }

                        /* Set a grey background color and center the text of the "sign in" section */
                        .signin {
                            background-color: #f1f1f1;
                            text-align: center;
                        }



                    </style>


                </div>
            </div>

        </form>












<style>
    body{
        background:#efefef;
        font-family:'Arial'sans-serif;
        font-size:62.5%;
    }
    h1{
        font-weight:500;
    }
    img{
        max-width:100%;
    }
    #wrap{
        width:80%;
        margin:0 auto;
        padding-top:30px;
        padding-bottom:30px;
    }
    #product_layout_1{
        margin-top:30px;
    }
    #product_layout_1 .top{
        display:block;
        width:100%;
        margin-bottom:30px;
    }
    #product_layout_1 .bottom{
        display:block;
        width:100%;
        padding-top:50px;
        clear:both;
    }
    #product_layout_1 .product_images{
        width:30%;
        max-width:320px;
        float:left;
    }
    #product_layout_1 .product_info{
        width:66%;
        float:left;
        margin-left:4%;
    }
    #product_layout_1 .product_images .product_image_1{
        width:100%;
        border:2px solid lightgray;
        border-radius:3px;
    }
    #product_layout_1 .product_images .product_image_small{
        width:100%;
        margin-top:15px;
    }
    #product_layout_1 .product_images .product_image_small .product_image_2{
        width:30%;
        border:1px solid lightgray;
        float:left;
        margin-right:4%;
        box-sizing:border-box;
    }
    #product_layout_1 .product_images .product_image_small .product_image_3{
        width:30%;
        border:1px solid lightgray;
        float:left;
        margin-right:4%;
        box-sizing:border-box;
    }
    #product_layout_1 .product_images .product_image_small .product_image_4{
        width:30%;
        border:1px solid lightgray;
        float:left;
    }
    #product_layout_1 .product_info h1{
        font-size:3.6em;
        line-height:.8;
    }
    #product_layout_1 .product_info .price{
        margin-top:-40px;
    }
    #product_layout_1 .product_info .original_price{
        color:lightgray;
        font-size:2.8em;
        text-decoration:line-through;
        width:20%;
        display:inline-block;
    }
    #product_layout_1 .product_info .sale_price{
        color:#b30000;
        font-size:3.2em;
        display:inline-block;
        width:30%;
    }
    #product_layout_1 .product_info .rating{
        margin-top:-20px;
        color:goldenrod;
    }
    #product_layout_1 .product_info .product_description{
        font-size:1.4em;
    }
    #product_layout_1 .product_info .related_info{
        color:#a6a6a6;
    }
    #product_layout_1 .product_info .related_info span{
        margin-right:5%;
    }
    #product_layout_1 .product_info .options{
        margin-top:30px;
    }
    #product_layout_1 .product_info .buying_options{
        width:45%;
        float:left;
    }
    #product_layout_1 .product_info .buying{
        width:45%;
        float:left;
        margin-left:10%;
    }
    #product_layout_1 .product_info .buying_options .select{
        width: 100%;
        max-width:300px;
        height: 40px;
        overflow: hidden;
        background: url('https://i.imgur.com/10e9Roz.png') no-repeat right #FFF;
        border: 1px solid #ccc;
        border-radius:3px;
        margin-top:15px;
    }
    #product_layout_1 .product_info .buying_options select{
        background: transparent;
        display:block;
        width: 268px;
        padding: 5px;
        font-size: 2em;
        line-height: 1;
        border: 0;
        border-radius:0;
        height: 40px;
        -webkit-appearance: none;
    }
    #product_layout_1 .product_info .buying .quantity{
        font-size:2em;
        margin-top:15px;
        width:100%;
        display:block;
    }
    #product_layout_1 .product_info .buying .quantity [type="text"]{
        width:40px;
        height:40px;
        border:1px solid #ccc;
        border-radius:3px;
        padding:10px;
        box-sizing:border-box;
        font-size:1em;
    }
    #product_layout_1 .product_info .buying .cart{
        margin-top:25px;
        width:100%;
        float:left;
        margin-bottom:20px;
    }
    #product_layout_1 .product_info .buying .cart a.add{
        font-size:2em;
        color:#FFF;
        background:#00a900;
        text-decoration:none;
        padding:10px 20px;
        height:40px;
        border-radius:3px;
        margin-left:10px;
    }
    #product_layout_1 .product_info .social{
        font-size:1.4em;
        line-height:1.2;
        margin-bottom:15px;
        width:60%;
        display:block;
        margin:15px 0px;
    }
    #product_layout_1 .product_info .social .share{
        margin-top:-5px;
        margin-bottom:15px;
    }
    #product_layout_1 .product_info .buttons{
        margin-top:20px;
        margin-left:10px;
        display:inline-block;
        width:30%;
    }
    #product_layout_1 .reviews{
        width:30%;
        float:left;
        border:2px solid #aaa;
        border-radius:3px;
        margin-bottom:30px;
        box-sizing:border-box;
        max-width:320px;
    }
    #product_layout_1 .reviews h2{
        font-weight:500;
        font-size:2.4em;
    }
    #product_layout_1 .reviews .head{
        background:#ccc;
        text-align:center;
        padding:5px;

    }
    #product_layout_1 .reviews .content{
        background:#FFF;
        padding-top:15px;
        padding-left:2em;
        padding-right:2em;
        padding-bottom:15px;
    }
    #product_layout_1 .reviews .content .name{
        font-size:1.8em;
    }
    #product_layout_1 .reviews .content .stars{
        color:goldenrod;
        margin-left:15px;
    }
    #product_layout_1 .reviews .content .review_text{
        margin-top:10px;
        font-size:1.2em;
    }
    #product_layout_1 .reviews .content .fullReview a{
        display:block;
        font-size:1.2em;
        text-align:center;
        color:#006bff;
        text-decoration:none;
    }
    #product_layout_1 .reviews .content .writeReview a{
        display:block;
        font-size:1.4em;
        text-align:center;
        color:#006bff;
        text-decoration:none;
    }
    #product_layout_1 .related{
        width:66%;
        float:left;
        display:block;
        margin-left:4%;
        border:2px solid #aaa;
        border-radius:3px;
        box-sizing:border-box;
    }
    #product_layout_1 .related .head{
        background:#ccc;
        padding:.3em;
    }
    #product_layout_1 .related .head h2{
        text-align:center;
        font-weight:500;
        font-size:2.4em;
    }
    #product_layout_1 .related .content{
        background:#FFF;
    }
    #product_layout_1 .related .relatedProducts{
        columns:3;
    }
    #product_layout_1 .related .products{
        text-align:center;
        width:25%;
        float:left;
        margin-left:6.25%;
        box-sizing:border-box;
    }
    #product_layout_1 .related .products .title{
        font-size:1.4em;
        line-height:1;
        min-height:24px;
    }
    #product_layout_1 .related .products .image img{
        border:2px solid #ccc;
        margin-top:-5px;
        cursor:pointer;
    }
    #product_layout_1 .related .products .price{
        color:#b30000;
        font-size:2.0em;
        margin-top:-2px;
    }
    @media (max-width:500px){
        #product_layout_1 .product_images,#product_layout_1 .product_info,#product_layout_1 .reviews,#product_layout_1 .related,#product_layout_1 .product_info .buying,#product_layout_1 .product_info .buying_options, #product_layout_1 .product_info .social{width:100%; margin-left:0;margin-right:0}
    }



    .rating-result {

        width:30%;
        max-width:320px;
        float:left;

    }

    .rating-result span {

        padding: 0;

        font-size: 32px;

        margin: 0 3px;

        line-height: 1;

        color: lightgrey;

        text-shadow: 1px 1px #bbb;

    }

    .rating-result > span:before {

        content: '★';

    }

    .rating-result > span.active {

        color: gold;

        text-shadow: 1px 1px #c60;

    }
</style
