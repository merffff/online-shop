
<article class="catalog">
    <div class="container-mix  catalog__list">

        <div class="catalog__product  mix  cheap">
            <?php foreach ($products as $product): ?>
            <form action="/product" method="POST">
                <a class="catalog__product-img" href="/">
                    <img src="<?php echo $product->getImage();?>" width="330" alt="">
                </a>

                <div class="catalog__product-body">
                    <h2 class="catalog__product-title"><?php echo $product->getCategory();?>
                        <input type="hidden" name="product_id" value="<?php echo $product->getId()?> " id="product_id"  />
                        <a href="/"><?php echo $product->getNameproduct();?></a></h2>
                    <input type="submit" value=" Перейти на страницу товара"/>


                </div>

                <div class="catalog__product-offer">
                    <p class="catalog__product-price"><?php echo $product->getPrice();?></p>

            </form>

            <form method="POST" class="increase" onsubmit="return false">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" required>
                <input type="number" id= 'addedQuantity' name="amount" min="1" required>
                <button type="submit" class="btn btn-success">+</button>
            </form>
            <form method="POST" class="decrease" onsubmit="return false">
                <input type="hidden" name="product_id" value="<?php echo $product->getId(); ?>" required>
                <input type="number" id= 'addedQuantity' name="amount" min="1" required>
                <button type="submit" class="btn btn-danger">-</button>
            </form>



                    <a href="/basket">Перейти в корзину</a>
                </div>

            <?php endforeach;?>
        </div>

        <a href="/orders">Мои заказы</a>

        <a href="/logout">Выйти</a>

    <span class="cart">
  <svg height="20pt" viewBox="0 -31 512.00026 512" width="20pt" xmlns="http://www.w3.org/2000/svg"><path d="m164.960938 300.003906h.023437c.019531 0 .039063-.003906.058594-.003906h271.957031c6.695312 0 12.582031-4.441406 14.421875-10.878906l60-210c1.292969-4.527344.386719-9.394532-2.445313-13.152344-2.835937-3.757812-7.269531-5.96875-11.976562-5.96875h-366.632812l-10.722657-48.253906c-1.527343-6.863282-7.613281-11.746094-14.644531-11.746094h-90c-8.285156 0-15 6.714844-15 15s6.714844 15 15 15h77.96875c1.898438 8.550781 51.3125 230.917969 54.15625 243.710938-15.941406 6.929687-27.125 22.824218-27.125 41.289062 0 24.8125 20.1875 45 45 45h272c8.285156 0 15-6.714844 15-15s-6.714844-15-15-15h-272c-8.269531 0-15-6.730469-15-15 0-8.257812 6.707031-14.976562 14.960938-14.996094zm312.152343-210.003906-51.429687 180h-248.652344l-40-180zm0 0"/><path d="m150 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"/><path d="m362 405c0 24.8125 20.1875 45 45 45s45-20.1875 45-45-20.1875-45-45-45-45 20.1875-45 45zm45-15c8.269531 0 15 6.730469 15 15s-6.730469 15-15 15-15-6.730469-15-15 6.730469-15 15-15zm0 0"/></svg>
  <span class="cart_count"><?php //if (isset($) && !empty($totalAmount)): ?>
      <?php  echo $totalAmount->getTotalAmount() ?? '0';?>
      <?php //endif;?>
       </span>
    </span>

    </div>
