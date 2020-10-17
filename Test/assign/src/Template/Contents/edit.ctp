 <script src="https://cdn.ckeditor.com/4.5.11/standard/ckeditor.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<?php
  $this->assign('title',__('Update Content'));
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
          <?= __("Update Content") ?>
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
      <?php echo $this->Form->create($contents,['id' => 'mpr-add-frm','type'=>'file']); ?>
      <div class="box-body">
        <div class="">
          <div class="row">
            <div class="col-md-12 firstrow">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fs11">Article<sup class="red">*</sup></label>
                  <?=  $this->Form->input('article_name',['label' =>false,"id"=> "article_id",'required'=>true,'class'=>'form-control','readonly','value'=>$contents->article->name]); ?>
                </div> 
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="fs11">Body<sup class="red">*</sup></label>
                  <?=  $this->Form->input('content_body',['type'=>'textarea','label' =>false,"id"=> "ckeditor",'required'=>true,'class'=>'form-control']); ?>
                 <script>
                      CKEDITOR.replace( 'ckeditor' );
				</script>
                  
                </div>
              </div>
               <div class="col-md-12">
                <div class="form-group">
                  <label class="fs11">Previous Uploaded Image</label></br>
                    <?php if(!empty($contents->content_images)) {?>
                      <?php foreach($contents->content_images as $v) {?>
                       
                        <div class="col-md-4">
                        <img style="width:130px;" src="<?= $this->Url->build('/uploads/'. $v->photos)?>">
                        <button name="uploadPayment" type="button" data-file="photos" data-id="<?php echo $v->id?>" class="btn btn-primary btn-green deletefile"><i class="fa fa-trash"></i></button>
                        </div>
                        <?php } ?>
                      <?php }?>
                </div> 
              </div>
               <div class="col-md-12">
                  <div class="form-group">
                  
                      <?=  $this->Form->input('photos[]',['type'=>'file','multiple','label' =>false,"id"=> "article_id",'class'=>'form-control']); ?>
                  </div>
              </div>
          
          <div class="row">
            <div class="col-sm-12 text-center btnsubmit"> <br>
              <button type="submit" id="chkmpr" class="btn btn-primary btn-green" data-save="SAVE">Update</button>
            </div>
          </div>
          
          <?= $this->Form->end(); ?>
        </div>
      </div>
      </div>
      </div>
    </div>
  </div>
  </div>
</section>
<?php $this->append('bottom-script');?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  (function($){
      $(document).ready(function(){
          if(typeof $.validator !== "undefined"){
              $("#mpr-add-frm").validate();
          }
      });
  })($);
$(document).ready(function(){
var baseUrl = "<?php echo $this->Url->build('/', true);?>"

$(".deletefile").on("click",function(e) {
e.preventDefault();
var id   = $(this).attr('data-id');

$.ajax({
type:'GET',
cache: false,
url: baseUrl + 'contents/deleteImage',
data: {
id : id
},
success: function(response) {
 location.reload();
}
});
});
});
</script>
<?php $this->end(); ?>