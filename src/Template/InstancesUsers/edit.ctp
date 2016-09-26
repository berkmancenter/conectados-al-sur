<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns">
        <div class="signup-panel">
            <p class="welcome">Edit Profile</p>
            <p class="welcome subtitle"><?= $instance->name ?></p>

            <?= $this->Flash->render('auth') ?>
            <?= $this->Form->create() ?>

            <!-- contact -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-address-book"></i></span>
                    <?= $this->Form->input('contact', [
                        'label'            => '',
                        'placeholder'      => 'Contact: my.organization@example.com',
                        'class'            => 'input-group-field',
                        'aria-describedby' => 'contactHelpText',
                        'type'             => 'email',
                        'value'            => $instances_user->contact,
                        'required']) ?>
                </div>
                <p class="help-text" id="contactHelpText">Contact email for this app. Public for everyone to see.</p>
            </div>

            <!-- main_organization -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-torsos-all"></i></span>
                    <?= $this->Form->input('main_organization', [
                        'label'            => '',
                        'placeholder'      => 'e.g. United Nations',
                        'class'            => 'input-group-field',
                        'aria-describedby' => 'mainOrgHelpText',
                        'type'             => 'text',
                        'value'            =>  $instances_user->main_organization == "[null]" ? '' : $instances_user->main_organization,
                        'required']) ?>
                </div>
                <p class="help-text" id="mainOrgHelpText">Main organization you work in.</p>
            </div>

            <!-- organization_type_id -->
            <div class="row collapse">
                <div class="input-group">
                    <span class="input-group-label"><i class="fi-lightbulb"></i></span>
                    <?= $this->Form->input('organization_type_id', [
                        'label'            => '',
                        'placeholder'      => 'e.g. United Nations',
                        'class'            => 'input-group-field',
                        'aria-describedby' => 'orgTypeHelpText',
                        'type'             => 'select',
                        'options'          => $organization_types,
                        'required']) ?>
                </div>
                <p class="help-text" id="orgTypeHelpText">Type of this organization.</p>
            </div>


            <!-- submit, cancel -->
            <div class="row">
                <div class="small-6 columns">
                    <?= $this->Form->button(__('Save'), ['class' => 'button']) ?>
                </div>
                <div class="small-6 columns">
                    <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user_id]) ?> class="alert hollow button">CANCEL</a>
                </div>
            </div>
        
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>

<style type="text/css">
.signup-panel {
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 15px;
    margin-top: 30px;
}

.signup-panel form input,
.signup-panel form select,
.signup-panel form span {
    height: 50px;
}

.signup-panel i {
    font-size: 30px;
    line-height: 45px;
    color: #999;
}
.signup-panel .fi-heart {
    /*color: red;*/
}
.signup-panel .welcome {
    font-size: 26px;
    text-align: center;
    margin-left: 0;
}

.signup-panel .subtitle {
    font-size: 20px;
    text-align: left;
    margin-left: 0;
    color: rgb(237, 125, 49);
}

.signup-panel p {
    font-size: 13px;
    font-weight: 200;
    margin-top: 10px;
    margin-left: 0%;
}
.signup-panel .button {
    margin-left: 0%;
}
.signup-panel .alert {
    float: right;
}
</style>