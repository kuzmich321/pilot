<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?= PROOT ?>css/style.css">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->

  <?= $this->content('head'); ?>

    <title><?= $this->getSiteTitle(); ?></title>
</head>
<body class="color-change-2x">
<nav>
    <div class="nav-wrapper">
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li>
                <form method="get" id="form_lang">
                    <a class='dropdown-trigger' href='#' data-target='dropdown1' onchange="changeLang()"><?= __LANGUAGE ?></a>
                    <ul id='dropdown1' class='dropdown-content'>
                        <li><a href="?lang=en"><?= __EN ?></a></li>
                        <li><a href="?lang=ru"><?= __RU ?></a></li>
                    </ul>
                </form>
            </li>
            <li><a href="<?= PROOT ?>"><?= __HOME ?></a></li>
            <li><a href="<?= PROOT ?>register/login"><?= __LOGIN ?></a></li>
            <li><a href="<?= PROOT ?>register/register"><?= __REGISTER ?></a></li>
          <?php if (currentUser()): ?>
              <li><a href="<?= PROOT ?>profile"><?= __PROFILE ?></a></li>
              <li>
                  <a class="brand-logo right hide-on-med-and-down" href="<?= PROOT ?>register/logout"><?= __LOGOUT ?></a>
              </li>
          <?php endif; ?>
        </ul>
    </div>
</nav>
<?= $this->content('body'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="<?= PROOT ?>js/index.js"></script>
</body>
</html>
