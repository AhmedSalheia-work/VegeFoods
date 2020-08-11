<div class="hero-wrap hero-bread" style="background-image: url('..<?= IMG ?>bg_1.jpg');">
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
                        <input type="text" class="form-control" placeholder="<?= $name ?>" name="name" onchange="return check();">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="<?= $email_p ?>" name="email" onchange="return check();">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <input type="number" class="form-control col-3 ml-3" min="1" max="31" placeholder="<?= $Day ?>" name="day" onchange="return check();">
                            <input type="number" class="form-control col-3 ml-4" min="1" max="12" placeholder="<?= $Month ?>" name="month" onchange="return check();">
                            <input type="number" class="form-control col-4 ml-4" min="1750" max=<?= date('Y'); ?> placeholder="<?= $Year ?>" name="year" onchange="return check();">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="<?= $pass ?>" name="password" onchange="return check();">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="<?= $conf ?>" id="conf" onchange="return check();">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="<?= $reg ?>" class="btn btn-primary py-3 px-5" name="sub" disabled id="but">
                    </div>
                </form>

            </div>
            <div class="col-md-6 d-flex">
                <div id="map" class="hero-wrap hero-bread" style="background-image: url('..<?= IMG ?>bg_4.jpg');"></div>
            </div>
        </div>
</section>