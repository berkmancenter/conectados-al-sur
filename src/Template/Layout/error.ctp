<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <?= $this->Html->meta('icon') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div id="container">
        <div id="header">
        </div>
        <div id="content">
            <?= $this->Flash->render() ?>
            <!--
             <?= $this->fetch('content') ?>
            -->
            <p>An error has occurred, please return to <a href=<?= echo " . $this->Url->build(['controller' => 'Instances', 'action' => 'index']) . " ?> >Home</a> </p>
        </div>
        <div id="footer">
        </div>
    </div>
</body>
</html>
