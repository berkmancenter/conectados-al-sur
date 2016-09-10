<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<!--
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Related Projects'), ['controller' => 'Projects', 'action' => 'index', $instance->namespace]) ?> </li>
        <li><?= $this->Html->link(__('Related Users'), ['controller' => 'Users', 'action' => 'index', $instance->namespace]) ?> </li>
    </ul>
</nav> -->

<div class="row">
    <div class="small-12 medium-9 column view-title">
        <h3><?= h($instance->name) ?></h3>
        <a href=<?= $this->Url->build(['action' => 'index']) ?>><i class='fi-arrow-left size-36'></i></a>
        <a href=<?= $this->Url->build(['action' => 'preview', $instance->namespace]) ?>><i class='fi-home size-36'></i></a>
        <a href=<?= $this->Url->build(['action' => 'map', $instance->namespace]) ?>><i class='fi-map size-36'></i></a>
        <a href=<?= $this->Url->build(['action' => 'dots', $instance->namespace]) ?>><i class='fi-web size-36'></i></a>
    </div>
    <div class="small-12 medium-3 column view-title">
        <a href=<?= $this->Url->build(['action' => 'edit', $instance->namespace]) ?>><i class='fi-page-edit size-36'></i>Edit</a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance->namespace], ['escape' => false], 
                ['confirm' => __('Are you sure you want to delete the "{0}" instance?. This operation cannot be undone. All related data will be erased!', $instance->name)]) ?>
    </div>
</div>


