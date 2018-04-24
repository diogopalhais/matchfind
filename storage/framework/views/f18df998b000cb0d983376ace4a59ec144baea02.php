<?php $__env->startSection('content'); ?>

        <div class="container">
          <div class="row">
              <div class="col col-login mx-auto">
                <div class="text-center mb-6">
                  <span style="background:#3742fa" class="avatar"></span>
                </div>
                <form class="card" action="<?php echo e(route('register')); ?>" method="post">
                    <?php echo e(csrf_field()); ?>

                  <div class="card-body p-6">
                    <div class="card-title">Create new account</div>
                    <div class="form-group">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control <?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" placeholder="Enter name">
                      <?php if($errors->has('name')): ?>
                          <span class="invalid-feedback">
                              <?php echo e($errors->first('name')); ?>

                          </span>
                      <?php endif; ?>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Email address</label>
                      <input type="email" name="email" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="Enter email">
                      <?php if($errors->has('email')): ?>
                          <span class="invalid-feedback">
                              <?php echo e($errors->first('email')); ?>

                          </span>
                      <?php endif; ?>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Password</label>
                      <input type="password" name="password" class="form-control <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" placeholder="Password">
                      <?php if($errors->has('password')): ?>
                          <span class="invalid-feedback">
                              <?php echo e($errors->first('password')); ?>

                          </span>
                      <?php endif; ?>
                    </div>
                    <div class="form-group">
                      <label class="form-label">Password Confirmation</label>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary btn-block">Create new account</button>
                    </div>
                  </div>
                </form>
                <div class="text-center text-muted">
                  Already have account? <a href="/login">Sign in</a>
                </div>
              </div>
            </div>
        </div>

      <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>