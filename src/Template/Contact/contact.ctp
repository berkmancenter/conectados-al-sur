
<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row">
        <div class="small-12 medium-8 medium-offset-2 large-6 large-offset-3 columns">
            <div class="contact-div">
                <p class="welcome"><?= __('Contact Us') ?></p>
                <form method="post">
                <?php
                    echo $this->Form->create($contact);

                    echo $this->Form->input('name', [
                        'label' => __('Your Name'),
                        'placeholder' => 'John Doe',
                        'required' => false,
                    ]);

                    echo $this->Form->input('email', [
                        'label' => __('Your email'),
                        'placeholder' => 'john.doe@example.com',
                        'required' => false,
                    ]);

                    echo $this->Form->input('body', [
                        'label' => __('Your message'),
                        'type' => 'textarea',
                        'required' => false,
                    ]);

                    echo $this->Form->button(__('Submit message'), [
                        'class' => 'button',
                        'type' => 'submit'
                    ]);
                    echo $this->Form->end();
                ?>
                </form>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
.contact-div {
    border-radius: 5px;
    border: 5px solid #ccc;
    padding: 15px;
    margin-top: 30px;
}

.contact-div label {
    font-weight: bold;
}

.contact-div form input,
.contact-div form select,
.contact-div form span {
    height: 50px;
}

.contact-div .welcome {
    font-size: 26px;
    text-align: center;
    margin-left: 0;
}
.contact-div p {
    font-size: 13px;
    font-weight: 200;
    margin-top: 10px;
    margin-left: 0%;
}
.contact-div .button {
    margin-left: 0%;
}
.contact-div .alert {
    float: right;
}
</style>