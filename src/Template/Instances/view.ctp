<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Instance'), ['action' => 'edit', $instance->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Instance'), ['action' => 'delete', $instance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instance->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Instances'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Instance'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Organization Type'), ['controller' => 'OrganizationTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Projects'), ['controller' => 'Projects', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Project'), ['controller' => 'Projects', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="instances view large-9 medium-8 columns content">
    <h3><?= h($instance->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($instance->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Name Es') ?></th>
            <td><?= h($instance->name_es) ?></td>
        </tr>
        <tr>
            <th><?= __('Namespace') ?></th>
            <td><?= h($instance->namespace) ?></td>
        </tr>
        <tr>
            <th><?= __('Logo') ?></th>
            <td><?= h($instance->logo) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($instance->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Proj Max Categories') ?></th>
            <td><?= $this->Number->format($instance->proj_max_categories) ?></td>
        </tr>
        <tr>
            <th><?= __('Use Org Types') ?></th>
            <td><?= $instance->use_org_types ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use User Genre') ?></th>
            <td><?= $instance->use_user_genre ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use User Organization') ?></th>
            <td><?= $instance->use_user_organization ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Cities') ?></th>
            <td><?= $instance->use_proj_cities ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Stage') ?></th>
            <td><?= $instance->use_proj_stage ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Categories') ?></th>
            <td><?= $instance->use_proj_categories ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Description') ?></th>
            <td><?= $instance->use_proj_description ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Url') ?></th>
            <td><?= $instance->use_proj_url ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Contribution') ?></th>
            <td><?= $instance->use_proj_contribution ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Contributing') ?></th>
            <td><?= $instance->use_proj_contributing ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Organization') ?></th>
            <td><?= $instance->use_proj_organization ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Location') ?></th>
            <td><?= $instance->use_proj_location ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Use Proj Dates') ?></th>
            <td><?= $instance->use_proj_dates ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($instance->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Description Es') ?></h4>
        <?= $this->Text->autoParagraph(h($instance->description_es)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Categories') ?></h4>
        <?php if (!empty($instance->categories)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Name Es') ?></th>
                <th><?= __('Instance Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($instance->categories as $categories): ?>
            <tr>
                <td><?= h($categories->id) ?></td>
                <td><?= h($categories->name) ?></td>
                <td><?= h($categories->name_es) ?></td>
                <td><?= h($categories->instance_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Categories', 'action' => 'view', $categories->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Categories', 'action' => 'edit', $categories->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Categories', 'action' => 'delete', $categories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $categories->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Organization Types') ?></h4>
        <?php if (!empty($instance->organization_types)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Name Es') ?></th>
                <th><?= __('Instance Id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($instance->organization_types as $organizationTypes): ?>
            <tr>
                <td><?= h($organizationTypes->id) ?></td>
                <td><?= h($organizationTypes->name) ?></td>
                <td><?= h($organizationTypes->name_es) ?></td>
                <td><?= h($organizationTypes->instance_id) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'OrganizationTypes', 'action' => 'view', $organizationTypes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'OrganizationTypes', 'action' => 'edit', $organizationTypes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrganizationTypes', 'action' => 'delete', $organizationTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $organizationTypes->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Projects') ?></h4>
        <?php if (!empty($instance->projects)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Instance Id') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Url') ?></th>
                <th><?= __('Contribution') ?></th>
                <th><?= __('Contributing') ?></th>
                <th><?= __('Organization') ?></th>
                <th><?= __('Organization Type Id') ?></th>
                <th><?= __('Project Stage Id') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('City Id') ?></th>
                <th><?= __('Latitude') ?></th>
                <th><?= __('Longitude') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th><?= __('Start Date') ?></th>
                <th><?= __('Finish Date') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($instance->projects as $projects): ?>
            <tr>
                <td><?= h($projects->id) ?></td>
                <td><?= h($projects->name) ?></td>
                <td><?= h($projects->user_id) ?></td>
                <td><?= h($projects->instance_id) ?></td>
                <td><?= h($projects->description) ?></td>
                <td><?= h($projects->url) ?></td>
                <td><?= h($projects->contribution) ?></td>
                <td><?= h($projects->contributing) ?></td>
                <td><?= h($projects->organization) ?></td>
                <td><?= h($projects->organization_type_id) ?></td>
                <td><?= h($projects->project_stage_id) ?></td>
                <td><?= h($projects->country_id) ?></td>
                <td><?= h($projects->city_id) ?></td>
                <td><?= h($projects->latitude) ?></td>
                <td><?= h($projects->longitude) ?></td>
                <td><?= h($projects->created) ?></td>
                <td><?= h($projects->modified) ?></td>
                <td><?= h($projects->start_date) ?></td>
                <td><?= h($projects->finish_date) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Projects', 'action' => 'view', $projects->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Projects', 'action' => 'edit', $projects->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Projects', 'action' => 'delete', $projects->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projects->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Users') ?></h4>
        <?php if (!empty($instance->users)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name') ?></th>
                <th><?= __('Email') ?></th>
                <th><?= __('Contact') ?></th>
                <th><?= __('Password') ?></th>
                <th><?= __('Role Id') ?></th>
                <th><?= __('Instance Id') ?></th>
                <th><?= __('Genre Id') ?></th>
                <th><?= __('Main Organization') ?></th>
                <th><?= __('Organization Type Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($instance->users as $users): ?>
            <tr>
                <td><?= h($users->id) ?></td>
                <td><?= h($users->name) ?></td>
                <td><?= h($users->email) ?></td>
                <td><?= h($users->contact) ?></td>
                <td><?= h($users->password) ?></td>
                <td><?= h($users->role_id) ?></td>
                <td><?= h($users->instance_id) ?></td>
                <td><?= h($users->genre_id) ?></td>
                <td><?= h($users->main_organization) ?></td>
                <td><?= h($users->organization_type_id) ?></td>
                <td><?= h($users->created) ?></td>
                <td><?= h($users->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
