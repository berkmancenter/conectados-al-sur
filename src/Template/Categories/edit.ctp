<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <h4 class="view-subtitle"><?= __('Edit Category:') ?></h4>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>
            
            <?= $this->Form->input('name', [
                    'label' => 'Category Name', 
                    'placeholder' => 'e.g: Education',
                    'type'        => 'text',
                    'value'       => $category->name,
                    'required'
                ]) ?>

            <?= $this->Form->input('name_es', [
                    'label' => 'Category Name (Spanish)',
                    'placeholder' => 'e.g: Educación',
                    'type'        => 'text',
                    'value'       => $category->name_es,
                    'required'
                ]) ?>
            
            <!-- submit, cancel -->
            <div class="row">
                <div class="small-12 columns">
                    <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
                </div>
                <div class="small-12 columns">
                    <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance->namespace]) ?> class="alert hollow button">CANCEL</a>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>

<style type="text/css">
a.button.alert {
    font-size: 18px;
    float: right;
}
</style>