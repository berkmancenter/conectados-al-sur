<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>


<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-12 column view-title">
        <h3>New Instance</h3>
        <a href=<?= $this->Url->build(['action' => 'index']) ?>><i class='fi-arrow-left size-36'></i>Back to Index</a>
    </div>
</div>


<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create() ?>
            
            <ul class="tabs" data-tabs id="instance-add-tabs">
                <li class="tabs-title is-active"><a href="#panel-properties" aria-selected="true">Properties</a></li>
                <li class="tabs-title"><a href="#panel-description">Description</a></li>
                <!-- <li class="tabs-title"><a href="#panel-user-config">User Configurations</a></li>
                <li class="tabs-title"><a href="#panel-proj-config">Project Configurations</a></li> -->
            </ul>

            <div class="tabs-content" data-tabs-content="instance-add-tabs">

                <div class="tabs-panel is-active" id="panel-properties">
                    <h4 class="view-subtitle"><?= __('Properties:') ?></h4>
                    <fieldset>
                    
                    <?= $this->Form->input('name', [
                        'label' => 'Instance Name',
                        'placeholder' => 'e.g: Music networking',
                    ]) ?>

                    <?= $this->Form->input('name_es', [
                        'label' => 'Instance Name (Spanish)',
                        'placeholder' => 'e.g: Mapeo musical'
                    ])
                    ?>

                    <?= $this->Form->input('namespace', [
                        'label' => 'Shortname',
                        'placeholder' => 'music',
                        'aria-describedby' => 'namespaceHelpText']);
                    ?>
                    <p class="help-text" id="namespaceHelpText">This word will be used as the domain's namespace, from which the url is built. e.g. "music" will result in <?php echo $this->Url->build(['action' => 'preview', 'music', '_full' => true]) ?>.</p>

                    <?= $this->Form->input('passphrase', [
                        'label' => 'Passphrase',
                        'placeholder' => 'my very secret phrase',
                        'aria-describedby' => 'passphraseHelpText']);
                    ?>
                    <p class="help-text" id="passphraseHelpText">You can give this to your users, so they can associate their accounts to your app. </p>

                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-description">
                    <h4 class="view-subtitle"><?= __('Instance Descriptions:') ?></h4>
                    <fieldset>
                    <p>Both descriptions will be displayed on the home page of this instance.</p>
                    
                    <?= $this->Form->input('description', [
                        'label' => 'Description',
                        'type' => 'textarea'
                    ])?>

                    <?= $this->Form->input('description_es', [
                        'label' => 'Description (Spanish)',
                        'type' => 'textarea'
                    ]) ?>
                    </fieldset>
                </div>
                <!-- 
                <div class="tabs-panel" id="panel-user-config">
                    <h4 class="view-subtitle"><?= __('User Configurations:') ?></h4>
                    <fieldset>
                    <p>Regarding user data that this instance will handle, which fields would you like to enable?</p>
                    <?php
                        echo $this->Form->input('use_user_genre', ['label' => 'Genre']);
                        echo $this->Form->input('use_user_organization', ['label' => 'Main organization name']);
                    ?>
                    </fieldset>
                </div>
                <div class="tabs-panel" id="panel-proj-config">
                    <h4 class="view-subtitle"><?= __('Project Configurations:') ?></h4>
                    <fieldset>
                    <h5 class="view-subsubtitle"><?= __('General:') ?></h5> 
                    <p>Which fields would you like to consider for your projects?</p>
                    <?php
                        echo $this->Form->input('use_proj_stage', ['label' => 'Project Stage']);
                        echo $this->Form->input('use_proj_url', ['label' => 'External URL']);
                        echo $this->Form->input('use_proj_description', ['label' => 'Project Description']);
                        echo $this->Form->input('use_proj_contribution', ['label' => 'Contribution']);
                        echo $this->Form->input('use_proj_contributing', ['label' => 'Contributing']);
                        echo $this->Form->input('use_proj_dates', ['label' => 'Start and Finish dates']);
                        echo $this->Form->input('use_org_types', ['label' => 'Organization Type']);
                        echo $this->Form->input('use_proj_organization', ['label' => 'Organization name']);
                        echo $this->Form->input('use_proj_categories', ['label' => 'Categories']);
                        echo $this->Form->input('proj_max_categories', ['label' => 'Allowed Number of Categories']);
                    ?>
                    </fieldset>
                    <fieldset>
                    <h5 class="view-subsubtitle"><?= __('Location information:') ?></h5> 
                    <p>By default, only the country is saved for each project. When enabling the cities, each project without city will be assigned to the respective capital. </p>
                    <?php
                        echo $this->Form->input('use_proj_cities', ['label' => 'Map using cities']);
                        echo $this->Form->input('use_proj_location', ['label' => 'Use geo coordinates to generate a link to a google map with projects as markers.']);
                    ?>
                    </fieldset>
                </div>
                -->
            </div>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>