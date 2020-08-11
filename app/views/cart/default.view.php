<div class="hero-wrap hero-bread" style="background-image: url('../<?= IMG ?>bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="/"><?= $home ?></a></span> <span><?= $h_p ?></span></p>
                <h1 class="mb-0 bread"><?= $h_p ?>  </h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section ftco-cart">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <div class="cart-list">
                    <table class="table">
                        <thead class="thead-primary">
                        <tr class="text-center">
                            <th>&nbsp;</th>
                            <th><?=$image ?></th>
                            <th><?=$name?></th>
                            <th><?=$Price?></th>
                            <th><?=$Quantity?></th>
                            <th><?=$Total?></th>
                            <th><?=$Drop?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $subtotal = 0;
                            foreach ($products as $product) {
                                echo '
                                    <tr class="text-center">
                                        <td class="product-remove"><a href="/cart/delete/'.$product->productId.'/'.$product->productSize->id.'"><span class="ion-ios-close"></span></a></td>
            
                                        <td class="image-prod"><div class="img" style="background-image:url(..'.IMG.$product->productImage.');"></div></td>
            
                                        <td class="product-name">
                                            <h3>'.$product->productName.'</h3>
                                            <p>'.$product->productSize->size.'</p>
                                        </td>
            
                                        <td class="price">$'.$product->productPrice.'</td>
            
                                        <td class="quantity">
                                            <div class="input-group mb-3">
                                                <input type="text" name="quantity" class="quantity form-control input-number" readonly value="'.$product->quantity.'" min="1" max="100">
                                            </div>
                                        </td>
            
                                        <td class="total">$'.$product->total.'</td>
                                        <td>
                                            <div class="row">
                                                <div class="row col-12">
                                                    <div class="col-8 d-flex align-items-center justify-content-center p-0">
                                                        <input type="text" name="drop_'.$product->productId.'" class="form-control input-number" value="0" min="1" max="'.$product->quantity.'">
                                                    </div>
                                                    <div class="ml-2 col-3 p-0 row">
                                                        <button class="btn btn-outline-success col-12 border-success text-dark text-light-hover" style="font-size: 16px" onclick="return addprod(\''.$product->productId.'\',\''.$product->productSize->id.'\')"><span class="ion ion-md-add-circle"></span></button>
                                                        <button class="btn btn-outline-danger col-12 border-danger text-dark text-light-hover" style="font-size: 16px"   onclick="return dropprod(\''.$product->productId.'\',\''.$product->productSize->id.'\')"><span class="ion ion-md-trash w-100"></span></button>
                                                    </div>
                                                </div>
                                                <div class="row col-12">
                                                    <div id="err_drop_'.$product->productId.'" class="bg-danger text-white col-12 mt-0"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                ';
                                $subtotal += $product->total;
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row justify-content-end">
<!--            <div class="col-lg-4 mt-5 cart-wrap ftco-animate">-->
<!--                <div class="cart-total mb-3">-->
<!--                    <h3>Coupon Code</h3>-->
<!--                    <p>Enter your coupon code if you have one</p>-->
<!--                    <form action="#" class="info">-->
<!--                        <div class="form-group">-->
<!--                            <label for="">Coupon code</label>-->
<!--                            <input type="text" class="form-control text-left px-3" placeholder="">-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--                <p><a href="checkout.html" class="btn btn-primary py-3 px-4">Apply Coupon</a></p>-->
<!--            </div>-->
<!--            <div class="col-lg-4 mt-5 cart-wrap ftco-animate">-->
<!--                <div class="cart-total mb-3">-->
<!--                    <h3>Estimate shipping and tax</h3>-->
<!--                    <p>Enter your destination to get a shipping estimate</p>-->
<!--                    <form action="#" class="info">-->
<!--                        <div class="form-group">-->
<!--                            <label for="">Country</label>-->
<!--                            <input type="text" class="form-control text-left px-3" placeholder="">-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <label for="country">State/Province</label>-->
<!--                            <input type="text" class="form-control text-left px-3" placeholder="">-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <label for="country">Zip/Postal Code</label>-->
<!--                            <input type="text" class="form-control text-left px-3" placeholder="">-->
<!--                        </div>-->
<!--                    </form>-->
<!--                </div>-->
<!--                <p><a href="checkout.html" class="btn btn-primary py-3 px-4">Estimate</a></p>-->
<!--            </div>-->
            <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                    <h3><?= $Cart_Totals ?></h3>
                    <p class="d-flex">
                        <span><?= $Subtotal ?></span>
                        <span>$<?= $subtotal ?></span>
                    </p>
                    <p class="d-flex">
                        <span><?= $Delivery ?></span>
                        <span>$<?= $delivery ?>.00</span>
                    </p>
                    <p class="d-flex">
                        <span><?= $Discount ?></span>
                        <span>$<?= $discount ?>.00</span>
                    </p>
                    <hr>
                    <p class="d-flex total-price">
                        <span><?= $Total ?></span>
                        <span>$<?= ($subtotal == 0)? 0 : ($subtotal+$delivery)-$discount ?></span>
                    </p>
                </div>
                <p><a href="/checkout" class="btn btn-primary py-3 px-4 <?= ($subtotal == 0)? 'disabled':'' ?>"><?= $PTC ?></a></p>
            </div>
        </div>
    </div>
</section>