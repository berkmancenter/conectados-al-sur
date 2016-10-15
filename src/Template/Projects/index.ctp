<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    
<div class="row">
    <div class="small-12 column view-title">
        <h3><?= __('Project List') ?></h3>
        <div class="small-12 column">
            <?= $this->App->displayInstancePreviewShortcut($instance->namespace) ?>
            <?= $this->App->displayInstanceMapShortcut($instance->namespace) ?>
            <?= $this->App->displayInstanceDotsShortcut($instance->namespace) ?>
        </div>
        <div class="small-12 column">
        <a href="<?= $this->Url->build(['action' => 'add', $instance->namespace]) ?>"><i class='fi-plus size-36'></i>New Project</a>
        <a href="<?= $this->Url->build(['action' => 'exportCsv', $instance->namespace]) . "?" . $filter_query ?>"><i class='fi-arrow-down size-36'></i>Download</a>
        </div>
    </div>
    <div class="small-12 column">
        
    </div>
</div>

<div class="row">
    <div class="small-12 column">
        <h4 class="view-subtitle-related"><?= __('Configuration (Found: ' . $this->request->params['paging']['Projects']['count'] . ")" ) ?></h4>
        <ul id="ul-settings">
            <?php if (isset($filter_continent)): ?>
            <li>
                <span class="ul-title"><?= __d('map', "Region") ?>:</span>  <span class="ul-value">
                    <?php if ($lang_current == "en"): ?>
                        <?= $filter_continent->name ?>
                    <?php else: ?>
                        <?= $filter_continent->name_es ?>
                    <?php endif; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if (isset($filter_country)): ?>
            <li>
                <span class="ul-title"><?= __d('map', "Country") ?>:</span>  <span class="ul-value">
                    <?php if ($lang_current == "en"): ?>
                        <?= $filter_country->name ?>
                    <?php else: ?>
                        <?= $filter_country->name_es ?>
                    <?php endif; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if (isset($filter_orgtype)): ?>
            <li>
                <span class="ul-title"><?= __d('map', "Organization Type") ?>:</span>  <span class="ul-value">
                    <?php if ($lang_current == "en"): ?>
                        <?= $filter_orgtype->name ?>
                    <?php else: ?>
                        <?= $filter_orgtype->name_es ?>
                    <?php endif; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if (isset($filter_project_stage)): ?>
            <li>
                <span class="ul-title"><?= __d('map', "Project Stage") ?>:</span>  <span class="ul-value">
                    <?php if ($lang_current == "en"): ?>
                        <?= $filter_project_stage->name ?>
                    <?php else: ?>
                        <?= $filter_project_stage->name_es ?>
                    <?php endif; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if (isset($filter_genre)): ?>
            <li>
                <span class="ul-title"><?= __d('map', "Collaborator Genre") ?>:</span>  <span class="ul-value">
                    <?php if ($lang_current == "en"): ?>
                        <?= $filter_genre->name ?>
                    <?php else: ?>
                        <?= $filter_genre->name_es ?>
                    <?php endif; ?>
                </span>
            </li>
            <?php endif; ?>
            <?php if (isset($filter_category)): ?>
            <li>
                <span class="ul-title"><?= __d('map', "Category") ?>:</span>  <span class="ul-value">
                    <?php if ($lang_current == "en"): ?>
                        <?= $filter_category->name ?>
                    <?php else: ?>
                        <?= $filter_category->name_es ?>
                    <?php endif; ?>
                </span>
            </li>
            <?php endif; ?>
        </ul>
        <?php if ( $this->request->params['paging']['Projects']['count'] > 0 ): ?>
        <table class="hover stack" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th><?= __('Name') ?></th>
                    <th><?= __('Organization') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($projects as $project): ?>
                <tr>
                    <td>
                        <?= $this->Html->link("<i class='fi-magnifying-glass'></i>", ['controller' => 'Projects', 'action' => 'view', $instance->namespace, $project->id], ['escape' => false]) ?>
                        <?= h($project->name) ?>
                    </td>
                    <td><?= h($project->organization) ?></td>
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
            <p><?= $this->Paginator->counter(
                        __('Page') . ' {{page}} ' . __('of') . ' {{pages}}'
                    )
                ?>
            </p>
        </div>
        <?php else: ?>
            <p><?= __d('projects', 'No projects found for this configuration') ?></p>
        <?php endif; ?>
    </div>
</div>

<style type="text/css">

#ul-settings {

}
.ul-title {
    font-weight: bold;

}

</style>