<div class="row">
    <div class="small-12 column">

        <ul class="tabs" data-tabs id="instance-view-tabs">
            <li class="tabs-title is-active"><a href="#panel-users" aria-selected="true">Users</a></li>
            <li class="tabs-title"><a href="#panel-properties">Properties</a></li>
            <li class="tabs-title"><a href="#panel-configuration">Configuration</a></li>
            <li class="tabs-title"><a href="#panel-categories">Categories</a></li>
            <li class="tabs-title"><a href="#panel-organization_types">Organization Types</a></li>
        </ul>

        <div class="tabs-content" data-tabs-content="instance-view-tabs">

            <div class="tabs-panel" id="panel-properties">
                <h4 class="view-subtitle"><?= __('Properties:') ?></h4>
                <table class="hover stack vertical-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($instance->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Name (Spanish)') ?></th>
                        <td><?= h($instance->name_es) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('App URL') ?></th>
                        <td><?= $this->Html->link(['controller' => 'Instances', 'action' => 'preview', $instance->namespace, '_full' => true])?> </td>
                    </tr>
                </table>
                
                <h4 class="view-subtitle"><?= __('Description:') ?></h4>
                <?= $this->Text->autoParagraph(h($instance->description)); ?>
                
                
                <h4 class="view-subtitle"><?= __('Description (Spanish):') ?></h4>
                <?= $this->Text->autoParagraph(h($instance->description_es)); ?>

                <h4 class="view-subtitle"><?= __('Logo:') ?></h4>
                <div class="logo-display">
                    <?php if (empty($instance->logo)):  ?>
                        <p>PLEASE UPLOAD AN IMAGE</p>
                    <?php else: ?>
                        <?= $this->Html->image('/' . $instance->logo , ['alt' => 'Instance Logo'])  ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tabs-panel" id="panel-categories">

                <h4 class="view-subtitle-related"><?= __('Related Project Categories: ' . count($instance->categories)) ?></h4>
                <a href=<?= $this->Url->build(['controller' => 'Categories', 'action' => 'add', $instance_namespace]) ?>><i class='fi-plus size-24'></i> Add Category</a>
                <?php if (!empty($instance->categories)): ?>
                <table class="hover stack" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Name (Spanish)') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($instance->categories as $category): ?>
                        <tr>
                            <td><?= h($category->name) ?></td>
                            <td><?= h($category->name_es) ?></td>
                            <td class="actions">
                                <a href=<?= $this->Url->build(['controller' => 'Categories', 'action' => 'edit', $instance->namespace, $category->id]) ?>><i class='fi-page-edit size-24'></i></a>
                                <?= $this->Form->postLink(
                                        $this->Html->tag('i', '', array('class' => 'fi-x size-24')), [
                                        'controller' => 'Categories',
                                        'action' => 'delete', $instance->namespace, $category->id], [
                                        'escape' => false,
                                        'confirm' => __('Are you sure you want to delete the "{0}" category?. This operation cannot be undone. All related data will be erased!', $category->name)
                                    ])
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>This instance does not have any related Category.</p>
                <?php endif; ?>
            </div>

            <div class="tabs-panel" id="panel-organization_types">

                <h4 class="view-subtitle-related"><?= __('Related Organization Types: ' . count($instance->organization_types)) ?></h4>
                <a href=<?= $this->Url->build(['controller' => 'OrganizationTypes', 'action' => 'add', $instance_namespace]) ?>><i class='fi-plus size-24'></i> Add Organization Type</a>
                <?php if (!empty($instance->organization_types)): ?>
                <table class="hover stack" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Name (Spanish)') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($instance->organization_types as $organization_type): ?>
                        <tr>
                            <td><?= h($organization_type->name) ?></td>
                            <td><?= h($organization_type->name_es) ?></td>
                            <td class="actions">
                                <a href=<?= $this->Url->build(['controller' => 'OrganizationTypes', 'action' => 'edit', 
                                $instance->namespace, $organization_type->id]) ?>><i class='fi-page-edit size-24'></i></a>
                                <?= $this->Form->postLink(
                                        $this->Html->tag('i', '', array('class' => 'fi-x size-24')), [
                                        'controller' => 'OrganizationTypes',
                                        'action' => 'delete', $instance->namespace, $organization_type->id], [
                                        'escape' => false,
                                        'confirm' => __('Are you sure you want to delete the "{0}" organization type?. This operation cannot be undone. All related data will be erased!', $organization_type->name)
                                    ])
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>This instance does not have any related Organization Type.</p>
                <?php endif; ?>
            </div>

            <div class="tabs-panel is-active" id="panel-users">

                <h4 class="view-subtitle-related"><?= __('Admins: ') ?></h4>
                <?php if (!empty($admins)): ?>
                <table class="hover stack" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Username') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sysadmins as $user): ?>
                        <tr>
                            <td>(sysadmin) <?= h($user->name) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td class="actions">
                                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', 
                                $instance_namespace, $user->id]) ?>><i class='fi-magnifying-glass size-24'></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php foreach ($admins as $user): ?>
                        <tr>
                            <td><?= h($user->name) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td class="actions">
                                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', 
                                $instance_namespace, $user->id]) ?>><i class='fi-magnifying-glass size-24'></i></a>
                                (REVOKE ADMIN)
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <p>This instance does not have any related Organization Type.</p>
                <?php endif; ?>


                <h4 class="view-subtitle-related"><?= __('Users: '  . $this->request->params['paging']['Users']['count'] ) ?></h4>
                <?php if (!empty($users)): ?>
                <table class="hover stack" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('name') ?></th>
                            <th><?= $this->Paginator->sort('email') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= h($user->name) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td class="actions">
                                <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', 
                                $instance_namespace, $user->id]) ?>><i class='fi-magnifying-glass size-24'></i></a>
                                (GRANT ADMIN)
                                <?= $this->Form->postLink(
                                        $this->Html->tag('i', '', array('class' => 'fi-x size-24')), [
                                        'controller' => 'Users',
                                        'action' => 'delete', $instance_namespace, $user->id], [
                                        'escape' => false,
                                        'confirm' => __('Are you sure you want to delete this user: "{0}"?. This operation cannot be undone. All related projects will be erased!', $user->email)
                                    ])
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                    </ul>
                    <p><?= $this->Paginator->counter() ?></p>
                </div>

                <?php else: ?>
                    <p>This instance does not have any related Organization Type.</p>
                <?php endif; ?>
            </div>

            <div class="tabs-panel" id="panel-configuration">
            
                <h4 class="view-subtitle"><?= __('Configuration:') ?></h4>
        
                <h5 class="view-subsubtitle"><?= __('For Users:') ?></h5>
                <table class="hover stack vertical-table">
                    <tr>
                        <th><?= __('Enable Genre field?') ?></th>
                        <td><?= $instance->use_user_genre ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Main Organization field?') ?></th>
                        <td><?= $instance->use_user_organization ? __('Yes') : __('No'); ?></td>
                    </tr>
                </table>
                
                <h5 class="view-subsubtitle"><?= __('For Projects:') ?></h5> 
                <table class="hover stack vertical-table">
                    <tr>
                        <th><?= __('Enable Categories?') ?></th>
                        <td><?= $instance->use_proj_categories ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Max. Allowed Categories') ?></th>
                        <td><?= $this->Number->format($instance->proj_max_categories) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Organization Type field?') ?></th>
                        <td><?= $instance->use_org_types ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Organization name field?') ?></th>
                        <td><?= $instance->use_proj_organization ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Cities usage?') ?></th>
                        <td><?= $instance->use_proj_cities ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable exact location?') ?></th>
                        <td><?= $instance->use_proj_location ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Project Stage field?') ?></th>
                        <td><?= $instance->use_proj_stage ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable external URL field?') ?></th>
                        <td><?= $instance->use_proj_url ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Description field?') ?></th>
                        <td><?= $instance->use_proj_description ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Contribution field?') ?></th>
                        <td><?= $instance->use_proj_contribution ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable Contributing field?') ?></th>
                        <td><?= $instance->use_proj_contributing ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Enable start and finish dates?') ?></th>
                        <td><?= $instance->use_proj_dates ? __('Yes') : __('No'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
