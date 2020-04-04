<?php $this->start('body'); ?>
<div class="container center-align">
  <div class="wrapper">
    <div class="card slide-in-elliptic-right-fwd">
      <div class="card-content">
        <p>Name: <?= $this->user->username ?></p>
        <p>Email: <?= $this->user->email ?></p>
        <p>First name: <?= $this->user->fname ?></p>
        <p>Last name: <?= $this->user->lname ?></p>
      </div>
    </div>
  </div>
</div>
<?php $this->end(); ?>
