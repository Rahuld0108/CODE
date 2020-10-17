<?php 
use Cake\Collection\Collection;
use Cake\Core\Configure; ?>

<?php

$this->assign('title',__('Dashboard'));
$this->assign('subtitle',__('Dashboard'));
$this->Breadcrumbs->add(__('Dashboard'));
$this->Html->meta('keywords', 'Dashboard', ['block' => true]);
?>


<section class="content localeSource add form">

      <div class="row">
        <?= $this->Flash->render(); ?>
        <?= $this->Flash->render('auth'); ?>
        <div class="col-md-12">
         <div class="box-header with-border">
            <div class="btn btn-danger" style="float:right">
              <a href="<?= $this->Url->build(['controller'=>'Users','action'=>'logout'])?>">Logout</a>
            </div>
            <div class="clearfix"></div>
		
        </div>

  <div class="row">
      <div class="col-md-12">
       <div class="col-md-4">
       <div class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
   <ul class="sidebar-menu list-group">
    <li class="header">MAIN NAVIGATION</li>
    <li class="list-group-item">
        <?=$this->Html->link('<i class="fa fa-dashboard"></i> <span>Dashboard</span>',['controller'=>'dashboard','action'=>'index'], ['class'=> 'silvermenu', 'title' => __('Dashboard'), 'escape' => false]);?>
    </li>
    <li class="treeview list-group-item">
        <?= $this->Html->link('<i class="fa fa-book"></i><span>Article</span>',['controller'=>'articles','action'=>'index'],['class'=> 'silvermenu', 'title' => __('Dashboard'), 'escape' => false]); ?>
    </li>
    <li class="treeview list-group-item">
        <?= $this->Html->link('<i class="fa fa-book"></i><span>Content</span>',['controller'=>'contents','action'=>'index'],['class'=> 'silvermenu', 'title' => __('Dashboard'), 'escape' => false]); ?>
    </li>
   
    
</ul>

    </section>
    <!-- /.sidebar -->
</div>
       
       
     
        </div>
      <div class="col-md-8">
        <?= $this->Flash->render(); ?>
        <div class="box box-primary">
          <div class="box-header">
              <h2 class="box-title" style="text-align:center">Welcome <?php echo $name?></h2>
          </div> 
            
          </div>
      </div>
      
        </div>
    </div>
    
    <!--<div class="row">
      <div class="col-md-12">
        <?= $this->Flash->render(); ?>
        <?= $this->Flash->render('auth'); ?>
        <div class="col-md-4">&nbsp;</div>
        <div class="col-md-8">
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"><?= __('List of') ?> <?= __('Users') ?></h3>
          </div>
           <?php if(!empty($name)){ ?>
           <?= $this->Form->create('searchViewMpr1',['id' =>'searchViewMpr1','type'=>'get']); ?>
           <input type="hidden" value="<?php echo $name?>" name="name">
          <button name="search_button" value="pdf" type="submit" class="btn btn-primary btn-green">Download PDF</button>
           <?= $this->Form->end(); ?>        
          <?php } ?>
          
          <div class="box-body table-responsive">
            <table class="table table-hover table-bordered" border="1px">
              <thead>
                <tr>
                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                    
                </tr>
              </thead>
              <tbody>
			  <?php //echo "<pre>"; print_r($users); exit;?>
                <?php foreach ($users as $user): ?>
                  <tr>
                        <td><?= $this->Number->format($user->id) ?></td>
                        <td><?= h($user->name) ?></td>
                        <td><?= h($user->email) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(count($users) == 0):?>
                    <tr>
                        <td colspan="10"><?= __('Record not found!'); ?></td>
                    </tr>
                    <?php endif;?>
              </tbody>
            </table>
          </div>
          
          <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
              <?= $this->Paginator->first('<<') ?>
              <?= $this->Paginator->prev('<') ?>
              <?= $this->Paginator->numbers() ?>
              <?= $this->Paginator->next('>') ?>
              <?= $this->Paginator->last('>>') ?>
            </ul>
          </div>
        </div>
        </div>
        
      </div>
    </div>-->
  
      </div><!-- ./row -->

  </div>
  </section>

<?php $this->append('bottom-script');?>
<?php $this->Html->css(['block' => 'head-style']); ?>
<?php $this->Html->script(['demo'], ['block' => 'bottom-script']); ?>
<?php $this->end();?>