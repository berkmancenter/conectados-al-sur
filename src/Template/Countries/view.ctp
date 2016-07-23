<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Country'), ['action' => 'edit', $country->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Country'), ['action' => 'delete', $country->id], ['confirm' => __('Are you sure you want to delete # {0}?', $country->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="countries view large-9 medium-8 columns content">
    <h3><?= h($country->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Cod N3') ?></th>
            <td><?= h($country->cod_n3) ?></td>
        </tr>
        <tr>
            <th><?= __('Name En') ?></th>
            <td><?= h($country->name_en) ?></td>
        </tr>
        <tr>
            <th><?= __('Name Es') ?></th>
            <td><?= h($country->name_es) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($country->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Latitude') ?></th>
            <td><?= $this->Number->format($country->latitude) ?></td>
        </tr>
        <tr>
            <th><?= __('Longitude') ?></th>
            <td><?= $this->Number->format($country->longitude) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Cities') ?></h4>
        <?php if (!empty($country->cities)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Name En') ?></th>
                <th><?= __('Name Es') ?></th>
                <th><?= __('Country Id') ?></th>
                <th><?= __('Latitude') ?></th>
                <th><?= __('Longitude') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($country->cities as $cities): ?>
            <tr>
                <td><?= h($cities->id) ?></td>
                <td><?= h($cities->name_en) ?></td>
                <td><?= h($cities->name_es) ?></td>
                <td><?= h($cities->country_id) ?></td>
                <td><?= h($cities->latitude) ?></td>
                <td><?= h($cities->longitude) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Cities', 'action' => 'view', $cities->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Cities', 'action' => 'edit', $cities->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Cities', 'action' => 'delete', $cities->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cities->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
