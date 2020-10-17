 <script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<?php
  $this->assign('title',__('View Contents'));
  ?>

<style type="text/css">
  .error-message{
  color:red;
  }
  .red{
  color:red;
  }
  .error{
  color:red;
  }
</style>
<section class="content localeSource add form">
  <div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <?= $this->Flash->render(); ?>
    <!-- general form elements -->
    
      <div class="box-header with-border">
        <h3 class="box-title">
          <?= __("View Contents") ?>
        </h3>
        <div class="box-tools pull-right">
          <?=$this->Html->link(
            '<i class="fa fa-arrow-circle-left"></i>',
            ['action' => 'index'],
            ['class' => 'btn btn-info btn-xs','title' => __('Back to List'),'escape' => false]
            );?>
        </div>
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
      
      <div class="box-body">
        <div class="">
          <div class="row">
            <div class="col-md-12 firstrow">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fs11">Article<sup class="red">*</sup></label>
                  <?=  $this->Form->input('name',['label' =>false,"id"=> "name",'readonly','required'=>true,'class'=>'form-control','value'=>$contents->article->name]); ?>
                </div> 
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="fs11">Content Body<sup class="red">*</sup></label>
                  <textarea id="ckeditor" class="form-control" readonly="readonly">
                  <?php echo $contents->content_body?>
                  </textarea>
                 <script>
                      CKEDITOR.replace( 'ckeditor' );
				</script>
                  
                </div>
              </div>
               
            </div>
          </div>
        </div>
      </div>
      </div>
      </div>
    </div>
  </div>
  </div>
</section>
<?php $this->append('bottom-script');?>

<?php $this->end(); ?>