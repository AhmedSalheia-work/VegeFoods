<section id="home-section" class="hero">
    <div class="home-slider owl-carousel">
        <div class="slider-item" style="background-image: url(<?= IMG ?>bg_1.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-md-12 ftco-animate text-center">
                        <h1 class="mb-2"><?= $img1_h1 ?></h1>
                        <h2 class="subheading mb-4"><?= $img1_h3 ?></h2>
                        <p><a href="/index/about" class="btn btn-primary"><?= $details ?></a></p>
                    </div>

                </div>
            </div>
        </div>

        <div class="slider-item" style="background-image: url(<?= IMG ?>bg_2.jpg);">
            <div class="overlay"></div>
            <div class="container">
                <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

                    <div class="col-sm-12 ftco-animate text-center">
                        <h1 class="mb-2"><?= $img2_h1 ?></h1>
                        <h2 class="subheading mb-4"><?= $img2_h3 ?></h2>
                        <p><a href="/index/about" class="btn btn-primary"><?= $details ?></a></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row no-gutters ftco-services">
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-1 active d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-shipped"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Free Shipping</h3>
                        <span>On order over $100</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-2 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-diet"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Always Fresh</h3>
                        <span>Product well package</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-3 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-award"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Superior Quality</h3>
                        <span>Quality Products</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center d-flex align-self-stretch ftco-animate">
                <div class="media block-6 services mb-md-0 mb-4">
                    <div class="icon bg-color-4 d-flex justify-content-center align-items-center mb-2">
                        <span class="flaticon-customer-service"></span>
                    </div>
                    <div class="media-body">
                        <h3 class="heading">Support</h3>
                        <span>24/7 Support</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-category ftco-no-pt">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 order-md-last align-items-stretch d-flex">
                        <div class="category-wrap-2 ftco-animate img align-self-stretch d-flex" style="background-image: url(<?= IMG ?>category.jpg);">
                            <div class="text text-center">
                                <h2><?= $Vegetables ?></h2>
                                <p><?= $protect ?></p>
                                <p><a href="/shop" class="btn btn-primary"><?= $shop ?></a></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(<?= IMG ?>category-1.jpg);">
                            <div class="text px-3 py-1">
                                <h2 class="mb-0"><a href="/shop/default/cat/2"><?= $f ?></a></h2>
                            </div>
                        </div>
                        <div class="category-wrap ftco-animate img d-flex align-items-end" style="background-image: url(<?= IMG ?>category-2.jpg);">
                            <div class="text px-3 py-1">
                                <h2 class="mb-0"><a href="/shop/default/cat/1"><?= $Vegetables ?></a></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="category-wrap ftco-animate img mb-4 d-flex align-items-end" style="background-image: url(<?= IMG ?>category-3.jpg);">
                    <div class="text px-3 py-1">
                        <h2 class="mb-0"><a href="/shop/default/cat/3"><?= $J ?></a></h2>
                    </div>
                </div>
                <div class="category-wrap ftco-animate img d-flex align-items-end" style="background-image: url(<?= IMG ?>category-4.jpg);">
                    <div class="text px-3 py-1">
                        <h2 class="mb-0"><a href="/shop/default/cat/4"><?= $D ?></a></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading"><?= $f_p ?></span>
                <h2 class="mb-4"><?= $o_p ?></h2>
                <p><?= $o_p_p?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
    <?php
        for ($i=0;$i<8;$i++){
            $oldprice = round(floatval($products[$i]->price), 2, PHP_ROUND_HALF_UP);
            if (isset($products[$i]->discounts) && $products[$i]->discounts != []) {
                if ($products[$i]->discounts[0]->type == '%') {
                    $newprice = round($oldprice - (floatval($products[$i]->discounts[0]->amount)*$oldprice/100), 2, PHP_ROUND_HALF_UP);
                }elseif ($products[$i]->discounts[0]->type == '$'){
                    $newprice = round($oldprice - $products[$i]->discounts[0]->amount, 2, PHP_ROUND_HALF_UP);
                }
            }else{
                $newprice = round(floatval($products[$i]->price), 2, PHP_ROUND_HALF_UP);
            }
            echo '
            <div class="col-md-6 col-lg-3 ftco-animate">
                    <div class="product">
                        <a href="/shop/single/'.$products[$i]->id.'" class="img-prod"><img class="img-fluid" src="'.IMG.$products[$i]->img.'" alt="Colorlib Template">
                            '.((isset($products[$i]->discounts) && $products[$i]->discounts != [])? '<span class="status">'.$products[$i]->discounts[0]->amount.$products[$i]->discounts[0]->type.'</span>':'').'
                            <div class="overlay"></div>
                        </a>
                        <div class="text py-3 pb-4 px-3 text-center">
                            <h3><a href="#">'.$products[$i]->product_data->name.'</a></h3>
                            <div class="d-flex">
                                <div class="pricing">
                                    <p class="price">'.((isset($products[$i]->discounts) && $products[$i]->discounts != [])? '<span class="mr-2 price-dc">$'.$oldprice.'</span>':'').'<span class="price-sale">$'.$newprice.'</span></p>
                                </div>
                            </div>
                            <div class="bottom-area d-flex px-3">
                                <div class="m-auto d-flex">
                            '.((isset($_SESSION['user']) && $_SESSION['user'] != '')?
                            '<a href="/cart/add/'.$products[$i]->id.'" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                <span><i class="ion-ios-cart"></i></span>
                            </a>
                            <a href="/wishlist/add/'.$products[$i]->id.'" class="heart d-flex justify-content-center align-items-center ">
                                <span><i class="ion-ios-heart"></i></span>
                            </a>':
                            '<a href="/user/login" class="text-center justify-content-center align-items-center d-flex" style="font-size: 0.55vw">'.$Login.'</a>').'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }
   ?>
        </div>
    </div>
