<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?></h3>
        <?php if (isset($client_type) && $client_type == 'authorized'): ?>
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
            <li class="tabs-title is-active"><a href="#panel-general" aria-selected="true">General</a></li>

            <?php if (isset($client_type) && $client_type != 'visita'): ?>
            <li class="tabs-title"><a href="#panel-profiles">Profiles</a></li>
            <li class="tabs-title"><a href="#panel-projects">Projects</a></li>
            <?php endif; ?>
        </ul>

        <div class="tabs-content" data-tabs-content="users-view-tabs">

            <div class="tabs-panel is-active" id="panel-general">
                <h4 class="view-subtitle"><?= __('General Profile:') ?></h4>
                <table class="hover stack vertical-table">
                    <?php if (isset($client_type) && $client_type == 'authorized'): ?>
                    <tr>
                        <th><?= __('Email (private)') ?></th>
                        <td><?= h($user->email) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th><?= __('Contact Email') ?></th>
                        <td><?= h($user->contact) ?></td>
                    </tr>
                    <?php if (isset($client_type) && $client_type == 'authorized'): ?>
                    <tr>
                        <th><?= __('Genre') ?></th>
                        <td><?= $user->has('genre') ? h($user->genre->name) : '' ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <?php if (isset($client_type) && $client_type != 'visita'): ?>
            <div class="tabs-panel" id="panel-profiles">
                <h4 class="view-subtitle-related"><?= __('Registered App Profiles: ') ?></h4>
                <ul class="accordion" data-accordion data-allow-all-closed="true">
                <?php foreach ($user->instances as $instance): ?>
                    <?php if (!$this->App->isAdminInstance($instance->id)): ?>

                    <!-- authorized and registered users can view this data  -->
                    <?php if (
                        $client_type == 'authorized' || 
                        $this->App->isUserRegisteredInInstance($client_id, $instance->id)
                    ): ?>
                    <li class="accordion-item" data-accordion-item>
                        <a href="#" class="accordion-title"><?= $instance->name ?></a>
                        <div class="accordion-content" data-tab-content>
                            
                            <!-- admin and user can modify this item -->
                            <?php if ($client_type == 'authorized' || 
                                $this->App->isAdmin($client_id, $instance->id)
                            ): ?>
                                <!-- nothing to do here -->
                            <?php endif; ?>
                        
                            <table class="hover stack vertical-table">
                                <tr>
                                    <th><?= __('Contact Email') ?></th>
                                    <td><?= h($instance->_joinData->contact) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Main Organization') ?></th>
                                    <td><?= h($instance->_joinData->main_organization) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Organization Type') ?></th>
                                    <td><?= h($instance->_joinData->organization_type->name) ?></td>
                                </tr>
                            </table>
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </div>

            <div class="tabs-panel" id="panel-projects">
    
                <h4 class="view-subtitle-related"><?= __('Related Projects: ') ?></h4>
                <ul class="accordion" data-accordion data-allow-all-closed="true">
                <?php foreach ($user->instances as $instance): ?>
                    <?php if (!$this->App->isAdminInstance($instance->id)): ?>

                    <!-- authorized and registered users can view this data  -->
                    <?php if (
                        $client_type == 'authorized' || 
                        $this->App->isUserRegisteredInInstance($client_id, $instance->id)
                    ): ?>
                    <li class="accordion-item" data-accordion-item>
                        <a href="#" class="accordion-title"><?= $instance->name ?></a>
                        <div class="accordion-content" data-tab-content>
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
                        </div>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </div>         
            <?php endif; ?>
        </div>
    </div>
</div>
</div>
