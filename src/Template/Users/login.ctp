<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">

<div class="row">
    <div class="small-12 column view-title">
        <h3><?= h("Sign in") ?></h3>
    </div>
</div>


<div class="row">
    <div class="small-12 column">
    	<div class="form users">
			<?= $this->Flash->render('auth') ?>
			<?= $this->Form->create() ?>
			    <fieldset>
			        <legend><?= __('Please enter your username and password') ?></legend>
			        <?= $this->Form->input('email', ['label' => 'Email', 'placeholder' => 'john.smith@gmail.com']) ?>

			        <?= $this->Form->input('password', ['label' => 'Password', 'aria-describedby' => 'passwordHelpText']) ?>
			        <!-- <p class="help-text" id="passwordHelpText">This word will be used as the domain's namespace, from which the url is built. e.g. "my-page" will result in <?php echo $this->Url->build(['action' => 'preview', 'my-page', '_full' => true]) ?>.</p> -->
			    </fieldset>
			<?= $this->Form->button(__('Login'), ['class' => 'warning button']) ?>
            <?= $this->Form->end() ?>
		</div>
    </div>
</div>
