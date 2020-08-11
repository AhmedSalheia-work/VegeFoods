<div class="hero-wrap hero-bread" style="background-image: url('..<?= IMG ?>bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="/"><?= $home?></a></span> <span><?= $h_p ?></span></p>
                <h1 class="mb-0 bread"><?= $h_p ?></h1>
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
                            <th><?= $Product_List ?></th>
                            <th>&nbsp;</th>
                            <th colspan="2"><?= $Details ?></th>
                            <th><?= $Price ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($products as $product)
                            {
                                $str = explode(' ',$product->productDescription,19);
                                $str[18] = '';
                                $str = implode(' ',$str);
                                echo '
                                    <tr class="text-center">
                                        <td class="product-remove"><a href="/wishlist/delete/'.$product->productId.'"><span class="ion-ios-close"></span></a></td>
            
                                        <td class="image-prod"><div class="img" style="background-image:url(..'.IMG.$product->productImage.');"></div></td>
            
                                        <td class="product-name">
                                            <h3>'.$product->productName.'</h3>
            
                                        </td>
                                        <td class="quantity" colspan="2">
                                            <p>'.$str.'<a class="text-primary text-decoration-none" title="Read More" href="/shop/single/'.$product->productId.'" style="font-size: 1.8vw">...</a></p>
                                        </td>
            
                                        <td class="total">$'.$product->productPrice.'</td>
                                    </tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pt ftco-no-pb py-5 bg-light">
    <div class="container py-4">
    </div>
</section>