<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h($user->name) ?></h3>
        <?php if (isset($client_type) && $client_type == 'authorized'): ?>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id]) ?>"><i class='fi-page-edit size-36'></i><?= __d('users', 'EDIT') ?></a>
            <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . ' ' . __d('users', 'DELETE'), ['controller' => 'Users', 'action' => 'delete', $user->id], [
                    'escape' => false, 
                    'confirm' => __d('users', 'Are you sure you want to delete this user?. This operation cannot be undone. All related projects will be erased!!')
                ])
            ?>
        <?php endif; ?>
    </div>
</div>


<div class="row">
    <div class="small-12 column">

        <ul class="tabs" data-tabs id="users-view-tabs">
            <li class="tabs-title is-active"><a href="#panel-general" aria-selected="true"><?= __d('users', 'General') ?></a></li>

            <?php if (isset($client_type) && $client_type != 'visita'): ?>
            <li class="tabs-title"><a href="#panel-profiles"><?= __d('users', 'Profiles') ?></a></li>
            <li class="tabs-title"><a href="#panel-projects"><?= __d('users', 'Projects') ?></a></li>
            <?php endif; ?>
        </ul>

        <div class="tabs-content" data-tabs-content="users-view-tabs">

            <div class="tabs-panel is-active" id="panel-general">
                <h4 class="view-subtitle"><?= __d('users', 'General Profile') . ':' ?></h4>
                <table class="hover stack vertical-table">
                    <?php if (isset($client_type) && $client_type == 'authorized'): ?>
                    <tr>
                        <th><?= __d('users', 'Email (private)') ?></th>
                        <td><?= h($user->email) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th><?= __d('users', 'Contact Email') ?></th>
                        <td><?= h($user->contact) ?></td>
                    </tr>
                    <?php if (isset($client_type) && $client_type == 'authorized'): ?>
                    <tr>
                        <th><?= __d('users', 'Genre') ?></th>
                        <td>
                            <?php if ($lang_current == "en"): ?>
                                <?= h($user->genre->name) ?>
                            <?php else: ?>
                                <?= h($user->genre->name_es) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>

            <?php if (isset($client_type) && $client_type != 'visita'): ?>
            <div class="tabs-panel" id="panel-profiles">
                <h4 class="view-subtitle-related"><?= __d('users', 'Registered App Profiles: ') ?></h4>
                <?php if (isset($client_type) && $client_type == 'authorized'): ?>
                    <a href="<?= $this->Url->build(['controller' => 'InstancesUsers', 'action' => 'add', $user->id]) ?>"><i class='fi-plus size-24'></i> <?= __d('users', 'Add Profile') ?></a>
                <?php endif; ?>
                <ul class="accordion" data-accordion data-allow-all-closed="true">
                <?php foreach ($user->instances as $instance): ?>
                    <?php if (!$this->App->isAdminInstance($instance->id)): ?>

                    <!-- authorized and registered users can view this data  -->
                    <?php if (
                        $client_type == 'authorized' || 
                        $this->App->isUserRegisteredInInstance($client_id, $instance->id)
                    ): ?>
                    <li class="accordion-item" data-accordion-item>
                        <a href="#" class="accordion-title">
                            <?php if ($lang_current == "en"): ?>
                                <?= $instance->name ?>
                            <?php else: ?>
                                <?= $instance->name_es ?>
                            <?php endif; ?>
                        </a>
                        <div class="accordion-content" data-tab-content>
                            
                            <!-- admin and user can modify this item -->
                            <?php if ($client_type == 'authorized' || 
                                $this->App->isAdmin($client_id, $instance->id)
                            ): ?>
                                <div class="profile-links">
                                <a href="<?= $this->Url->build(['controller' => 'InstancesUsers', 'action' => 'edit', $user->id, $instance->namespace]) ?>"><i class='fi-page-edit size-24'></i><?= ' ' . __d('users', 'Edit this profile') ?></a>
                                <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-24')) . ' ' . __d('users', "Delete this profile"), 
                                    [
                                        'controller' => 'InstancesUsers',
                                        'action' => 'delete',
                                        $user->id,
                                        $instance->id
                                    ], [
                                        'escape' => false, 
                                        'confirm' => __d('users', 'Are you sure you want to delete this profile?. This operation cannot be undone. All related projects will be erased!!')
                                    ])
                                ?>
                                </div>
                            <?php endif; ?>
                        
                            <table class="hover stack vertical-table">
                                <tr>
                                    <th><?= __d('users', 'Contact Email') ?></th>
                                    <td><?= h($instance->_joinData->contact) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __d('users', 'Main Organization') ?></th>
                                    <?php if ($instance->_joinData->main_organization != "[null]"): ?>
                                        <td><?= h($instance->_joinData->main_organization) ?></td>
                                    <?php else: ?>
                                        <td><span class="unset-field"><?= __d('users', 'Please, complete this profile.') ?></span></td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <th><?= __d('users', 'Organization Type') ?></th>
                                    <?php if ($instance->_joinData->organization_type->name != "[null]"): ?>
                                        <td>
                                            <?php if ($lang_current == "en"): ?>
                                                <?= h($instance->_joinData->organization_type->name) ?>
                                            <?php else: ?>
                                                <?= h($instance->_joinData->organization_type->name_es) ?>
                                            <?php endif; ?>
                                        </td>

                                    <?php else: ?>
                                        <td><span class="unset-field"><?= __d('users', 'Please, complete this profile.') ?></span></td>
                                    <?php endif; ?>
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
    
                <h4 class="view-subtitle-related"><?= __d('users', 'Related Projects: ') ?></h4>
                <ul class="accordion" data-accordion data-allow-all-closed="true">
                <?php foreach ($user->instances as $instance): ?>
                    <?php if (!$this->App->isAdminInstance($instance->id)): ?>

                    <!-- authorized and registered users can view this data  -->
                    <?php if (
                        $client_type == 'authorized' || 
                        $this->App->isUserRegisteredInInstance($client_id, $instance->id)
                    ): ?>
                    <li class="accordion-item" data-accordion-item>
                        <a href="#" class="accordion-title">
                            <?php if ($lang_current == "en"): ?>
                                <?= $instance->name ?>
                            <?php else: ?>
                                <?= $instance->name_es ?>
                            <?php endif; ?>
                        </a>
                        <div class="accordion-content" data-tab-content>

                            <?php if (!empty($user->projects)): ?>                            
                            <table class="hover stack" cellpadding="0" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><?= __('Name') ?></th>
                                        <th><?= __('Organization') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($user->projects as $project): ?>
                                        <?php if ($project->instance_id == $instance->id): ?>
                                        <tr>
                                            <td>
                                                <?= $this->Html->link("<i class='fi-magnifying-glass'></i>", ['controller' => 'Projects', 'action' => 'view', $instance->namespace, $project->id], ['escape' => false]) ?>
                                                <?= h($project->name) ?>
                                            </td>
                                            <td><?= h($project->organization) ?></td>
                                        </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <?php if ($lang_current == "en"): ?>
                                    <p><?= __d('users', 'There aren\'t registered projects for this app ({0}), related to this user.', h($instance->name)) ?></p>
                                <?php else: ?>
                                    <p><?= __d('users', 'There aren\'t registered projects for this app ({0}), related to this user.', h($instance->name_es)) ?></p>
                                <?php endif; ?>
                                
                            <?php endif; ?>

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


<style type="text/css">
.view-title a {
    margin-left: 20px;
}

.profile-links a {
    margin-left: 20px;
}
</style>