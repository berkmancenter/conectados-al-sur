<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>


<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-9 column view-title">
        <h3><?= h($instance->name) . ' ' . __d('crud', '(Editing)') ?></h3>
        <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="<?= __('Go to app home') ?>">
            <?= $this->App->displayInstancePreviewShortcut($instance->namespace) ?>
        </span>
        <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="<?= __('Go to app map') ?>">
            <?= $this->App->displayInstanceMapShortcut($instance->namespace) ?>
        </span>
        <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="<?= __('Go to app dots') ?>">
            <?= $this->App->displayInstanceDotsShortcut($instance->namespace) ?>
        </span>
    </div>
    <div class="small-12 medium-3 column view-title">
        <?= $this->App->displayInstanceViewShortcut($instance->namespace) ?>
        <?= $this->App->displayInstanceDeleteShortcut($instance->namespace, $instance->name) ?>
    </div>
</div>


<div class="row">
    <div class="small-12 column">
        <div class="form">
            <?= $this->Form->create($instance, ['type' => 'file']) ?>

            <ul class="tabs" data-tabs id="instance-edit-tabs">
                <li class="tabs-title is-active"><a href="#panel-properties" aria-selected="true"><?= __d('instances', 'Properties') ?></a></li>
                <li class="tabs-title"><a href="#panel-description"><?= __d('instances', 'Description') ?></a></li>
                <!-- <li class="tabs-title"><a href="#panel-user-config">User Configurations</a></li> -->
                <!-- <li class="tabs-title"><a href="#panel-proj-config">Project Configurations</a></li> -->
                <li class="tabs-title"><a href="#panel-logo-config"><?= __d('instances', 'Logo') ?></a></li>
            </ul>
            <div class="tabs-content" data-tabs-content="instance-edit-tabs">

                <div class="tabs-panel is-active" id="panel-properties">
                    <h4 class="view-subtitle"><?= __d('instances', 'Properties') . ":" ?></h4>
                    <fieldset>

                    <?= $this->Form->input('name', [
                        'label' => $this->Loc->fieldInstanceNameEn(),
                        'placeholder' => 'e.g: Music networking',
                    ]) ?>

                    <?= $this->Form->input('name_es', [
                        'label' => $this->Loc->fieldInstanceNameEs(),
                        'placeholder' => 'e.g: Mapeo musical'
                    ])
                    ?>

                    <?= $this->Form->input('namespace', [
                        'label' => $this->Loc->fieldInstanceNamespace(),
                        'placeholder' => 'music',
                        'aria-describedby' => 'namespaceHelpText']);
                    ?>
                    <p class="help-text" id="namespaceHelpText"><?= __d('instances', 'This word will be used as the domain\'s namespace, from which the url is built. e.g. "music" will result in') ?> <?php echo $this->Url->build(['action' => 'preview', 'music', '_full' => true]) ?>.</p>

                    <?= $this->Form->input('passphrase', [
                        'label' => $this->Loc->fieldInstancePassphrase(),
                        'placeholder' => __d('instances', 'my very secret phrase'),
                        'aria-describedby' => 'passphraseHelpText']);
                    ?>
                    <p class="help-text" id="passphraseHelpText"><?= __d('instances', 'You can give this to your users, so they can associate their accounts to your app.') ?></p>

                    </fieldset>
                </div>

                <div class="tabs-panel" id="panel-description">
                    <h4 class="view-subtitle"><?= __d('instances', 'Description') . ":" ?></h4>
                    <fieldset>
                    <p><?= "Both descriptions will be displayed on the home page of this app." ?></p>
                    
                    <?= $this->Form->input('description', [
                        'label' => $this->Loc->fieldInstanceDescriptionEn(),
                        'type' => 'textarea'
                    ])?>

                    <?= $this->Form->input('description_es', [
                        'label' => $this->Loc->fieldInstanceDescriptionEs(),
                        'type' => 'textarea'
                    ]) ?>
                    </fieldset>
                </div>
                <!-- <div class="tabs-panel" id="panel-user-config">
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
                </div> -->
                <div class="tabs-panel" id="panel-logo-config">
                    <h4 class="view-subtitle"><?= __d('instances', 'Properties') . ":" ?></h4>
                    <fieldset>                        
                    <p><?= __d('instances', "The logo will be displayed on the footer of the page.") ?></p>
                    <p><?= __d('instances', "Valid formats are: PNG. Max. file size: 256kB.") ?></p>
                    <p><?= __d('instances', "The displayed image will have a max height of 100px, greater images will be resized to 100px height.") ?></p>
                    <label for="logoFileUpload" class="button"><?= __d('instances', "Upload File") ?></label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="256000" />
                    <?php echo $this->Form->file('logo', ['id' => 'logoFileUpload', 'class' => 'show-for-sr']); ?>
                    </fieldset>
                    <div class="logo-display">
                    <?php if (empty($instance->logo)):  ?>
                        <p><?= __d('instances', "Please upload an image") ?></p>
                    <?php else: ?>
                        <?= $this->Html->image('/' . $instance->logo , ['alt' => 'App Logo'])  ?>
                    <?php endif; ?>
                    </div>
                    
                </div>
            </div>
            <?= $this->Form->button($this->Loc->formSubmit(), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
