        <style type="text/css">
        h4.mr-title {font-size: 15px;line-height: 22px;padding-left: 8px;}
        .box-body.table-responsive th {width: 7%;vertical-align: top;background: #3c8dbc;color: #fff !important;}
        .box-body.table-responsive th a{color: #fff !important;}
        .box-body.table-responsive.submit-by {padding: 37px;font-weight: 600;line-height: 12px;background: #efefef;color: #222d32;text-align: center;
        margin-top: 10px;min-height: 67px;border: 1px solid #ccc;border-radius: 0;margin-right: 10px;}
        .box-body.table-responsive td {border: 1px solid #ddd;}
        .box.box-primary{overflow: hidden;}
        .btn-info{margin-top: 6px;}
        .col-md-6.pddleft {padding-left: 0 !important;}
        .col-md-6.pddright {padding-right: 0;}
        .total-sec .box-body.table-responsive {border-top: 3px solid #333;border-bottom: 3px solid #333;}
        .total-sec .box-body.table-responsive .table { width: 60%;}
        .total-sec .box-body.table-responsive .table th, .total-sec .box-body.table-responsive .table td {
        background: transparent; color: #333 !important; padding: 0;border: 0;font-size: 15px;font-weight: 600;}
        table#equip_details td {width: 25%;}
        .pull-right h4 {  font-weight: bold;  font-size: 17px;}
        </style>

        <?php

        $this->assign('title',__('Articles'));
        $this->Breadcrumbs->add(__('Articles'));

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
        <div class="box-header">
        <h3 class="box-title"><?= __('List of') ?> <?= __('Articles') ?></h3>
        <div class="box-tools">
        <?=$this->Html->link(
        __('<i class="glyphicon glyphicon-plus"></i> Add New Article'),
        ['action' => 'add'],
        ['class' => 'btn btn-success', 'escape' => false, 'title' => __('Add New Article')]
        );?>
        </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body table-responsive">
        <table class="table table-hover table-bordered">
        <thead>
        <tr>
        <th scope="col"><?= $this->Paginator->sort('Sr. No.') ?></th>
        <th scope="col"><?= $this->Paginator->sort('Article Title') ?></th>
        <th scope="col"><?= $this->Paginator->sort('Tag of Article') ?></th>

        <th scope="col"><?= $this->Paginator->sort('Created By') ?></th>
        <th scope="col"><?= $this->Paginator->sort('Created On') ?></th>

        <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
        <?php 

        $i=0; 
        if(!empty($articles)){
        foreach ($articles as $records){ $i++;
        ?>
        <tr>
        <td><?= $i ?></td>
        <td><?php echo $records->name ?></td>
        <td>
        <?php echo $records->tag?>
        </td>
        <td><?php echo $records->creation_by->name ?></td>
        <td><?php echo date('d-M-Y',strtotime($records->created_on)) ?></td>


        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $records->id],['class' => 'btn btn-info btn-xs', 'title' => __('View'), 'escape' => false]) ?>
        <?php
        
        if($records->created_by == $user_id){?>
        <?php echo $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $records->id],['class' => 'btn btn-warning btn-xs', 'title' => __('Edit1'), 'escape' => false]) ?> 
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
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        var baseurl = "<?php echo $this->Url->build('/admin/en/mpr', true);?>";
        $(document).ready(function(){
        var project_id = $('#project_no_id option:selected').val();
        var work_order_id = $('#hidd_wrk_id').val();

        if(project_id !=""){
        $.ajax({
        type:'GET', 
        async: true,
        cache: false,
        url: baseurl + '/getLoadWorkOrder',
        data: {
        project_id : project_id,
        work_order_id : work_order_id,
        },
        success: function(data) { 
        $("#work_order_id").html();
        $("#work_order_id").html(data);
        //<option value="-1">Select State</option>work_order_id
        },
        });
        }

        if(project_id !="" && work_order_id !=""){

        $.ajax({
        type:'GET', 
        async: true,
        cache: false,
        url: baseurl + '/getLoadDepartmentByWorkOrder',
        data: {
        work_order_id : work_order_id,
        },
        success: function(data) { 
        $("#department_id").html(data);
        //<option value="-1">Select State</option>work_order_id
        },
        });
        }

        })
        $(document).on('change',"#project_no_id",function(){
        var id = $(this).val();
        $.ajax({
        type:'GET', 
        async: true,
        cache: false,
        url: baseurl + '/getWorkOrder',
        data: {
        project_id : id,
        },
        success: function(data) { 
        $("#work_order_id").html(data);
        //<option value="-1">Select State</option>work_order_id
        },
        });
        });
        $(document).on('change',"#work_order_id",function(){
        var id = $(this).val();
        $.ajax({
        type:'GET', 
        async: true,
        cache: false,
        url: baseurl + '/getDepartmentByWorkOrder',
        data: {
        work_order_id : id,
        },
        success: function(data) { 
        $("#department_id").html(data);
        //<option value="-1">Select State</option>work_order_id
        },
        });

        });

        </script>
        <?php $this->end(); ?>