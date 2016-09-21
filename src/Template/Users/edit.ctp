<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?> (EDITING)</h3>        
        <?php if (isset($is_authorized) && $is_authorized == true): ?>
            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $instance_namespace, $user->id]) ?>><i class='fi-page-edit size-36'></i>EDIT</a>
            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['controller' => 'Users', 'action' => 'delete', $instance_namespace, $user->id], [
                    'escape' => false, 
                    'confirm' => __('Are you sure you want to delete this user?. This operation cannot be undone. All related projects will be erased!!')
                ])
            ?>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($user) ?>
            <ul class="tabs" data-tabs id="users-edit-tabs">
                <li class="tabs-title is-active"><a href="#panel-profile" aria-selected="true">General</a></li>
                <li class="tabs-title"><a href="#panel-admin">Admin information</a></li>
            </ul>
            
            <div class="tabs-content" data-tabs-content="users-edit-tabs">
                <div class="tabs-panel is-active" id="panel-profile">
                    <fieldset>
                        <?php
                            echo $this->Form->input('name');
                            echo $this->Form->input('email');
                            echo $this->Form->input('password');
                            echo $this->Form->input('genre_id', ['options' => $genres]);
                        ?>
                    </fieldset>
                </div>
                <div class="tabs-panel" id="panel-admin">
                    <fieldset>
                        <?php
                            echo $this->Form->input('contact');
                            echo $this->Form->input('main_organization');
                        ?>
                    </fieldset>
                </div>
            </div>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>