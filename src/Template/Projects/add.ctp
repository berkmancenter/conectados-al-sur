
<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= __d('projects', 'New Project') ?></h3>
        <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance->namespace]) ?>"><i class='fi-map size-36'></i></a>
        <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'dots', $instance->namespace]) ?>"><i class='fi-graph-pie size-36'></i></a>
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
                                // 'placeholder' => 'e.g: '
                            ]) ?>

                        <?= $this->Form->input('description', [
                                'label' => $this->Loc->fieldProjectDescription(),
                                'type' => 'textarea'
                                // 'placeholder' => 'required'
                            ]) ?>

                        <?= $this->Form->input('url', [
                                'label' => $this->Loc->fieldProjectURL(),
                            ]) ?>

                        <?= $this->Form->input('organization', [
                                'label' => 'Organization Name',
                                // 'placeholder' => 'required',
                            ]) ?>

                        <?= $this->Form->input('organization_type_id', [
                                'label' => $this->Loc->fieldProjectOrganizationType(),
                                'options' => $organizationTypes,
                                'empty' => '---',
                            ]) ?>
                    </fieldset>

                    <h4 class="view-subtitle"><?= __d('projects', 'Project Contribution') ?></h4>
                    <fieldset>
                        <?= $this->Form->input('contribution', [
                                'label' => __d('projects', 'Describe the contribution of this project'),
                                'type'  => 'textarea'
                            ]) ?>
                    </fieldset>

                    <h4 class="view-subtitle"><?= __d('projects', 'Contributing to this project') ?></h4>
                    <fieldset>
                        <?= $this->Form->input('contributing', [
                                'label' => __d('projects', 'Describe how others can contribute to this project.'),
                                'type'  => 'textarea'
                            ]) ?>
                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-info">
                    <h4 class="view-subtitle"><?= __d('projects', 'Other information') ?></h4>

                    <h5 class="view-subsubtitle"><?= __d('projects', 'Location:') ?></h5>
                    <fieldset>
                        <p><?= __d('projects', 'Please, select the main country of work. You can use the description to mention other related countries.') ?></p>
                        <?= $this->Form->input('country_id', [
                                'label' => $this->Loc->fieldProjectCountry(),
                                'options' => $countries,
                                'empty' => '---',
                            ]) ?>
                    </fieldset>


                    <h5 class="view-subsubtitle"><?= __d('projects', 'Project Management') ?></h5>
                    <fieldset>
                        <?= $this->Form->input('project_stage_id', [
                                'label' => $this->Loc->fieldProjectStage(),
                                'options' => $projectStages,
                                'empty' => '---',
                            ]) ?>

                        <div class="row">
                            <div class="small-12 medium-6 columns">
                                <?= $this->Form->input('start_date', [
                                    'label' => $this->Loc->fieldProjectStartDate(),
                                    'empty'            => true,
                                    'id'               => 'dp_start',
                                    'type'             => 'text'
                                ]) ?>
                            </div>
                            <div class="small-12 medium-6 columns">
                                <?= $this->Form->input('finish_date', [
                                    'label' => $this->Loc->fieldProjectFinishDate(),
                                    'empty'            => true,
                                    'id'               => 'dp_finish',
                                    'type'             => 'text'
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
                            ]) ?>
                    </fieldset>
            </div>
            <!-- submit, cancel -->
            <div class="row">
                <div class="small-12 columns">
                    <?= $this->Form->button($this->Loc->formSubmit(), ['class' => 'warning button']) ?>
                </div>
                <div class="small-12 columns">
                    <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?>" class="alert hollow button">
                        <?= $this->Loc->formCancel() ?>
                    </a>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
<?= $this->Html->css('foundation-datepicker.min.css') ?>
<?= $this->Html->script('foundation-datepicker.min.js') ?>

<script type="text/javascript">
    window.prettyPrint && prettyPrint();
    $('#dp_start').fdatepicker({
        format: 'yy/mm/dd',
        disableDblClickSelection: true,
        startDate: '1989-01-01',
        endDate:   '2050-01-01',
    });
    $('#dp_finish').fdatepicker({
        format: 'yy/mm/dd',
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