<?php $__env->startSection('content'); ?>

  <div class="container">

      <div class="page-header">
              <h1 class="page-title">
                Home
              </h1>
            </div>

      <div class="row">

        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
              <div class="card-body p-6 text-center">
                <div class="h1 m-0"><?php echo e(\App\Game::count()); ?></div>
                <div class="text-muted">Games</div>
              </div>
            </div>
          </div>
          <div class="col-6 col-sm-4 col-lg-2">
              <div class="card">
                <div class="card-body p-6 text-center">
                  <div class="h1 m-0"><?php echo e(\App\User::count()); ?></div>
                  <div class="text-muted">Players</div>
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-6 text-center">
                    <div class="h1 m-0"><?php echo e(\Auth::user()->requests->count()); ?></div>
                    <div class="text-muted">Requests</div>
                  </div>
                </div>
              </div>

      </div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>