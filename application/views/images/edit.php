<link href="/assets/styles/images/list.css" rel="stylesheet"/>
<div class="maincontent">
	<div class="content">
		<div class="row text-left">
			<?php echo $error;?>
			 <?php echo validation_errors(); ?>
			<?php echo form_open_multipart('/images/add');?>
				  <div class="form-group">
				    <label for="imagefile">Image to Upload</label>
				    <input type="file" name="image" id="image" accept=".gif,.GIF,.png,.PNG,.JPG,.jpg" />
				  </div>
				  <div class="form-group">
				    <label for="smscontent">Sms Content:</label>
				    <textarea  class="form-control" id="smscontent" name="smscontent"></textarea> 
				  </div>

					<input type="submit" value="upload" />

			</form>
		</div>
	</div>
</div>