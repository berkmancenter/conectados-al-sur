<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 columns">
        <div class="form">
            <h4 class="view-subtitle"><?= __d('crud', 'Edit Organization Type:') ?></h4>
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>
            
            <?= $this->Form->input('name', [
                    'label'       => $this->Loc->fieldOrganizationTypeNameEn(),
                    'placeholder' => 'e.g.: United Nations',
                    'type'        => 'text',
                    'value'       => $organization_type->name,
                ]) ?>
                
            <?= $this->Form->input('name_es', [
                    'label'       => $this->Loc->fieldOrganizationTypeNameEs(),
                    'placeholder' => 'ej.: Naciones Unidas',
                    'type'        => 'text',
                    'value'       => $organization_type->name_es,
                ]) ?>

            <!-- submit, cancel -->
            <div class="row">
                <div class="small-12 columns">
                    <?= $this->Form->button($this->Loc->formSubmit(), ['class' => 'warning button']) ?>
                </div>
                <div class="small-12 columns">
                    <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance->namespace]) ?>" class="alert hollow button">
                        <?= $this->Loc->formCancel() ?>
                    </a>
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