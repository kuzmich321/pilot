<?php $this->start('body'); ?>
<div class="container center-align">
    <div class="wrapper">
        <div class="card slide-in-elliptic-right-fwd">
          <?php if (!currentUser()): ?>
              <div class="card-content">
                  <form class="col s12 center-align" action="<?= PROOT ?>register/login" method="post">
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
                              <input name="password" id="password" type="password" class="validate">
                              <label for="password">Password</label>
                          </div>
                      </div>
                      <button class="btn w-75 waves-effect waves-light" type="submit">Login</button>
                  </form>
              </div>
          <?php else: ?>
              <div class="card-content">
                  <p>You are already logged in</p>
              </div>
          <?php endif; ?>
        </div>
    </div>
</div>
<?php $this->end(); ?>
