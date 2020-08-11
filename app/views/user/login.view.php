<div class="hero-wrap hero-bread" style="background-image: url('../assets/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread"><?= $main_p ?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section contact-section bg-light">
    <div class="container">
        <div class="row block-9">
            <div class="col-md-6 order-md-last d-flex">
                <form action="#" method="post" class="bg-white p-5 contact-form">
                    <div class="col-12 bg-<?= ($status == false)? 'danger':'primary' ?> justify-content-center text-white text-center"><p><?= $msg ?></p></div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?= $email_p ?>" name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="<?= $pass ?>" name="pass">
                    </div>
                    <div class="row align-items-center">
                        <div class="form-group col-6">
                            <input type="submit" value="<?= $log ?>" name="sub" class="btn btn-primary py-3 px-5">
                        </div>
                        <div class="form-group small text-right col-6">
                            <p><?= $varify ?></p>
                        </div>
                    </div>
                    <div class="form-group small">
                        <p><?= $dont ?></p>
                    </div>
                </form>

            </div>
            <div class="col-md-6 d-flex">
                <div id="map" class="hero-wrap hero-bread" style="background-image: url('../assets/images/bg_4.jpg');"></div>
            </div>
    </div>
</section>