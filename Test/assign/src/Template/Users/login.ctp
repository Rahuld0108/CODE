
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
.login-bg{
	margin-left: 20%;
    margin-right: 35%;
}
.table tr{ boder:1px solid black}
</style>
<div class="login-bg">
  <div id="login" style="width:800px !important;">
    <div id="login-column" >      
      <div id="login-box" data-aos="fade-right">        
        <?= $this->Form->create($user,['id' => 'login-formk','autocomplete'=>'off']); ?>
        <h3 class="text-info">Login</h3>
        <?= $this->Flash->render(); ?>
		<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<?=$this->Form->control('email',['required'=>true,'placeholder'=>'Email ','label'=>'Email']);?>
			</div>
			<div class="col-md-6">
				<?=$this->Form->control('password',['required'=>true,'placeholder'=>'Pasword','type'=>'password']);?>
			</div>
		</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				  <div class="col-md-6" >
				   <input type="submit" class="btn btn-warning" data-save="SAVE" value="Login">  
				</div>      
			</div>      
        </div>      
        <?= $this->Form->end();?>
		<br>
		<br>
		
		<div class="row">
			<div class="col-md-12">
				  <div class="col-md-6" >
				  <?= $this->Html->link('<h3>Registration</h3>', ['controller'=>'users','action' => 'registration'],['class' => 'btn btn-successs', 'title' => __('Registration'), 'escape' => false]) ?>
				 
				</div>      
			</div>      
        </div>  
			<br>
		<br>
		<div class="col-md-12">
		<table class="table table-hover">
				<thead>
				<tr>
				<th scope="col" style="width:10%"><?= $this->Paginator->sort('Sr. No.') ?></th>
				<th scope="col" style="width:30%"><?= $this->Paginator->sort('Article Name') ?></th>
				<th scope="col" style="width:20%"><?= $this->Paginator->sort('Article Tag') ?></th>
				<th scope="col" style="width:30%"><?= $this->Paginator->sort('Content') ?></th>
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
				<td><?php echo $records['article']['tag'] ?></td>
				<td><?php echo $this->Text->truncate($records['content_body'],50,['ellipsis' => '...','exact' =>false]
				); ?>
				</td>
				<td class="actions">
				<?= $this->Html->link('<i class="fa fa-edit"></i>', ['controller'=>'comments','action' => 'viewContent', $records['id']],['class' => 'btn btn-info btn-xs', 'title' => __('Add Comments'), 'escape' => false]) ?> | <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller'=>'comments','action' => 'viewComments', $records['id']],['class' => 'btn btn-info btn-xs', 'title' => __('View All Comments'), 'escape' => false]) ?>
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
    </div>
  </div>
</div>

<?php $this->append('bottom-script');?>

<?php $this->end();?>