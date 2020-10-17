<table style="width:100%;">
  <tr>
    <td class="full-none" style="width:90%;font-family:times;letter-spacing:.1;text-align:center;">
     
      <p>User List</p>
    </td>
  </tr>
</table>
<br/><br/>
<table cellpadding="3" border="1" style="font-size: 10px">
  <thead>
    <tr>
     <th>Name</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
	<?php foreach($details as $val){ ?>
    <tr>
      <td>
        <?= $val->name ?>
      </td>
      <td>
        <?= $val->email ?>
      </td>
    </tr>
	<?php } ?>
  </tbody>
</table>





