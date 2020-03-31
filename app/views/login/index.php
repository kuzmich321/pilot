<?php $this->start('body'); ?>
<div class="container center-align">
    <div class="wrapper">
        <div class="card slide-in-elliptic-right-fwd">
            <div class="card-content">
                <form class="col s12 center-align">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" class="validate">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <button class="btn w-75 waves-effect waves-light" type="submit" name="action">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->end(); ?>
