<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
<!--
        <div class="form">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('main_organization', ['label' => 'Main organization you work in.', 'placeholder' => 'e.g. United Nations']);
                    echo $this->Form->input('organization_type_id', ['label' => 'Type of this organization', 'options' => $organizationTypes]);
                ?>
            </fieldset>
        </div>
    
 -->
<div class="row">
    <div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns">
        <div class="signup-panel">
            <p class="welcome">New Account</p>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-torso"></i></span>
                        <?= $this->Form->input('name', ['label' => '', 'placeholder' => 'Your name: John Smith', 'class' => 'input-group-field']) ?>
                    </div>
                </div>
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-mail"></i></span>
                        <?= $this->Form->input('email', ['label' => '', 'placeholder' => 'Username: john.smith@gmail.com', 'class' => 'input-group-field', 'aria-describedby' => 'emailHelpText']) ?>
                    </div>      
                    <p class="help-text" id="emailHelpText">Your email will serve as username and it will be treated as private.</p>
                </div>
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-address-book"></i></span>
                        <?= $this->Form->input('contact', ['label' => '', 'placeholder' => 'Contact: my.organization@example.com', 'class' => 'input-group-field', 'aria-describedby' => 'contactHelpText']) ?>
                    </div>
                    <p class="help-text" id="contactHelpText">Contact email. Public for everyone to see.</p>
                </div>
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-lock"></i></span>
                        <?= $this->Form->input('password', ['label' => '', 'placeholder' => 'password', 'aria-describedby' => 'passwordHelpText', 'class' => 'input-group-field']) ?>
                    </div>
                    <!-- <p class="help-text" id="passwordHelpText">Your password must have at least 6 characters.</p> -->
                </div>
                <div class="row collapse">
                    <div class="input-group">
                        <span class="input-group-label"><i class="fi-heart"></i></span>
                        <?= $this->Form->input('genre_id', ['label' => '', 'placeholder' => 'password', 'class' => 'input-group-field', 'options' => $genres]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="small-6 columns">
                        <?= $this->Form->button(__('Create account'), ['class' => 'button']) ?>
                    </div>
                    <div class="small-6 columns">
                        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'home']) ?> class="alert hollow button">CANCEL</a>
                    </div>
                </div>
            <?= $this->Form->end() ?>
            <p>Already have an account?
                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>>Login here &raquo</a>
            </p>
        </div>
    </div>
</div>
</div>

<style type="text/css">
.signup-panel {
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 15px;
    margin-top: 30px;
}

.signup-panel form input,
.signup-panel form select,
.signup-panel form span {
    height: 50px;
}

.signup-panel i {
    font-size: 30px;
    line-height: 45px;
    color: #999;
}
.signup-panel .fi-heart {
    /*color: red;*/
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
.signup-panel .alert {
    float: right;
}
</style>