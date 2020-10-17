<?php 

$this->append('bottom-style');?>

<?php $this->end(); ?>
<div class="top-content">          
    <div class="final-registers">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text">
              <h3>Registration</h3>
              <div class="description">
                <?= $this->Flash->render(); ?>
                <?= $this->Flash->render('auth'); ?>
              </div>
            </div>
          </div>
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
            <div class="row">
              
				   <div class="row">
					<div class="col-md-12 firstrow1">
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
                        <td><?php echo $records->article->name ?></td>
                        <td><?php echo $this->Text->truncate($records->content_body,50,['ellipsis' => '...','exact' =>false]
                        ); ?></td>
                        

                        <td class="actions">
                        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $records->id],['class' => 'btn btn-info btn-xs', 'title' => __('View'), 'escape' => false]) ?>
                        <?php
                        if($records->article->created_by == $user_id){?>
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
				 </div>
				<div class="clearfix"></div>
			 
          <div class="clearfix"></div>
		  <br>
          <div class="col-sm-12 text-center btnsubmit"> <br>
		  <input type="submit" class="btn btn-warning" data-save="SAVE" value="Save">
          
            <!-- <button type="button" id="cancel" class="btn">Cancel</button>  -->
          </div>
          <div class="clearfix"></div>

            </div>            
        </div>
    </div>    
</div>

<?php $this->append('bottom-script');?>


<?php $this->end(); ?>