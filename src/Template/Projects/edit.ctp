<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>


<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($project->name) ?> (Editing)</h3>
        <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance->namespace]) ?>"><i class='fi-map size-36'></i>Back to Map</a>
        <a href="<?= $this->Url->build(['action' => 'view', $instance->namespace, $project->id]) ?>"><i class='fi-magnifying-glass size-36'></i>View</a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance->namespace, $project->id], [
                'escape' => false, 
                'confirm' => __('Are you sure you want to delete this project?. This operation cannot be undone. All related data will be erased!')
            ])
        ?>
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($project) ?>
            <ul class="tabs" data-tabs id="projects-view-tabs">
                <li class="tabs-title is-active"><a href="#panel-overview" aria-selected="true">General</a></li>
                <li class="tabs-title"><a href="#panel-info">Extra info</a></li>
                <li class="tabs-title"><a href="#panel-categories">Related Categories</a></li>
            </ul>

            <div class="tabs-content" data-tabs-content="projects-view-tabs">

                <div class="tabs-panel is-active" id="panel-overview">
                    <h4 class="view-subtitle"><?= __('Overview:') ?></h4>
                    <fieldset>
                        <?php
                            echo $this->Form->input('name', ['label' => 'Project Name', 'placeholder' => 'required']);
                            echo $this->Form->input('description', ['label' => 'Description', 'placeholder' => 'required']);
                            echo $this->Form->input('url', ['label' => 'External URL']);
                            echo $this->Form->input('organization', ['label' => 'Organization Name', 'placeholder' => 'required']);
                            echo $this->Form->input('organization_type_id', ['options' => $organizationTypes]);
                        ?>
                    </fieldset>

                    <h4 class="view-subtitle"><?= __('Project Contribution:') ?></h4>
                    <fieldset>
                        <?php
                            echo $this->Form->input('contribution', ['label' => 'Describe the contribution of this project']);
                        ?>
                    </fieldset>

                    <h4 class="view-subtitle"><?= __('Contributing to this project:') ?></h4>
                    <fieldset>
                        <?php
                            echo $this->Form->input('contributing', ['label' => 'Describe how others can contribute to this project.']);
                        ?>
                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-info">

                    <h4 class="view-subtitle"><?= __('Other information:') ?></h4>

                    <h5 class="view-subsubtitle"><?= __('Location:') ?></h5>
                    <fieldset>
                        <?php
                            echo $this->Form->input('country_id', ['options' => $countries]);
                            // echo $this->Form->input('city_id', ['options' => $cities, 'empty' => true]);
                            // echo $this->Form->input('latitude');
                            // echo $this->Form->input('longitude');                            
                        ?>
                    </fieldset>


                    <h5 class="view-subsubtitle"><?= __('Project Management:') ?></h5>
                    <fieldset>
                        <?php
                            echo $this->Form->input('project_stage_id', ['options' => $projectStages]);
                        ?>
                        <div class="row">
                            <div class="small-12 medium-6 columns">
                                <?= $this->Form->input('start_date', [
                                    'empty'            => true,
                                    'id'               => 'dp_start',
                                    'type'             => 'text'
                                ]) ?>
                            </div>
                            <div class="small-12 medium-6 columns">
                                <?= $this->Form->input('finish_date', [
                                    'empty'            => true,
                                    'id'               => 'dp_finish',
                                    'type'             => 'text'
                                ]) ?>
                            </div>
                        </div>

                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-categories">

                    <h4 class="view-subtitle-related"><?= __('Related Categories: ') ?></h4>
                    <fieldset>
                        <p>Project Categories (Hold <kbd>Ctrl</kbd> to select more than one)</p>
                        <?php
                            echo $this->Form->input('categories._ids', ['label' => '', 'options' => $categories]);
                        ?>
                    </fieldset>
                </div>
            </div>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/foundation-datepicker/1.5.0/css/foundation-datepicker.min.css') ?>
<?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/foundation-datepicker/1.5.0/js/foundation-datepicker.min.js') ?>

<script type="text/javascript">
    window.prettyPrint && prettyPrint();
    $('#dp_start').fdatepicker({
      format: 'mm/dd/yy',
      disableDblClickSelection: true
    });
    $('#dp_finish').fdatepicker({
      format: 'mm/dd/yy',
      disableDblClickSelection: true
    });
</script>

<style type="text/css">
.datepicker table tr th {
    color: black;
}
.fa-remove {
    width: 30px;
}
</style>
