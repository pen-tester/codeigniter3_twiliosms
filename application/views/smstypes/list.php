<link href="/assets/styles/images/list.css" rel="stylesheet"/>
<div class="maincontent">
	<div class="content">
		<div class="row text-center">
		   <table class="table table-striped text-left">
		    <thead>
		      <tr>
		        <th>Id</th>
		        <th>Name</th>
		        <th>Number of Sms</th>
		        <th>Price</th>
		        <th>Actions</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php
		    	$index=0;
		       foreach ($images as $image) {
		       	 $index++;
		    ?>

		      <tr>
		        <td><?php echo($index); ?></td>
		        <td><?php echo($image["name"]); ?></td>
		        <td><?php echo($image["count"]); ?></td> 
		        <td><?php echo($image["price"]); ?></td> 
		        <td><a href="<?php echo("/smstype/delete/".$image["id"])?>"><i class="fa fa-trash" aria-hidden="true"></i>

</a></td>		        
		      </tr>
		     <?php
		     	}
		     ?>
		    </tbody>
		  </table>
		</div>
	</div>
</div>