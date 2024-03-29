        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800"><?= $title ?></h1>
          <div class="row">
          	<div class="col-lg-6">
          		<?php echo $this->session->flashdata('message'); ?>
          		<form action="<?= base_url('user/changepassword'); ?>" method="post">
					<div class="form-group">
						<label for="current_password">Current password</label>
						<input type="password" class="form-control" id="current_password" name="current_password">
						<?php echo form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
					<div class="form-group">
						<label for="newpassword1">New Password</label>
						<input type="password" class="form-control" id="newpassword1" name="newpassword1">
						<?php echo form_error('newpassword1', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>
					<div class="form-group">
						<label for="newpassword2">Repeat password</label>
						<input type="password" class="form-control" id="newpassword2" name="newpassword2">
						<?php echo form_error('newpassword2', '<small class="text-danger pl-3">', '</small>'); ?>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary">Change password</button>
					</div>
          		</form>
          	</div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->