
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
        <div class="box-header">
        <h3 class="box-title"><?= __('List of') ?> <?= __('Contents') ?></h3>
        <div class="box-tools">
        <?=$this->Html->link(
        __('<i class="glyphicon glyphicon-plus"></i> Add New Content'),
        ['action' => 'add'],
        ['class' => 'btn btn-success', 'escape' => false, 'title' => __('Add New Content')]
        );?>
        </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-hover table-bordered">
        <thead>
        <tr>
        <th scope="col" style="width:20%"><?= $this->Paginator->sort('Sr. No.') ?></th>
        <th scope="col" style="width:30%"><?= $this->Paginator->sort('Article Name') ?></th>
        <th scope="col" style="width:40%"><?= $this->Paginator->sort('Content') ?></th>
        <th scope="col" style="width:10%" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php 

        $i=0; 
        if(!empty($contents)){
        foreach ($contents as $records){ $i++;
        ?>
        <tr>
        <td><?= $i ?></td>
        <td><?php echo $records['article']['name'] ?></td>
        <td><?php echo $this->Text->truncate($records['content_body'],50,['ellipsis' => '...','exact' =>false]
        ); ?></td>
        

        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $records['id']],['class' => 'btn btn-info btn-xs', 'title' => __('View'), 'escape' => false]) ?>
        <?php
        
        if($records['article']['created_by'] == $user_id){?>
        <?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $records['id']],['class' => 'btn btn-warning btn-xs', 'title' => __('Edit1'), 'escape' => false]) ?> 
        <?php }?>

        </td>
        </tr>
        <?php }?>
        <?php }else{?>
        <tr>
        <td colspan="6"><?= __('Record not found!'); ?></td>
        </tr>
        <?php }?>
        </tbody>
        </table>
        </div>
        <!-- /.box-body -->
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
        <!-- /.box -->
        </div>
        </div>
        </div>
        </div>
        </section>
        <?php $this->append('bottom-script');?>
       <style>
        table, th, td {
          border: 1px solid black !important;
        }
</style>
        <?php $this->end(); ?>