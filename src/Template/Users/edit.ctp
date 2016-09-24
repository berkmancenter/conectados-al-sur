<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?> (EDITING)</h3>
            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]) ?>><i class='fi-magnifying-glass size-36'></i>VIEW</a>
            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['controller' => 'Users', 'action' => 'delete', $user->id], [
                    'escape' => false, 
                    'confirm' => __('Are you sure you want to delete this user?. This operation cannot be undone. All related projects will be erased!!')
                ])
            ?>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($user) ?>
            
            <!-- name -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-torso"></i></span>
                    <?= $this->Form->input('name', [
                        'label'       => '',
                        'placeholder' => 'Your name: John Smith',
                        'class'       => 'input-group-field',
                        'required'
                    ]) ?>
                </div>
            </div>
            
            <!-- contact -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-address-book"></i></span>
                    <?= $this->Form->input('contact', [
                        'label'            => '',
                        'placeholder'      => 'Contact: my.organization@example.com',
                        'class'            => 'input-group-field',
                        'aria-describedby' => 'contactHelpText',
                        'type'             => 'email',
                        'required'
                    ]) ?>
                </div>
                <p class="help-text" id="contactHelpText">Contact email. Public for everyone to see.</p>
            </div>

            <!-- password -->
           <!--  <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-lock"></i></span>
                    <?= $this->Form->input('password', [
                        'label'            => '',
                        'placeholder'      => 'password',
                        'aria-describedby' => 'passwordHelpText',
                        'class'            => 'input-group-field',
                        'id'               => 'password',
                        'required'
                    ]) ?>
                </div>
            </div>
 -->
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
                        'options'     => $genres
                    ]) ?>
                </div>
            </div>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>