<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'OrderMe: Online order application';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <?php
      $path=$this->request->getParam('controller');
    ?>
</head>
<body>
<nav class="top-nav">
    <div class="top-nav-title">
        <a href="<?= $this->Url->build('/') ?>"><span>Order</span>Me</a>
    </div>
    <div class="top-nav-links">
        <h4 style="text-align:center">
            <b style=<?= $path == 'Dishs' ? 'text-decoration:underline overline;' : '' ?> ><?= $this->Html->link('Menu', ['controller' => 'dishs', 'action' => 'index']) ?></b> |
            <b style=<?= $path == 'Desks' ? 'text-decoration:underline overline;' : '' ?> ><?= $this->Html->link('Tables', ['controller' => 'desks', 'action' => 'index']) ?></b> |
            <b style=<?= $path == 'Carts' ? 'text-decoration:underline overline;' : '' ?> ><?= $this->Html->link('My Cart', ['controller' => 'carts', 'action' => 'index']) ?></b> |
            <b style=<?= $path == 'Orders' ? 'text-decoration:underline overline;' : '' ?> ><?= $this->Html->link('My Orders', ['controller' => 'orders', 'action' => 'index']) ?></b>|
            <b style=<?= $path == 'Users' ? 'text-decoration:underline overline;' : '' ?> ><?= $this->Html->link('Profile', ['controller' => 'users', 'action' => 'index']) ?></b> |
            <?= $this->Html->link('Login', ['controller' => 'users', 'action' => 'login']) ?>|
            <?= $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout']) ?>
        </h4>
    </div>
</nav>

<main class="main">
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</main>
<footer>
    <h5 style="text-align:center">
        <a target="_blank" rel="noopener" href="https://book.cakephp.org/4/">Documentation</a>
        <a target="_blank" rel="noopener" href="https://api.cakephp.org/">API</a>
    </h5>
    <h6 style="text-align:center">
        By: Bajron Ismailaj
    </h6>
</footer>
</body>
</html>
