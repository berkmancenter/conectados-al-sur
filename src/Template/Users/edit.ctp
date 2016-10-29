<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?> <?= __('(EDITING)') ?></h3>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]) ?>"><i class='fi-magnifying-glass size-36'></i><?= __d('users', 'VIEW') ?></a>
            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . __d('users', 'DELETE'), ['controller' => 'Users', 'action' => 'delete', $user->id], [
                    'escape' => false, 
                    'confirm' => __d('users', 'Are you sure you want to delete this user?. This operation cannot be undone. All related projects will be erased!!')
                ])
            ?>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create() ?>
            
            <!-- name -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-torso"></i></span>
                    <?= $this->Form->input('name', [
                        'label'       => '',
                        'placeholder' => __d('auth', 'Your name') . ': John Smith',
                        'class'       => 'input-group-field',
                        'value'       => $user->name,
                    ]) ?>
                </div>
            </div>
                
            <!-- contact -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-address-book"></i></span>
                    <?= $this->Form->input('contact', [
                        'label'            => '',
                        'placeholder'      => __d('auth', 'Contact') . ': my.organization@example.com',
                        'class'            => 'input-group-field',
                        'aria-describedby' => 'contactHelpText',
                        'type'             => 'email',
                        'value'            => $user->contact,
                    ]) ?>
                </div>
                <p class="help-text" id="contactHelpText"><?= __d('auth', "Contact email. Public for everyone to see.") ?></p>
            </div>

            <!-- password -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-lock"></i></span>
                    <?= $this->Form->input('password', [
                        'label'            => '',
                        'placeholder'      => 'password',
                        'aria-describedby' => 'passwordHelpText',
                        'class'            => 'input-group-field',
                        'id'               => 'password',
                    ]) ?>
                </div>
                <p class="help-text" id="passwordHelpText"><?= __d('auth', "New Password. Leave this empty if you don't want to change your current password.") ?></p>
            </div>
 
            <!-- password repeat -->
      <!--       <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-lock"></i></span>
                    <div class="input password">
                        <input
                            name="repassword"
                            type="password"
                            class="input-group-field"
                            placeholder="password (again)"
                            
                        >
                    </div>
                </div>
            </div>
 -->
            <!-- genre -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-heart"></i></span>
                    <?= $this->Form->input('genre_id', [
                        'label'       => '',
                        'placeholder' => 'password',
                        'class'       => 'input-group-field',
                        'options'     => $lang_current == "en" ? $genres : $genres_es,
                    ]) ?>
                </div>
            </div>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>


<style type="text/css">

.form form input,
.form form select,
.form form span {
    height: 50px;
}

.input-group-label {
    width: 60px; /* same width to each label */
}

.input-group-label i {
    font-size: 30px;
    line-height: 45px;
    color: #999;
}

</style>