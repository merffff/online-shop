<article class="catalog">
    <div class="container-mix  catalog__list">

        <div class="catalog__product  mix  cheap">
            <?php foreach ($products as $product): ?>
                <a class="catalog__product-img" href="/">
                    <img src="<?php echo $product->getImage();?>" width="330" alt="">
                </a>

                <div class="catalog__product-body">
                    <h2 class="catalog__product-title"><?php echo $product->getCategory();?>
                        <a href="/"><?php echo $product->getNameproduct();?></a></h2>


                </div>

                <div class="catalog__product-offer">
                    <p class="catalog__product-price"><?php echo $product->getPrice();?></p>
                    <a href="/add-product">Добавить в корзину</a>
                </div>
            <?php endforeach;?>
        </div>

        <a href="/orders">Мои заказы</a>

        <a href="/logout">Выйти</a>

    </div>
</article>

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


