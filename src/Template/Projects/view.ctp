<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($project->name) ?></h3>
        <a href="<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance->namespace]) ?>"><i class='fi-map size-36'></i>Back to Map</a>
        <a href="<?= $this->Url->build(['action' => 'edit', $instance->namespace, $project->id]) ?>"><i class='fi-page-edit size-36'></i>Edit</a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance->namespace, $project->id], [
                'escape' => false, 
                'confirm' => __('Are you sure you want to delete this project?. This operation cannot be undone. All related data will be erased!')
            ])
        ?>
        <a href="<?= $this->Url->build(['action' => 'exportCsv', $instance->namespace]) . "?" . $download_query ?>"><i class='fi-arrow-down size-36'></i>Download</a>
    </div>
</div>


<div class="row">
    <div class="small-12 column">

        <ul class="tabs" data-tabs id="projects-view-tabs">
            <li class="tabs-title is-active"><a href="#panel-overview" aria-selected="true">General</a></li>
            <li class="tabs-title"><a href="#panel-info">Extra info</a></li>
            <li class="tabs-title"><a href="#panel-categories">Related Categories</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="projects-view-tabs">

            <div class="tabs-panel is-active" id="panel-overview">

                <h4 class="view-subtitle"><?= __('Overview:') ?></h4>
                <?= $this->Text->autoParagraph(h($project->description)); ?>

                <table class="hover stack vertical-table">
                    <tr>
                        <th><?= __('User') ?></th>
                        <td><?= $project->has('user') ? $this->Html->link($project->user->name, ['controller' => 'Users', 'action' => 'view', $instance->namespace, $project->user->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('External URL') ?></th>
                        <td><?= $this->Html->link($project->url) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Organization') ?></th>
                        <td><?= h($project->organization) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Organization Type') ?></th>
                        <td><?= $project->has('organization_type') ? h($project->organization_type->name) : '' ?></td>
                    </tr>
                </table>

                <h4 class="view-subtitle"><?= __('Project Contribution:') ?></h4>
                <?= $this->Text->autoParagraph(h($project->contribution)); ?>

                <h4 class="view-subtitle"><?= __('Contributing to this project:') ?></h4>
                <?= $this->Text->autoParagraph(h($project->contributing)); ?>
            </div>

            <div class="tabs-panel" id="panel-info">

                <h4 class="view-subtitle"><?= __('Other information:') ?></h4>

                <h5 class="view-subsubtitle"><?= __('Location:') ?></h5>
                <table class="hover stack vertical-table">
                    <tr>
                        <th><?= __('Country') ?></th>
                        <td><?= $project->has('country') ? h($project->country->name) : '' ?></td>
                    </tr>
                    <!-- <tr>
                        <th><?= __('City') ?></th>
                        <td><?= $project->has('city') ? h($project->city->name) : '' ?></td>
                    </tr> -->
                    <!-- <tr>
                        <th><?= __('Latitude') ?></th>
                        <td><?= $this->Number->format($project->latitude) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Longitude') ?></th>
                        <td><?= $this->Number->format($project->longitude) ?></td>
                    </tr> -->
                </table>

                <h5 class="view-subsubtitle"><?= __('Project Management:') ?></h5>
                <table class="hover stack vertical-table">
                    <tr>
                        <th><?= __('Project Stage') ?></th>
                        <td><?= $project->has('project_stage') ? h($project->project_stage->name) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Start Date') ?></th>
                        <td><?= h($project->start_date) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Finish Date') ?></th>
                        <td><?= h($project->finish_date) ?></td>
                    </tr>
                </table>

                <h5 class="view-subsubtitle"><?= __('Platform Registry:') ?></h5>
                <table class="hover stack vertical-table">
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($project->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Last Modified') ?></th>
                        <td><?= h($project->modified) ?></td>
                    </tr>
                </table>

            </div>

            <div class="tabs-panel" id="panel-categories">
        
                <h4 class="view-subtitle-related"><?= __('Related Categories: ' . count($project->categories)) ?></h4>
                <?php if (!empty($project->categories)): ?>
                <table class="hover" cellpadding="0" cellspacing="0">
                    <tbody>
                        <?php foreach ($project->categories as $categories): ?>
                        <tr>
                            <td><?= h($categories->name) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>This instance does not have any related category.</p>
                <?php endif; ?>
                </div>
            </div>
    </div>
</div>
