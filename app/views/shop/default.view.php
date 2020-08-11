<div class="hero-wrap hero-bread" style="background-image: url('<?= IMG ?>bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="/"><?= $home ?></a></span> <span><?= $h_p ?></span></p>
                <h1 class="mb-0 bread"><?= $h_p ?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-5 text-center">
                <ul class="product-category">
                    <li><a href="/shop/default" <?= (($cat == '')? 'class="active"':'') ?>><?= $all ?></a></li>
                    <?php
                        $catagories = array_reverse($catagories);
                        foreach ($catagories as $category)
                        {
                            echo '<li><a href="/shop/default/cat/'.$category->id.'"'.(($cat == $category->id)? 'class="active"':'').'>'.$category->category.'</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <?php
                shuffle($products);
                foreach ($products as $product)
                {
                    $oldprice = round(floatval($product->price), 2, PHP_ROUND_HALF_UP);
                    if (isset($product->discounts) && $product->discounts != []) {
                        if ($product->discounts[0]->type == '%') {
                            $newprice = round($oldprice - (floatval($product->discounts[0]->amount)*$oldprice/100), 2, PHP_ROUND_HALF_UP);
                        }elseif ($product->discounts[0]->type == '$'){
                            $newprice = round($oldprice - $product->discounts[0]->amount, 2, PHP_ROUND_HALF_UP);
                        }
                    }else{
                        $newprice = round(floatval($product->price), 2, PHP_ROUND_HALF_UP);
                    }
                    ?>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="product">
                            <a href="/shop/single/<?= $product->id ?>" class="img-prod"><img class="img-fluid" src="<?= IMG.$product->img ?>" alt="Colorlib Template">
                                <?= (isset($product->discounts) && $product->discounts != [])? '<span class="status">'.$product->discounts[0]->amount.$product->discounts[0]->type.'</span>':'' ?>
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="#"><?= $product->product_data->name ?></a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price"><?= (isset($product->discounts) && $product->discounts != [])? '<span class="mr-2 price-dc">$'.$oldprice.'</span>':''?><span class="price-sale">$<?= $newprice ?></span></p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                <?= (isset($_SESSION['user']) && $_SESSION['user'] != '')?
                                '<a href="/cart/add/'.$product->id.'" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                            <span><i class="ion-ios-cart"></i></span>
                                        </a>
                                        <a href="/wishlist/add/'.$product->id.'" class="heart d-flex justify-content-center align-items-center ">
                                            <span><i class="ion-ios-heart"></i></span>
                                        </a>':'<a href="/user/login" class="text-center justify-content-center align-items-center d-flex" style="font-size: 0.55vw">'.$Login.'</a>'
                                ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>

        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>

                        <?php
                            $page = intval($page_num);
                            $pages = intval($pages_num);

                            $past = (($page - 1) == 0)? '#' : '?page='.($page - 1);
                            $next = (($page + 1) > $pages)? '#' : '?page='.($page + 1);

                            echo '<li><a href="'.$past.'">&lt;</a></li>';

                            for ($i=1;$i<=$pages;$i++)
                            {
                                if ($i == $page) {
                                    echo '<li class="active"><span>' . $i . '</span></li>';
                                }else{
                                    echo '<li><a href="?page='.$i.'">'.$i.'</a></li>';
                                }
                            }

                            echo '<li><a href="'.$next.'">&gt;</a></li>';
                        ?>
                    </ul>
                </div>
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
                        <input type="text" class="form-control" placeholder="<?= $enterE ?>">
                        <input type="submit" value="<?= $sub ?>" class="submit px-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>