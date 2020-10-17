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
 */

use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$this->fetch('title');?> - <?php echo Configure::read('Theme.title'); ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?=$this->fetch('meta');?>
    <!-- head style -->
    <!-- Favicon -->
    <?= $this->Html->meta('icon', '/img/favicon.png', ['type'=>'image/png']);?>
    <!-- Bootstrap 3.3.5 -->
    <?php echo $this->Html->css('../bootstrap/css/bootstrap.min'); ?>
    <!-- Font Awesome -->
    <?php echo $this->Html->css('../font-awesome/css/font-awesome.min'); ?>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <?php echo $this->Html->css('Admin.min'); ?>
    <!-- Custom style -->
    <?php echo $this->Html->css('custom'); ?>
    <!-- Admin Skins. -->
    <?php echo $this->Html->css('skins/skin-'. Configure::read('Theme.skin') .'.min'); ?>

    <?php echo $this->fetch('css'); ?>
    <?=$this->fetch('head-style');?>
    <!-- /head style -->
    <!-- head script -->
    <?=$this->Html->script([]);?>
    <?=$this->fetch('head-script')?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<?php
$action = !empty($this->request->getParam('action')) ? $this->request->getParam('action') : null;
$controller = !empty($this->request->getParam('controller')) ? $this->request->getParam('controller') : null;
?>
<body class="hold-transition <?= $controller.'-'.$action ?> skin-<?php echo Configure::read('Theme.skin'); ?> sidebar-mini">
    <div class="loading"></div>
    <div id="loader"></div>
    <!-- Site wrapper -->
    <div class="wrapper">

        <?php echo $this->element('footer'); ?>

    <?= $this->element('sidebar-menu'); ?>   

<!-- jQuery 3.3.1 -->
<?= $this->Html->script('jquery.min'); ?>
<!-- Bootstrap 3.3.5 -->
<?php echo $this->Html->script('../bootstrap/js/bootstrap.min'); ?>



<!-- SlimScroll -->

<!-- Validate -->
<?php echo $this->Html->script('jquery.validate.min'); ?>
<!-- Additional Methods -->
<?php echo $this->Html->script('jquery-additional-methods.min'); ?>
<!-- Admin App -->
<?php echo $this->Html->script('app.min'); ?>
<!-- Admin -->
<?php echo $this->fetch('script'); ?>
<noscript>
    <?= $this->element('noscript'); ?>
</noscript>




<?=$this->fetch('bottom-script')?>
</body>
</html>
