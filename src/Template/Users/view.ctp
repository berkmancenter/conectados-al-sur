<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
        <!-- <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Genres'), ['controller' => 'Genres', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Genre'), ['controller' => 'Genres', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li> -->
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?></h3>
        <!-- <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'map', $instance_namespace]) ?>><i class='fi-map size-36'></i>Back to Map</a>
        <a href=<?= $this->Url->build(['action' => 'edit', $instance_namespace, $project->id]) ?>><i class='fi-page-edit size-36'></i>Edit</a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance_namespace, $project->id], [
                'escape' => false, 
                'confirm' => __('Are you sure you want to delete this project?. This operation cannot be undone. All related data will be erased!')
            ])
        ?> -->
    </div>
</div>


<div class="row">
    <div class="small-12 column">

        <ul class="tabs" data-tabs id="users-view-tabs">
            <li class="tabs-title is-active"><a href="#panel-profile" aria-selected="true">General</a></li>
            <li class="tabs-title"><a href="#panel-projects">Related Projects</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="users-view-tabs">

            <div class="tabs-panel is-active" id="panel-profile">

                <h4 class="view-subtitle"><?= __('Profile:') ?></h4>
   
                <table class="vertical-table">
                    <!-- <tr>
                        <th><?= __('Email (secret!)') ?></th>
                        <td><?= h($user->email) ?></td>
                    </tr> -->
                    <tr>
                        <th><?= __('Contact Email') ?></th>
                        <td><?= h($user->contact) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Genre') ?></th>
                        <td><?= $user->has('genre') ? h($user->genre->name) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Main Organization') ?></th>
                        <td><?= h($user->main_organization) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Organization Type') ?></th>
                        <td><?= $user->has('organization_type') ? h($user->organization_type->name) : '' ?></td>
                    </tr>
                </table>
            </div>

            <div class="tabs-panel" id="panel-projects">

                <h4 class="view-subtitle-related"><?= __('Related Projects: ' . count($user->projects)) ?></h4>

                    <?php if (!empty($user->projects)): ?>
                    <table class="hover stack" cellpadding="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?= __('Name') ?></th>
                                <th><?= __('Organization') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user->projects as $projects): ?>
                            <tr>
                                <td><?= h($projects->name) ?></td>
                                <td><?= h($projects->organization) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $instance_namespace, $projects->id]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>

            </div>


        </div>
    </div>
</div>
