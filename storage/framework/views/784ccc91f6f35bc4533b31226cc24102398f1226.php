<?php $__env->startSection('content'); ?>


        <div class="container">
          <div class="row">
            <div class="col col-login mx-auto">
              <div class="text-center mb-6">
                <span style="background:#3742fa" class="avatar"></span>
              </div>
              <form class="card" method="POST" action="<?php echo e(route('login')); ?>">
                  <?php echo e(csrf_field()); ?>

                <div class="card-body p-6">
                  <div class="card-title">Login to your account</div>
                  <div class="form-group">
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <?php if($errors->has('email')): ?>
                        <span class="invalid-feedback">
                            <?php echo e($errors->first('email')); ?>

                        </span>
                    <?php endif; ?>
                  </div>
                  <div class="form-group">
                    <label class="form-label">
                      Password
                    </label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    <?php if($errors->has('password')): ?>
                        <span class="help-block">
                            <strong><?php echo e($errors->first('password')); ?></strong>
                        </span>
                    <?php endif; ?>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                  </div>
                </div>
              </form>
              <div class="text-center text-muted">
                Don't have account yet? <a href="/register">Sign up</a>
              </div>
            </div>
          </div>
        </div>

        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>