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
      
        <div class="col-md-12">
        
       <?= $this->Form->create($comments,['id'=>'regis','class' => 'form-inline','autocomplete'=>'off']); ?>
      
            
            <input type="hidden" name="article_id"  id="article_id" value="<?php echo $contents->article->id?>">
            <input type="hidden" name="content_id" id="content_id" value="<?php echo $contents->id?>">
            <input type="hidden" name="tag" id="tag" value="<?php echo $contents->article->tag?>">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="fs11">Article<sup class="red">*</sup></label>
                  <?=  $this->Form->input('name',['label' =>false,"id"=> "name",'readonly','required'=>true,'class'=>'form-control','value'=>$contents->article->name]); ?>
                </div> 
              </div>
              <div class="col-md-12">
               
                  <label class="fs11">Content Body<sup class="red">*</sup></label>
                  <textarea id="ckeditor" class="form-control" readonly="readonly">
                  <?php echo $contents->content_body?>
                  </textarea>
                 <script>
                      CKEDITOR.replace( 'ckeditor' );
				</script>
                
              </div>
              <?php if(!empty($contents->content_images)) {?>             
              <div class="col-md-12">
                <div class="form-group">
                  <label class="fs11">Images</label></br>
                    
                      <?php foreach($contents->content_images as $v) {?>
                       
                        <div class="col-md-4">
                        <img style="width:130px;" src="<?= $this->Url->build('/uploads/'. $v->photos)?>">
                        
                        </div>
                        <?php } ?>
                      
                </div> 
              </div>
          <?php }?>
      </div>
    
    <div class="col-md-12">
    <div class="col-md-6">
                <div class="form-group">
                  <label class="fs11">Name<sup class="red">*</sup></label>
                  <?=  $this->Form->input('comments_by',['label' =>false,"id"=> "comments_by",'required'=>true,'class'=>'form-control']); ?>
                </div> 
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label class="fs11">Comments<sup class="red">*</sup></label>
                  <?=  $this->Form->input('comments_text',['type'=>'textarea','label' =>false,"id"=> "comments_text",'class'=>'form-control']); ?>
                </div> 
              </div> 
               <div class="col-sm-12 text-center btnsubmit"> <br>
		  <input type="submit" class="btn btn-warning" id="add_comment" value="Add Comment">
          </div>
          </div>
  </div>
  </div>
</section>


<?php $this->append('bottom-script');?>
<?php $this->end(); ?>