<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $citiesCountry->country_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $citiesCountry->country_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Cities Countries'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Countries'), ['controller' => 'Countries', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Country'), ['controller' => 'Countries', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="citiesCountries form large-9 medium-8 columns content">
    <?= $this->Form->create($citiesCountry) ?>
    <fieldset>
        <legend><?= __('Edit Cities Country') ?></legend>
        <?php
            echo $this->Form->input('city_id', ['options' => $cities]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
