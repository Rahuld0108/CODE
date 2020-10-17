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
              <?= $this->Form->create('user',['id'=>'regis','class' => 'form-inline','autocomplete'=>'off']); ?>
				   <div class="row">
					<div class="col-md-12 firstrow1">
						<div class="col-md-4">
						<div class="form-group">
						<label class="fs11">Name<sup class="red">*</sup></label>
					   <?php echo $this->Form->input('name', ['data-validcheck'=>'#name',"id"=> "name",'class'=>'form-control','type'=>'text','label'=>false,'placeholder'=>'Enter Name']);?>
					   <label id="name-error" class="error-message" for="name" style="display: none;">This field is required.</label>
						</div>
						</div>
					
					<div class="col-md-4">
						<div class="form-group">
						<label class="fs11">Email</label>	
						<?=  $this->Form->control('email',['data-validcheck'=>'#email','label' =>false,'class'=>'form-control','type'=>'email','placeholder'=>'Enter Email Id']); ?>
						<label id="email-error" class="error-message" for="email" style="display: none;">This field is required.</label>
						</div>
					</div>
					<div class="col-md-4">
					<div class="form-group">
						<label class="fs11">Password <sup class="red">*</sup></label>
					   <?php echo $this->Form->input('password', ['data-validcheck'=>'#password',"id"=> "password",'title'=>'Password','class'=>'form-control','type'=>'password','label'=>false,'placeholder'=>'Enter Password']);?>
					   <label id="password-error" class="error-message" for="password" style="display: none;">This field is required.</label>
						</div>
						</div>
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

                <?= $this->Form->end(); ?>
            </div>            
        </div>
    </div>    
</div>

<?php $this->append('bottom-script');?>

<script type="text/javascript">
$(document).ready(function () {	
    $('#regis').validate();
});
 
$(document).on('change blur', '[data-validcheck]', function(){
    if ($(this).val() != null || $(this).val() != "") {
        $($(this).data('validcheck')+'-error').css('display','none');
    }
    if ($(this).val() == null || $(this).val() == "") {
        $($(this).data('validcheck')+'-error').css('display','block');
    }
});

$(document).on('click', '[data-save]', function(e){
	
  
  $("[data-validcheck]").each(function(i,h) {
	var getid = $(this).data('validcheck');
  
    if ($(this).val() == null || $(this).val() == "") {
        $(getid+'-error').css('display','block');
        e.preventDefault();
     }
    else{
  return true

    }
  });
});
</script>
<?php $this->end(); ?>