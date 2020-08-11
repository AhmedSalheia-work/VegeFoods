<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
    <div class="container">
        <a class="navbar-brand" href="/">Vegefoods</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="ftco-nav">
            <ul class="navbar-nav ml-auto">
                <?php
                    foreach ($headerlinks as $title => $link)
                    {
                        if ($title == 'logout'){
                            $log_link = $link;
                            $log_title = $title;
                            continue;
                        }

                        $class = '';
                        if (strtolower($title) == strtolower($page))
                        { $class = 'active';}

                        if (strtolower($title) == 'usr_image'){
                            echo '<li class="nav-item"><a href="/user/profile" style="padding-top: 5px!important; padding-bottom: 5px!important;" class="nav-link testimony-wrap"><img src="'.IMG.$link.'" alt="Progile" style="width: 50px; height: 50px;" title="Profile" class="user-img" /></a></li>';
                        }else{
                            echo '<li class="nav-item '.$class.'"><a href="'.$link.'" class="nav-link">'.$title.'</a></li>';
                        }
                    }
                ?>
                <?=
                (isset($_SESSION['user']) && $_SESSION['user'] != '')?
                    '<li class="nav-item cta cta-colored"><a href="/cart" class="nav-link h-100"><span class="icon-shopping_cart"></span>['.$cart.']</a></li>
                     <li class="nav-item cta cta-colored-2"><a href="/wishlist" class="nav-link h-100"><span class="icon-heart"></span>['.$wishlist.']</a></li>':'';
                ?>
                <?=  isset($log_link) ?'<li class="nav-item"><a href="'.$log_link.'/'.$_SESSION['user']->token.'" class="nav-link">'.$log_title.'</a></li>':'' ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $lang ?></a>
                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <?php
                            foreach (SUPPORTED_LANGS_FULL as $key => $value)
                            {
                          ?>
                                <a class="dropdown-item" href="/language/change/<?= $key ?>"><?= $value ?></a>
                          <?php
                            }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>