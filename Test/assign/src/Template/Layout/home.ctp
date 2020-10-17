<?php 
use Cake\Core\Configure;
use Cake\Routing\Router;
?>
<?= $this->Html->docType();?>
<html lang="en">
<head>
  <?= $this->Html->charset();?>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?= $this->fetch('meta');?>
  
  <?= $this->Html->meta('favicon.ico','/favicon.ico',['type' => 'icon']);?>

  <title><?=$this->fetch('title');?> - <?= Configure::read('Theme.title'); ?></title>
 
  <?= $this->Html->meta('robots','all') ?> 
  
  <?php $path = Router::url(null,['_full'=>true]);
  echo $this->Html->tag('link', null, array('rel' =>'canonical','href'=>$path));?>

  <!-- Bootstrap -->
  <?= $this->Html->css('../bootstrap/css/bootstrap.min'); ?>
  
  <!-- Font CSS -->
  <?= $this->Html->css(['../font-awesome/css/font-awesome.min']); ?>
  <!-- Theme style --><?= $this->Html->css(['style','Admin.css','Admin.min.css','https://fonts.googleapis.com/css?family=Montserrat:400,700','https://fonts.googleapis.com/css?family=Roboto:400,400italic,300,300italic,500,700']); ?>

  <!-- Custom Css -->
  <?= $this->fetch('css'); ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<?php
$params = $this->request->getAttribute('params');
$classes = [];

if (!empty($userArray)) {
  $classes[] = 'logged-in';
  $classes[] = $userArray['name'];
} else {
  $classes[] = 'not-logged-in';
}
$classes[] = $params['controller'];
$classes[] = $params['action'];
array_unique( $classes );
?>
<body class="hold-transition page-template-home <?php echo implode(' ',$classes);?>">
  <a class="scrollToTop" href="#">
    <i class="fa fa-angle-up"></i>
  </a>

  <div id="main-container"> 
  
    <?= $this->fetch('content'); ?>
    <?= $this->element('noscript'); ?>
    
  </div>

<?= $this->Html->script(['jquery.min','../bootstrap/js/bootstrap.min','jquery.validate.min','jquery-additional-methods.min','scripts']); ?>

<?= $this->fetch('script'); ?>
<?= $this->fetch('bottom-script');?>

</body>
</html>
