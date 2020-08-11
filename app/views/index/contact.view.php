<div class="hero-wrap hero-bread" style="background-image: url('../assets/images/bg_1.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="/"><?= $home ?></a></span> <span><?= $h_p ?></span></p>
                <h1 class="mb-0 bread"><?= $h_p ?></h1>
            </div>
        </div>
    </div>
</div>

<section class="ftco-section contact-section bg-light">
    <div class="container">
        <div class="row d-flex mb-5 contact-info">
            <div class="w-100"></div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span><?= $address_p ?>:</span>  <?= ($address) ?></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span><?= $phone_p ?>:</span> <a href="tel://1234567920"><?= $phone ?></a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span><?= $email_p1 ?>:</span> <a href="mailto:info@yoursite.com"><?= $email ?></a></p>
                </div>
            </div>
            <div class="col-md-3 d-flex">
                <div class="info bg-white p-4">
                    <p><span><?= $Website ?></span> <a href="https://www.ramlekaap.com/">ramlekaap.com</a></p>
                </div>
            </div>
        </div>
        <div class="row block-9">
            <div class="col-md-6 order-md-last d-flex">
                <form action="#" class="bg-white p-5 contact-form" method="post">
                    <div class="col-12 bg-<?= ($status == false)? 'danger':'primary' ?> justify-content-center text-white text-center"><p><?= $msg ?></p></div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?= $name ?>" name="name" value="<?= $usr_name ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?= $email_p ?>" name="email" value="<?= $usr_email ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?= $subject ?>" name="subject">
                    </div>
                    <div class="form-group">
                        <textarea name="message" id="" cols="30" rows="7" class="form-control" placeholder="<?= $message ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="sub" value="<?= $send.' '.$message ?>" class="btn btn-primary py-3 px-5">
                    </div>
                </form>

            </div>

            <div class="col-md-6 d-flex">
                <div id="map"  class="hero-wrap hero-bread" style="background-image: url('../assets/images/bg_4.jpg');"></div>
            </div>
        </div>
    </div>
</section>