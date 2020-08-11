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
            <form action="#" method="post" class="row block-9" enctype="multipart/form-data">
                <div class="col-md-6 order-md-last d-flex">
                    <div class="contact-form bg-white p-5">
                        <div class="col-12 bg-<?= ($status == false)? 'danger':'primary' ?> justify-content-center text-white text-center"><p><?= $msg ?></p></div>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="<?= $name ?>" value="<?= $_SESSION['user']->name ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="<?= $email_p ?>" value="<?= $_SESSION['user']->email ?>" disabled>
                        </div>
                        <div class="form-group">
                            <input type="date" name="date" class="form-control" value="<?= $_SESSION['user']->birthdate ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" name="job" class="form-control" value="<?= $_SESSION['user']->job ?>">
                        </div>
                        <div class="form-group">
                            <textarea name="bio" id="" cols="30" rows="7" class="form-control" placeholder="<?= $bio ?>"><?= isset($_SESSION['user']->bio)? html_entity_decode(($_SESSION['user']->bio)):'';?></textarea>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="<?= $pass ?>" name="pass" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="<?= $conf ?>" class="form-control" value="" onchange="if (this.value == document.querySelector('input[name=\'pass\']').value){this.style.border = '1.5px solid green'}else{this.style.border = '1.5px solid red'}">
                        </div>

                        <div class="form-group text-center">
                            <input type="submit" name="sub" value="<?= $upd ?>" class="btn btn-primary py-3 px-5">
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex">
                    <div id="map"  class="hero-wrap hero-bread col-12" style="background-image: url('<?= IMG.$_SESSION['usr_img'] ?>');"></div>
                    <input type="file" name="userImg" id="map"  class="hero-wrap hero-bread" style="position: absolute;cursor: pointer;width: 100%;height: 100%;opacity: 0;" accept=".jpg,.jpeg,.png,.svg">
                </div>
            </form>
    </div>
</section>