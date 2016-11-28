<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns">
        <div class="signup-panel">
            <p class="welcome"><?= __d('users', 'Add Profile') ?></p>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create($instances_user) ?>

            <p><?= __d('users', 'To register a new profile, you need the app name and its passphrase. The app admin can give you more details about this.') ?></p>

            <!-- name -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-puzzle"></i></span>
                    <?= $this->Form->input('instance_namespace', [
                        'label'       => '',
                        'placeholder' => __d('users', 'App shortname'),
                        'class'       => 'input-group-field',
                        'value'       => 'cas'
                    ]) ?>
                </div>
            </div>

            <!-- passphrase -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-key"></i></span>
                    <?= $this->Form->input('passphrase', [
                        'label'       => '',
                        'placeholder' => __d('users', 'App passphrase'),
                        'class'       => 'input-group-field',
                        'type'        => 'password',
                        'value'       => 'token'
                    ]) ?>
                </div>
            </div>


            <!-- submit, cancel -->
            <div class="row">
                <div class="small-6 columns">
                    <?= $this->Form->button(__d('users', 'Create profile'), ['class' => 'button']) ?>
                </div>
                <div class="small-6 columns">
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user_id]) ?>" class="alert hollow button"><?= __('CANCEL') ?></a>
                </div>
            </div>
        
            <?= $this->Form->end() ?>
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
.signup-panel form select,
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
.signup-panel .alert {
    float: right;
}
</style>