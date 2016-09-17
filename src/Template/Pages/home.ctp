<!-- Available Actions -->
<?php $this->start('available-actions'); ?>
<?php $this->end(); ?>

<!-- Page Content -->
<div class="fullwidth page-content">
    <div class="row home">
        <div class="small-12 column home-title">
            <h3> <span id="home-title-b">dvine</span> <span id="home-title-l">Web App</span></h3>
        </div>
        <div class="small-12 column home-text">
            <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mollis auctor interdum. Duis ut dolor felis. Nam scelerisque cursus dictum. Nunc in scelerisque felis. Cras vitae diam vitae urna laoreet semper. Donec ut dui ac felis semper euismod. Vivamus et turpis ut est posuere mollis sed et diam. Integer mattis condimentum vulputate.
            </p>

			<p>Quisque in eros vel arcu auctor fringilla. Morbi lorem leo, luctus sit amet arcu vitae, volutpat dapibus leo. Proin rhoncus facilisis vehicula. Aenean finibus enim eros, in fermentum dolor accumsan quis. Praesent eget lorem porttitor, auctor tortor eu, luctus nulla. Aliquam volutpat eu sem eu laoreet. Duis rhoncus blandit nulla non laoreet. </p>
        </div>
        <!-- <div>
        	<?php if (isset($auth_user)): ?>
                <li>
                    <a href="#"><i class='fi-torso size-16'></i></a>
                    <ul class="menu vertical">
                        <li class="menu-text" id="top-bar-username-li"><span><?php echo $auth_user['email'] ?></span>
                        </li>
                        <li>
                            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $auth_user_namespace, $auth_user['id']]) ?>>Your profile</a>
                        </li>
                        <?php if (
                                $auth_user['role_id'] > 0 &&
                                isset($instance_namespace) &&
                                $instance_namespace != "sys"
                            ): ?>
                        <li>
                            <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'view', $instance_namespace]) ?>>Settings</a>
                        </li>
                        <?php endif; ?>
                        <?php if ($auth_user['role_id'] == 2): ?>
                        <li>
                            <a href=<?= $this->Url->build(['controller' => 'Instances', 'action' => 'index']) ?>>DVINE Settings</a>
                        </li>
                        <?php endif; ?>
                        <li id="top-bar-logout-li">
                            <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout', $auth_user_namespace]) ?>>Sign Out</a>
                        </li>
                    </ul>
                </li>
            <?php else: ?>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'add']) ?>>
                    	Sign Up
                   	</a>
                </li>
                <li>
                    <a href=<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>>
                    	Sign In
                    </a>
                </li>
            <?php endif; ?>
        </div> -->
    </div>
</div>

<style>
	.home-title {
		color: rgb(54,54,55);
		margin-top: 50px;
		margin-bottom: 50px;
	}
	#home-title-b {
		font-family: Futura;
	    font-weight: bold;
	    font-size: 36px;
	}
	#home-title-l {
		font-family: Futura;
		font-weight: normal;
	    font-size: 36px;
	}
	.home-text {
		font-family: Futura;
		font-weight: normal;
		font-size: 20px;
	}

	.home-text p {
		margin: 30px 0px;
	}

</style>
<script>
	$("body").css("background-color", "#ed7d31");
</script>