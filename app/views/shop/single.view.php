<div class="hero-wrap hero-bread" style="background-image: url('<?= IMG ?>bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="/"><?= $home ?></a></span><span class="mr-2"><a href="/shop"><?= $prod ?></a></span> <span><?= $h_p ?></span></p>
                <h1 class="mb-0 bread"><?= $h_p ?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 ftco-animate">
                <a href="<?= IMG.$product->img ?>" class="image-popup"><img src="<?= IMG.$product->img ?>" class="img-fluid" alt="Colorlib Template"></a>
            </div>
            <div class="col-lg-6 product-details pl-md-5 ftco-animate">
                <form method="post" action="/cart/add/<?= $product->id ?>" enctype="multipart/form-data" <?= (isset($_SESSION['user']) && $_SESSION['user'] != '')? '':'onsubmit="return false"'?> >
                    <div class="row">
                        <h3 class="col-6"><?= $product->product_data->name ?></h3>
                        <?php if(!empty($product->discounts))
                        {
                            if ($product->discounts[0]->type == '%'){
                                $price = round($product->price - ($product->price*$product->discounts[0]->amount)/100, 2, PHP_ROUND_HALF_UP);
                            }else{
                                $price = round($product->price - ($product->discounts[0]->amount), 2, PHP_ROUND_HALF_UP);
                            }
                        }else {
                            $price = round($product->price, 2, PHP_ROUND_HALF_UP);
                        } ?>
                        <p class="price col-6 text-right"><span class="text-primary">$<?= $price ?></span></p>
                    </div>
                    <p><?= $product->product_data->description ?></p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-group d-flex">
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select name="size" id="" class="form-control pl-2" <?= (isset($_SESSION['user']) && $_SESSION['user'] != '')? '':'disabled'?>>
                                        <?php
                                        if ($product->sizes != []){
                                            foreach ($product->sizes as $size){
                                                echo '<option value="' . $size->id . '">' . $size->size . '</option>';
                                            }
                                        }else{
                                            echo '<option selected>'.$no_sizes.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="input-group col-md-6 d-flex mb-3">
                            <span class="input-group-btn mr-2">
                                <button type="button" class="quantity-left-minus btn" <?= (isset($_SESSION['user']) && $_SESSION['user'] != '')? '':'disabled'?>  data-type="minus" data-field="" onclick="return min()">
                                   <i class="ion-ios-remove"></i>
                                </button>
                            </span>
                            <label style="z-index: -1">
                                <input type="number" id="quantity" name="quantity" <?= (isset($_SESSION['user']) && $_SESSION['user'] != '')? 'readonly':'disabled'?> class="form-control input-number" value="1" min="1" max="15" />
                            </label>
                            <span class="input-group-btn ml-2">
                                <button type="button" class="quantity-right-plus btn" <?= (isset($_SESSION['user']) && $_SESSION['user'] != '')? '':'disabled'?> data-type="plus" data-field="" onclick="return plus()">
                                     <i class="ion-ios-add"></i>
                                 </button>
                            </span><span class="ml-2">KG</span>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12 mt-1 mb-1">
                        </div>
                    </div>
                    <p><?= (isset($_SESSION['user']) && $_SESSION['user'] != '')?
                            '<input type="submit" class="btn btn-black py-3 px-5" name="sub" value="'.$addtc.'" />':
                            '<a class="btn btn-black py-3 px-5" href="/user/login">'.$Login.'</a>' ?></p>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-3 pb-3">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <span class="subheading"><?= $prod ?></span>
                <h2 class="mb-4"><?= $rprod ?></h2>
                <p><?= $rprod_p ?></p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php
                foreach ($related as $rel)
                {
                    $oldprice = round(floatval($rel->price), 2, PHP_ROUND_HALF_UP);
                    if (isset($rel->discounts) && $rel->discounts != []) {
                        if ($rel->discounts[0]->type == '%') {
                            $newprice = round($oldprice - (floatval($rel->discounts[0]->amount)*$oldprice/100), 2, PHP_ROUND_HALF_UP);
                        }elseif ($rel->discounts[0]->type == '$'){
                            $newprice = round($oldprice - $rel->discounts[0]->amount, 2, PHP_ROUND_HALF_UP);
                        }
                    }else{
                        $newprice = round(floatval($product->price), 2, PHP_ROUND_HALF_UP);
                    }
                    ?>
                    <div class="col-md-6 col-lg-3 ftco-animate">
                        <div class="product">
                            <a href="/shop/single/<?= $rel->id ?>" class="img-prod"><img class="img-fluid" src="<?= IMG.$rel->img ?>" alt="Colorlib Template">
                                <?= (isset($rel->discounts) && $rel->discounts != [])? '<span class="status">'.$rel->discounts[0]->amount.$rel->discounts[0]->type.'</span>':'' ?>
                                <div class="overlay"></div>
                            </a>
                            <div class="text py-3 pb-4 px-3 text-center">
                                <h3><a href="#"><?= $rel->product_data->name ?></a></h3>
                                <div class="d-flex">
                                    <div class="pricing">
                                        <p class="price"><?= (isset($rel->discounts) && $rel->discounts != [])? '<span class="mr-2 price-dc">$'.$oldprice.'</span>':''?><span class="price-sale">$<?= $newprice ?></p>
                                    </div>
                                </div>
                                <div class="bottom-area d-flex px-3">
                                    <div class="m-auto d-flex">
                                        <a href="/cart/add/<?= $rel->id ?>" class="buy-now d-flex justify-content-center align-items-center mx-1">
                                            <span><i class="ion-ios-cart"></i></span>
                                        </a>
                                        <a href="/wishlist/add/<?= $rel->id ?>" class="heart d-flex justify-content-center align-items-center ">
                                            <span><i class="ion-ios-heart"></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>
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