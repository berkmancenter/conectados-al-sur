<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?></h3>
        <?php if (isset($is_authorized) && $is_authorized == true): ?>
            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id]) ?>><i class='fi-page-edit size-36'></i>EDIT</a>
            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['controller' => 'Users', 'action' => 'delete', $user->id], [
                    'escape' => false, 
                    'confirm' => __('Are you sure you want to delete this user?. This operation cannot be undone. All related projects will be erased!!')
                ])
            ?>
        <?php endif; ?>
    </div>
</div>


<div class="row">
    <div class="small-12 column">

        <ul class="tabs" data-tabs id="users-view-tabs">
            <li class="tabs-title is-active"><a href="#panel-profile" aria-selected="true">General</a></li>

            <?php if (
                (isset($view_instance_version) && $view_instance_version == true) ||
                (isset($is_authorized) && $is_authorized == true)
            ): ?>
            <li class="tabs-title"><a href="#panel-projects">Related Projects</a></li>
            <?php endif; ?>
        </ul>

        <div class="tabs-content" data-tabs-content="users-view-tabs">

            <div class="tabs-panel is-active" id="panel-profile">


                <?php if (isset($view_instance_version) && $view_instance_version == true): ?>
                    <h4 class="view-subtitle"><?= __('Profile for "' . $instance->name . '" app') ?></h4>
                    <!-- <p>CAS VERSION</p> -->
                <?php else: ?>
                    <h4 class="view-subtitle"><?= __('Profile:') ?></h4>
                    <!-- <p>dvine</p> -->
                <?php endif; ?>
   
                <table class="vertical-table">
                    <?php if (isset($is_authorized) && $is_authorized == true): ?>
                    <tr>
                        <th><?= __('Email (private)') ?></th>
                        <td><?= h($user->email) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if (isset($user->contact)): ?>
                    <tr>
                        <th><?= __('Contact Email') ?></th>
                        <td><?= h($user->contact) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th><?= __('Genre') ?></th>
                        <td><?= $user->has('genre') ? h($user->genre->name) : '' ?></td>
                    </tr>
                    <?php if (isset($user->main_organization)): ?>
                    <tr>
                        <th><?= __('Main Organization') ?></th>
                        <td><?= h($user->main_organization) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <?php if (
                (isset($view_instance_version) && $view_instance_version == true) ||
                (isset($is_authorized) && $is_authorized == true)
            ): ?>
            <div class="tabs-panel" id="panel-projects">

                <?php if (isset($is_authorized) && $is_authorized == false): ?>

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
                <?php else: ?>
                    
                    <h4 class="view-subtitle-related"><?= __('Related Projects: ') ?></h4>

                    <ul class="accordion" data-accordion data-allow-all-closed="true">
                    <?php foreach ($user->instances as $instance): ?>

                        <?php if (!$this->App->isAdminInstance($instance->id)): ?>

                        <li class="accordion-item" data-accordion-item>
                            <a href="#" class="accordion-title"><?= $instance->name ?></a>
                            <div class="accordion-content" data-tab-content>
                                
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
                                        <?php foreach ($user->projects as $project): ?>
                                            <?php if ($project->instance_id == $instance->id): ?>
                                            <tr>
                                                <td><?= h($project->name) ?></td>
                                                <td><?= h($project->organization) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $instance->namespace, $project->id]) ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <?php endif; ?>
                            </div>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </ul>

                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
