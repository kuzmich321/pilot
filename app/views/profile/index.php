<?php $this->start('body'); ?>
<div class="container center-align">
    <a class="waves-light btn-large custom-btn" href="<?= PROOT ?>register/logout">Log Out</a>
    <div class="wrapper">
        <div class="card slide-in-elliptic-right-fwd">
            <div class="card-content">
                <p>Name: <?= $this->user->username ?></p>
                <p>Email: <?= $this->user->email ?></p>
                <p>First name: <?= $this->user->fname ?></p>
                <p>Last name: <?= $this->user->lname ?></p>
            </div>
            <div class="card-action">
                <form action="<?= PROOT ?>profile/addFile" method="post" enctype="multipart/form-data">
                    <?= csrfInput() ?>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>File</span>
                            <input id="profile-input" type="file" name="file">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    <button type="submit" class="waves-light btn" disabled>Upload</button>
                </form>
            </div>
        </div>
        <?php if (currentUser()->file): ?>
        <div class="slide-in-elliptic-right-fwd">
            <p>Here's your file</p>
            <img src="<?= PROOT ?>/upload/<?= $this->user->file ?>">
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $this->end(); ?>
