<footer class="ftco-footer ftco-section">
    <div class="container">
        <div class="row">
            <div class="mouse">
                <a href="#" class="mouse-icon">
                    <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                </a>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2">Vegefoods</h2>
                    <p><?= $site_description ?></p>
                    <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                        <li class="ftco-animate"><a href="<?= $twitter ?>"><span class="icon-twitter"></span></a></li>
                        <li class="ftco-animate"><a href="<?= $facebook ?>"><span class="icon-facebook"></span></a></li>
                        <li class="ftco-animate"><a href="<?= $instagram ?>"><span class="icon-instagram"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4 ml-md-5">
                    <h2 class="ftco-heading-2"><?= $menu ?></h2>
                    <ul class="list-unstyled">
                        <?php
                            foreach ($menu_links as $item => $link) {
                                echo '<li><a href="'.$link.'" class="py-2 d-block">'.$item.'</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md">
                <div class="ftco-footer-widget mb-4">
                    <h2 class="ftco-heading-2"><?= $HaQ ?></h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li><span class="icon icon-map-marker"></span><span class="text"><?= $address ?></span></li><br/>
                            <li><a href="#"><span class="icon icon-phone"></span><span class="text"><?= $phone ?></span></a></li>
                            <li><a href="mailto: <?= $email ?>"><span class="icon icon-envelope"></span><span class="text"><?= $email ?></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">

                <p>
                    <?= $lic ?>
                </p>
            </div>
        </div>
    </div>
</footer>

<script>var timer = '<?= $timer ?>'</script>