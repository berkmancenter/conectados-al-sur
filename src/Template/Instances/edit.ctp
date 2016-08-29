<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<li><?= $this->Html->link(__('Home'), ['controller' => 'Instances', 'action' => 'preview', $instance_namespace]) ?> </li>
<li><?= $this->Html->link(__('Back to Instances'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Instance'), ['action' => 'add']) ?></li>
<?php $this->end(); ?>


<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-9 column view-title">
        <h3><?= h($instance->name) ?> (Editing)</h3>
        <a href=<?= $this->Url->build(['action' => 'preview', $instance->namespace]) ?>><i class='fi-home size-36'></i></a>
        <a href=<?= $this->Url->build(['action' => 'map', $instance->namespace]) ?>><i class='fi-map size-36'></i></a>
        <a href=<?= $this->Url->build(['action' => 'dots', $instance->namespace]) ?>><i class='fi-web size-36'></i></a>
    </div>
    <div class="small-12 medium-3 column view-title">
        <a href=<?= $this->Url->build(['action' => 'view', $instance->namespace]) ?>><i class='fi-magnifying-glass size-36'></i>View</a>
        <?= $this->Form->postLink($this->Html->tag('i', '', array('class' => 'fi-x size-36')) . "DELETE", ['action' => 'delete', $instance->namespace], ['escape' => false], 
                ['confirm' => __('Are you sure you want to delete the "{0}" instance?. This operation cannot be undone. All related data will be erased!', $instance->name)]) ?>
    </div>
</div>


<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($instance, ['type' => 'file']) ?>
            <ul class="tabs" data-tabs id="instance-edit-tabs">
                <li class="tabs-title is-active"><a href="#panel-properties" aria-selected="true">Properties</a></li>
                <li class="tabs-title"><a href="#panel-user-config">User Configurations</a></li>
                <li class="tabs-title"><a href="#panel-proj-config">Project Configurations</a></li>
                <li class="tabs-title"><a href="#panel-logo-config">Logo</a></li>
            </ul>
            <div class="tabs-content" data-tabs-content="instance-edit-tabs">
                <div class="tabs-panel is-active" id="panel-properties">
                    <h4 class="view-subtitle"><?= __('Properties:') ?></h4>
                    <fieldset>
                    <?php 
                        echo $this->Form->input('name', ['label' => 'Instance Name', 'placeholder' => 'required']);
                    ?>
                    <?php 
                        echo $this->Form->input('name_es', ['label' => 'Instance Name (Spanish)', 'placeholder' => 'required']);
                    ?>
                    <?php 
                        echo $this->Form->input('namespace', ['label' => 'Shortname', 'placeholder' => $this->Url->build(['action' => 'preview', 'shortname', '_full' => true]), 'aria-describedby' => 'namespaceHelpText']);
                    ?>
                    <p class="help-text" id="namespaceHelpText">This word will be used as the domain's namespace, from which the url is built. e.g. "my-page" will result in <?php echo $this->Url->build(['action' => 'preview', 'my-page', '_full' => true]) ?>.</p>
                    </fieldset>

                    <fieldset>
                    <h5 class="view-subsubtitle"><?= __('Instance Descriptions:') ?></h5>
                    <p>Both descriptions will be displayed on the home page of this instance.</p>
                    <?php 
                        echo $this->Form->input('description', ['label' => 'Description', 'placeholder' => 'required']);
                        echo $this->Form->input('description_es', ['label' => 'Description (Spanish)', 'placeholder' => 'required']);
                    ?>
                    </fieldset>
                </div>
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
                    <p>By default, only the country is saved for each project.<!--  When enabling the cities, each project without city will be assigned to the respective capital. --></p>
                    <?php
                        echo $this->Form->input('use_proj_cities', ['label' => 'Map using cities']);
                        echo $this->Form->input('use_proj_location', ['label' => 'Use geo coordinates to generate a link to a google map with projects as markers.']);
                    ?>
                    </fieldset>
                </div>
                <div class="tabs-panel" id="panel-logo-config">
                    <h4 class="view-subtitle"><?= __('Instance Logo:') ?></h4>
                    <fieldset>
                    <p>TODO: formatos aceptados y chequeo de tamaño y tipo</p>
                    <p>TODO: posibilidad de borrar el logo?</p>
                    <p>TODO: A veces falla... ver errores!?</p>
                    <p>The logo will be displayed on the footer of the page above the CAS logo.</p>
                    <p>Valid formats are: PNG. Max. file size: 256kB. The displayed image will have a max height of 100px, greater images will be resized to 100px height.</p>
                    <label for="logoFileUpload" class="button">Upload File</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="256000" />
                    <?php echo $this->Form->file('logo', ['id' => 'logoFileUpload', 'class' => 'show-for-sr']); ?>
                    </fieldset>
                    <div class="logo-display">
                    <?php if (empty($instance->logo)):  ?>
                        <p>Please upload an image</p>
                    <?php else: ?>
                        <?= $this->Html->image('/' . $instance->logo , ['alt' => 'Instance Logo'])  ?>
                    <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            <?= $this->Form->button(__('Submit'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
