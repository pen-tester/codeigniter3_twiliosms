<link href="/assets/styles/images/list.css" rel="stylesheet"/>
<div class="maincontent">
	<div class="content">
		<div class="row text-left">
			 <?php echo validation_errors(); ?>
			<?php echo form_open('/smstype/add');?>
				  <div class="form-group">
				    <label for="name">Name</label>
				    <input type="text" name="name" id="name" />
				  </div>
				  <div class="form-group">
				    <label for="count">Number of Sms:</label>
				    <input type="number" name="count" id="count" />
				  </div>
				  <div class="form-group">
				    <label for="price">Price:</label>
				    <input type="number" step="0.01" name="price" id="price" />
				  </div>
					<input type="submit" value="Add" />

			</form>
		</div>
	</div>
</div>