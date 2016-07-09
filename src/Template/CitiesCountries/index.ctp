<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Cities Country'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="citiesCountries index large-9 medium-8 columns content">
    <h3><?= __('Cities Countries') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('country_id') ?></th>
                <th><?= $this->Paginator->sort('city_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citiesCountries as $citiesCountry): ?>
            <tr>
                <td><?= $citiesCountry->has('country') ? $this->Html->link($citiesCountry->country->name, ['controller' => 'Countries', 'action' => 'view', $citiesCountry->country->id]) : '' ?></td>
                <td><?= $citiesCountry->has('city') ? $this->Html->link($citiesCountry->city->name, ['controller' => 'Cities', 'action' => 'view', $citiesCountry->city->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $citiesCountry->country_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $citiesCountry->country_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $citiesCountry->country_id], ['confirm' => __('Are you sure you want to delete # {0}?', $citiesCountry->country_id)]) ?>
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
</div>
