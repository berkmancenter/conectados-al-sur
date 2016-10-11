<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns">
        <div class="signup-panel">
            <p class="welcome"><?= __d("auth", "Welcome to dvine!") ?></p>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>
                
                <!-- email -->
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-mail"></i></span>
                        <?= $this->Form->input('email', [
                            'label'       => '',
                            'placeholder' => 'john.smith@gmail.com',
                            'class'       => 'input-group-field', 
                            'required'
                        ]) ?>
                    </div>
                </div>

                <!-- password -->
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-lock"></i></span>
                        <?= $this->Form->input('password', [
                            'label'            => '',
                            'placeholder'      => __d('auth', 'password'),
                            'aria-describedby' => 'passwordHelpText',
                            'class'            => 'input-group-field',
                            'required'
                        ]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <?= $this->Form->button(__d('auth', 'Login'), ['class' => 'button']) ?>
                    </div>
                    <div class="small-6 columns">
                        <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'home']) ?>" class="alert hollow button"><?= $this->Loc->formCancel() ?></a>
                    </div>
                </div>  

            <?= $this->Form->end() ?>
            <p><?= __d("auth", "Don't have an account?") ?>
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>">
                    <?= __d("auth", "Sign up here") ?> &raquo
                </a>
            </p>
        </div>
    </div>
</div>

</div>

<style type="text/css">


.signup-panel {
    border-radius: 5px;
    border: 5px solid #ccc;
    padding: 15px;
    margin-top: 30px;
}

.signup-panel form input,
.signup-panel form span {
    height: 50px;
}

.signup-panel .input-group-label {
    width: 60px; /* same width to each label */
}

.signup-panel i {
    font-size: 30px;
    line-height: 45px;
    color: #999;
}
.signup-panel .welcome {
    font-size: 26px;
    text-align: center;
    margin-left: 0;
}
.signup-panel p {
    font-size: 13px;
    font-weight: 200;
    margin-top: 10px;
    margin-left: 0%;
}
.signup-panel .button {
    margin-left: 0%;
}
.signup-panel a.alert {
    float: right;
}
</style>