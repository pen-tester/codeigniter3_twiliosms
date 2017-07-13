<link href="/assets/styles/images/list.css" rel="stylesheet"/>
<div class="maincontent">
	<div class="content">
		<div class="row text-center">
		   <table class="table table-striped text-left">
		    <thead>
		      <tr>
		        <th>Id</th>
		        <th>Gif image</th>
		        <th>Sms</th>
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
		        <td><img src ="<?php echo("/assets/images/gifs/".$image["filename"]); ?>"></td>
		        <td><?php echo($image["sms"]); ?></td> 
		        <td><a href="<?php echo("/images/delete/".$image["id"])?>"><i class="fa fa-trash" aria-hidden="true"></i>

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