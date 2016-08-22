<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Back to Instances'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('Instance Home Page'), ['controller' => 'Instances', 'action' => 'preview', $instance->namespace]) ?> </li>
        <li><?= $this->Html->link(__('Edit Instance'), ['action' => 'edit', $instance->namespace]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Instance [TODO]'), ['action' => 'view', $instance->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instance->namespace)]) ?> </li>
        
        <li><?= $this->Html->link(__('Related Categories'), ['controller' => 'Categories', 'action' => 'index', $instance->namespace]) ?> </li>
        <li><?= $this->Html->link(__('Related Organization Types'), ['controller' => 'OrganizationTypes', 'action' => 'index', $instance->namespace]) ?> </li>
        <li><?= $this->Html->link(__('Related Projects'), ['controller' => 'Projects', 'action' => 'index', $instance->namespace]) ?> </li>
        <li><?= $this->Html->link(__('Related Users'), ['controller' => 'Users', 'action' => 'index', $instance->namespace]) ?> </li>
    </ul>
</nav>
<div class="instances view large-10 medium-9 columns content">
    <h3><?= h($instance->name) ?></h3>
    <h4><?= __('Properties:') ?></h4>
    <table class="vertical-table">
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
        <tr>
            <th><?= __('Logo') ?></th>
            <td>TO-DO</td>
            <!-- <td><?= h($instance->logo) ?></td> -->
        </tr>
    </table>
    <h4><?= __('Description') ?></h4>
    <?= $this->Text->autoParagraph(h($instance->description)); ?>
    <h4><?= __('Description (Spanish)') ?></h4>
    <?= $this->Text->autoParagraph(h($instance->description_es)); ?>

    <h4><?= __('Configuration:') ?></h4>
    <h5><?= __('For Users:') ?></h5>
    <table class="vertical-table">
        <tr>
            <th><?= __('Enable Genre field?') ?></th>
            <td><?= $instance->use_user_genre ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th><?= __('Enable Main Organization field?') ?></th>
            <td><?= $instance->use_user_organization ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <h5><?= __('For Projects:') ?></h5>
    <table class="vertical-table">
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