</article>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $("document").ready(function () {
        $('.increase').submit(function () {
            $.ajax({
                type: "POST",
                url: "/addProduct",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    $('.cart_count').text(response.totalAmount);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>

<script>
    $("document").ready(function () {
        $('.decrease').submit(function () {
            $.ajax({
                type: "POST",
                url: "/deleteProduct",
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    $('.cart_count').text(response.totalAmount);
                },
                error: function(xhr, status, error) {
                    console.error('Ошибка при добавлении товара:', error);
                }
            });
        });
    });
</script>


<style>
    $purple: rgba(102, 46, 145, 1);
    $opacity25Purple: rgba(102, 46, 145, 0.25);
    $purpleDark: rgba(74, 30, 109, 1);
    $purpleLight: rgba(154, 98, 197, 1);
    $red: rgba(234, 74, 26, 1);
    $redHover: rgba(229, 58, 18, 1);

    $white: rgba(255, 255, 255, 1);
    $opacity90White: rgba(255, 255, 255, 0.9);
    $opacity25White: rgba(255, 255, 255, 0.25);
    $black: rgba(0, 0, 0, 1);
    $opacity45Black: rgba(0, 0, 0, 0.45);
    $opacity80Black: rgba(0, 0, 0, 0.8);
    $yellow: rgba(255, 216, 0, 1);
    $yellow35Opacity: rgba(255, 216, 0, 0.35);
    $grey: rgba(128, 128, 128, 1);
    $lightGrey: #aaa;
    $lightGrey2: #ccc;
    $lightGrey3: #ddd;
    $lightGrey4: #f4f4f4;
    $greyRubricator: #e8e8e8;
    $greyDarkRubricator: #dcdcdc;

    $linkHover: rgba(233, 67, 45, 1);
    $linkUnderline: rgba(0, 0, 0, 0.25);
    $linkHoverBtn: rgba(0, 0, 0, 0.5);

    @mixin underline {
        border-bottom: 1px solid $linkUnderline;

        &:hover {
            color: $linkHover;
            border-bottom: 1px solid $linkHover;
        }
    }

    @mixin noUnderline {
        border-bottom: none;

        &:hover {
            border-bottom: none;
        }
    }

    @mixin transition($transition-property, $transition-time, $method) {
        -webkit-transition: $transition-property $transition-time $method;
        -moz-transition: $transition-property $transition-time $method;
        -ms-transition: $transition-property $transition-time $method;
        -o-transition: $transition-property $transition-time $method;
        transition: $transition-property $transition-time $method;
    }

    a {
        text-decoration: none;
    }

    .btn {
        display: inline-block;
        margin: 10px 0;
        padding: 14px 36px;
        font: {
        weight: 700;
    }
        text-align: center;
        background-color: $yellow;
        border: 0;
        cursor: pointer;
        border-radius: 5px;
        @include transition(all, 0.3s, ease-in-out);

        &:hover {
            color: $white !important;
            background-color: $redHover;
        }
    }

    .btn-add2cart {
        padding: 10px 33px;
    }


    /* Filter */
    .filter-tubes {
        margin: 0 -10px;
        padding: 60px 0 40px;

        &__list {
            display: flex;
            list-style-type: none;

            li {
                margin: 0 10px;
                cursor: pointer;

                &:first-of-type {
                    color: #888888;
                }
            }

            .mixitup-control-active {
                font-weight: bold;
            }
        }
    }

    /* Catalog */
    .catalog {
        &__list {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -22.5px;
        }

        &__product {
            flex-basis: 30.33%;
            margin: 1%;
            background-color: $lightGrey4;
            box-sizing: border-box;

            &--bg {
                background-color: transparent;
                border: 1px solid $greyRubricator;
            }

            &--sale {
                background-color: $yellow;

                .btn-add2cart {
                    color: $white;
                    background-color: $redHover;

                    &:hover {
                        color: $black !important;
                        background-color: $white;
                    }
                }
            }

            &-img {
                img {
                    width: 100%;
                }
            }

            &-body,
            &-offer {
                padding: 0 25px 15px;
            }

            &-body {
                max-width: 400px;
                margin: 15px 0 0;

                p {
                    margin: 0;
                }
            }

            &-title {
                margin: 0 0 10px;
                font-size: 21px;
                font-weight: normal;
                line-height: 29px;

                a {
                    color: $black;
                    @include underline;

                    &:hover {
                        .catalog__product-img {
                            img {
                                /*transform: scale(1.1);*/
                            }
                        }
                    }
                }
            }

            &-offer {
                display: flex;
                justify-content: space-between;
                align-items: baseline;
            }

            &-price {
                width: 110px;
                margin-right: 10px;
                font-size: 24px;
                font-weight: bold;
            }
        }
    }

    a.catalog__product-img {
        @include noUnderline;
    }

    .photobox {
        &:hover {
            .photobox__previewbox {
                &::before {
                    transform: translate(-50%, -50%) scale(4);
                    transition-duration: var(--photoboxAnimationDuration, .8s);
                }
            }
            .photobox__preview {
                transform: scale(1.2) rotate(5deg);
            }
        }

        &__previewbox {
            position: relative;
            overflow: hidden;

            &::before {
                content: "";
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 2;
                width: 0;
                height: 0;
                padding: 25%;
                background-color: $opacity45Black;
                border-radius: 50%;
                transition: transform calc(var(--photoboxAnimationDuration, .8s) / 2) ease;
                will-change: transform;
                transform: translate(-50%, -50%) scale(0);
            }
        }

        &__preview {
            transition: transform calc(var(--photoboxAnimationDuration, .8s) / 2) cubic-bezier(0.71, 0.05, 0.29, 0.9);
            will-change: transform;
            transform: scale(1) rotate(0);
            @include transition(all, 0.35s, ease-in-out);
        }
    }

</style>


