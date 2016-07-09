<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Cities Country'), ['action' => 'edit', $citiesCountry->country_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Cities Country'), ['action' => 'delete', $citiesCountry->country_id], ['confirm' => __('Are you sure you want to delete # {0}?', $citiesCountry->country_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Cities Countries'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Cities Country'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="citiesCountries view large-9 medium-8 columns content">
    <h3><?= h($citiesCountry->country_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Country') ?></th>
            <td><?= $citiesCountry->has('country') ? $this->Html->link($citiesCountry->country->name, ['controller' => 'Countries', 'action' => 'view', $citiesCountry->country->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('City') ?></th>
            <td><?= $citiesCountry->has('city') ? $this->Html->link($citiesCountry->city->name, ['controller' => 'Cities', 'action' => 'view', $citiesCountry->city->id]) : '' ?></td>
        </tr>
    </table>
</div>
