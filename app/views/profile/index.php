<?php $this->start('body'); ?>
<div class="container center-align">
    <div class="wrapper">
        <div class="card slide-in-elliptic-right-fwd">
            <div class="card-content">
                <p><?= __USERNAME ?>: <?= $this->user->username ?></p>
                <p>Email: <?= $this->user->email ?></p>
                <p><?= __FNAME ?>: <?= $this->user->fname ?></p>
                <p><?= __LNAME ?>: <?= $this->user->lname ?></p>
            </div>
            <div class="card-action">
                <form action="<?= PROOT ?>profile/addFile" method="post" enctype="multipart/form-data">
                  <?= csrfInput() ?>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span><?= __FILE ?></span>
                            <input id="profile-input" type="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button type="submit" class="waves-light btn" disabled><?= __UPLOAD ?></button>
                </form>
            </div>
        </div>
      <?php if (currentUser()->file): ?>
          <div class="slide-in-elliptic-right-fwd">
              <p><?= __HERE_FILE ?></p>
              <img src="<?= PROOT ?>/upload/<?= $this->user->file ?>" alt="#">
          </div>
      <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('profile-input').addEventListener('change', function () {
        document.querySelector('button[type=submit]').disabled = false;
    })
</script>
<?php $this->end(); ?>
