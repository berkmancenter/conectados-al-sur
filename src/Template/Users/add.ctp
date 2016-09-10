<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
<div class="row">
    <div class="small-12 column view-title">
        <h3><?= __('New User') ?></h3>
        <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?>><i class='fi-arrow-left size-36'></i> CANCEL</a>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <?php
                    echo $this->Form->input('name', ['label' => 'Your Name', 'placeholder' => 'e.g. John Smith']);
                    echo $this->Form->input('email', ['label' => 'Your Email: Will be used as your username and it will be treated as private.', 'placeholder' => 'e.g. john.smith@gmail.com']);
                    echo $this->Form->input('contact', ['label' => 'Contact email. Public for everyone to see.', 'placeholder' => 'e.g. organization.contact@gmail.com']);
                    echo $this->Form->input('password', ['label' => 'Your password. At least 6 characters']);
                    echo $this->Form->input('genre_id', ['options' => $genres]);
                    echo $this->Form->input('main_organization', ['label' => 'Main organization you work in.', 'placeholder' => 'e.g. United Nations']);
                    echo $this->Form->input('organization_type_id', ['label' => 'Type of this organization', 'options' => $organizationTypes]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
