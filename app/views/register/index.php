<?php $this->start('body'); ?>
<div class="container center-align">
  <div class="wrapper">
    <div class="card slide-in-elliptic-right-fwd">
      <?php if (!currentUser()): ?>
        <div class="card-content">
          <form class="col s12 center-align" action="<?= PROOT ?>register/register" method="post">
            <?= csrfInput() ?>
            <?= displayErrors($this->displayErrors) ?>
            <div class="row">
              <div class="input-field col s12">
                <input name="email" id="email" type="email" class="validate">
                <label for="email">Email</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="username" id="username" type="text" class="validate">
                <label for="username"><?= __USERNAME ?></label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="fname" id="fname" type="text" class="validate">
                <label for="fname"><?= __FNAME ?></label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="lname" id="lname" type="text" class="validate">
                <label for="lname"><?= __LNAME ?></label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="password" id="password" type="password" class="validate">
                <label for="password"><?= __PASSWORD ?></label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="confirm" id="confirm" type="password" class="validate">
                <label for="confirm"><?= __CONFIRM ?></label>
              </div>
            </div>
            <button class="btn w-75 waves-effect waves-light" type="submit"><?= __REGISTER ?></button>
          </form>
        </div>
      <?php else: ?>
        <div class="card-content">
          <p><?= __REGISTERED ?></p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $this->end(); ?>