</section>

<section class="ftco-section img" style="background-image: url(<?= IMG ?>bg_3.jpg);">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-6 heading-section ftco-animate deal-of-the-day ftco-animate">
                <span class="subheading">Best Price For You</span>
                <h2 class="mb-4">Deal of the day</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia</p>
                <h3><a href="#">Spinach</a></h3>
                <span class="price">$10 <a href="#">now $5 only</a></span>
                <div id="timer" class="d-flex mt-5">
                    <div class="time" id="days"></div>
                    <div class="time pl-3" id="hours"></div>
                    <div class="time pl-3" id="minutes"></div>
                    <div class="time pl-3" id="seconds"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section testimony-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading"><?= $test ?></span>
                <h2 class="mb-4"><?= $test_p1 ?></h2>
                <p><?= $test_p2 ?></p>
            </div>
        </div>
        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-testimony owl-carousel">
                    <?php
                    foreach ($feedbacks as $feedback)
                    {
                        ?>

                        <div class="item">
                            <div class="testimony-wrap p-4 pb-5">
                                <div class="user-img mb-5" style="background-image: url(..<?= IMG.$feedback->user->img ?>)">
                                        <span class="quote d-flex align-items-center justify-content-center">
                                          <i class="icon-quote-left"></i>
                                        </span>
                                </div>
                                <div class="text text-center">
                                    <p class="mb-5 pl-4 line"><?php echo $feedback->feedback ?>.</p>
                                    <p class="name"><?= ucwords($feedback->user->name) ?></p>
                                    <span class="position"><?= $feedback->user->job ?></span>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<hr>

<section class="ftco-section ftco-partner">
    <div class="container">
        <div class="row">
            <div class="col-sm ftco-animate">
                <a href="#" class="partner"><img src="<?= IMG ?>partner-1.png" class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-sm ftco-animate">
                <a href="#" class="partner"><img src="<?= IMG ?>partner-2.png" class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-sm ftco-animate">
                <a href="#" class="partner"><img src="<?= IMG ?>partner-3.png" class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-sm ftco-animate">
                <a href="#" class="partner"><img src="<?= IMG ?>partner-4.png" class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-sm ftco-animate">
                <a href="#" class="partner"><img src="<?= IMG ?>partner-5.png" class="img-fluid" alt="Colorlib Template"></a>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
        <div class="row d-flex justify-content-center py-5">
            <div class="col-md-6">
                <h2 style="font-size: 22px;" class="mb-0"><?= $newsletter ?></h2>
                <span><?= $newsletter_d ?></span>
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <form action="#" class="subscribe-form">
                    <div class="form-group d-flex">
                        <input type="text" class="form-control" placeholder="<?= $eye ?>">
                        <input type="submit" value="<?= $sub ?>" class="submit px-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>