
<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($project->name) ?> <?= __d('projects', '(Editing)') ?></h3>
        <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance->namespace]) ?>"><i class='fi-map size-36'></i><?= __d('projects', 'Back to Map') ?></a>
        <a href="<?= $this->Url->build(['action' => 'view', $instance->namespace, $project->id]) ?>"><i class='fi-magnifying-glass size-36'></i><?= __d('projects', 'View') ?></a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . __d("projects", 'DELETE'), ['action' => 'delete', $instance->namespace, $project->id], [
                'escape' => false, 
                'confirm' => __d("projects", 'Are you sure you want to delete this project?. This operation cannot be undone. All related data will be erased!')
            ])
        ?>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>
            <ul class="tabs" data-tabs id="projects-view-tabs">
                <li class="tabs-title is-active"><a href="#panel-overview" aria-selected="true"><?= __d('projects', 'General') ?></a></li>
                <li class="tabs-title"><a href="#panel-info"><?= __d('projects', 'Extra info') ?></a></li>
                <li class="tabs-title"><a href="#panel-categories"><?= __d('projects', 'Related Categories') ?></a></li>
            </ul>

            <div class="tabs-content" data-tabs-content="projects-view-tabs">

                <div class="tabs-panel is-active" id="panel-overview">
                    
                    <h4 class="view-subtitle"><?= __d('projects', 'Overview') ?></h4>
                    <fieldset>
                        <?= $this->Form->input('name', [
                                'label' => $this->Loc->fieldProjectName(),
                                'value'       => $project->name,
                                // 'placeholder' => 'e.g: '
                            ]) ?>

                        <?= $this->Form->input('description', [
                                'label' => $this->Loc->fieldProjectDescription(),
                                'type' => 'textarea',
                                'value'       => $project->description,
                                // 'placeholder' => 'required'
                            ]) ?>

                        <?= $this->Form->input('url', [
                                'label' => $this->Loc->fieldProjectURL(),
                                'value'       => $project->url,
                            ]) ?>

                        <?= $this->Form->input('organization', [
                                'label' => 'Organization Name',
                                // 'placeholder' => 'required',
                                'value'       => $project->organization,
                            ]) ?>

                        <?= $this->Form->input('organization_type_id', [
                                'label' => $this->Loc->fieldProjectOrganizationType(),
                                'options' => $organizationTypes,
                                'empty' => '---',
                                'value'       => $project->organization_type_id,
                            ]) ?>
                    </fieldset>

                    <h4 class="view-subtitle"><?= __d('projects', 'Project Contribution') ?></h4>
                    <fieldset>
                        <?= $this->Form->input('contribution', [
                                'label' => __d('projects', 'Describe the contribution of this project'),
                                'type'  => 'textarea',
                                'value' => $project->contribution,
                            ]) ?>
                    </fieldset>

                    <h4 class="view-subtitle"><?= __d('projects', 'Contributing to this project') ?></h4>
                    <fieldset>
                        <?= $this->Form->input('contributing', [
                                'label' => __d('projects', 'Describe how others can contribute to this project.'),
                                'type'  => 'textarea',
                                'value' => $project->contributing,
                            ]) ?>
                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-info">
                    <h4 class="view-subtitle"><?= __d('projects', 'Other information') ?></h4>

                    <h5 class="view-subsubtitle"><?= __d('projects', 'Location:') ?></h5>
                    <fieldset>
                        <?= $this->Form->input('country_id', [
                                'label' => $this->Loc->fieldProjectCountry(),
                                'options' => $countries,
                                'empty' => '---',
                                'value' => $project->country_id,
                            ]) ?>
                    </fieldset>


                    <h5 class="view-subsubtitle"><?= __d('projects', 'Project Management') ?></h5>
                    <fieldset>
                        <?= $this->Form->input('project_stage_id', [
                                'label' => $this->Loc->fieldProjectStage(),
                                'options' => $projectStages,
                                'empty' => '---',
                                'value' => $project->project_stage_id,
                            ]) ?>

                        <div class="row">
                            <div class="small-12 medium-6 columns">
                                <?= $this->Form->input('start_date', [
                                    'label' => $this->Loc->fieldProjectStartDate(),
                                    'empty'            => true,
                                    'id'               => 'dp_start',
                                    'type'             => 'text',
                                    'value' => $project->start_date,
                                ]) ?>
                            </div>
                            <div class="small-12 medium-6 columns">
                                <?= $this->Form->input('finish_date', [
                                    'label' => $this->Loc->fieldProjectFinishDate(),
                                    'empty'            => true,
                                    'id'               => 'dp_finish',
                                    'type'             => 'text',
                                    'value' => $project->finish_date,
                                ]) ?>
                            </div>
                        </div>

                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-categories">
                    <h4 class="view-subtitle-related"><?= __d('projects', 'Related Categories') ?></h4>
                    <fieldset>
                        <p><?= __d('projects', 'Hold <kbd>Ctrl</kbd> or <kbd>Cmd</kbd> to select more than one project category') ?></p>
                        <?= $this->Form->input('categories._ids', [
                                'label' => '',
                                'options' => $categories,
                                'value' => $project->categories,
                            ]) ?>
                    </fieldset>
            </div>
            <!-- submit, cancel -->
            <div class="row">
                <div class="small-12 columns">
                    <?= $this->Form->button($this->Loc->formSubmit(), ['class' => 'warning button']) ?>
                </div>
                <div class="small-12 columns">
                    <a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'view', $instance->namespace, $project->id]) ?>" class="alert hollow button">
                        <?= $this->Loc->formCancel() ?>
                    </a>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Html->css('foundation-datepicker.min.css') ?>
<?= $this->Html->script('foundation-datepicker.min.js') ?>

<script type="text/javascript">
    window.prettyPrint && prettyPrint();
    $('#dp_start').fdatepicker({
        format: 'dd/mm/yy',
        disableDblClickSelection: true,
        startDate: '1989-01-01',
        endDate:   '2050-01-01',
    });
    $('#dp_finish').fdatepicker({
        format: 'dd/mm/yy',
        disableDblClickSelection: true,
        startDate: '1989-01-01',
        endDate:   '2050-01-01',
    });
</script>

<style type="text/css">
.datepicker table tr th {
    color: black;
}
.fa-remove {
    width: 30px;
}

a.button.alert {
    font-size: 18px;
    float: right;
}
</style>
