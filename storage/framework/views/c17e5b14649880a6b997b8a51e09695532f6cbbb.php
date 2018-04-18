<?php $__env->startSection('content'); ?>

  <div class="container">

    <?php if(Session::has('success')): ?>
    	<div class="alert alert-success"><?php echo e(Session::get('success')); ?></div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><b>Profile</b></h3>
        <div class="card-options">
          <a href="/profile/edit" class="btn btn-secondary btn-sm ml-2"><i class="fe fe-edit mr-2"></i>Edit</a>
        </div>
      </div>
      <div class="card-body">

        <div class="d-flex justify-content-start">

          <span class="avatar avatar-xxl" style="background-image: url(<?php echo e(\Auth::user()->photo); ?>)"></span>

          <div class="ml-4">
            <h3 class="mb-1"><?php echo e(\Auth::user()->name); ?></h3>
            <p class="mb-0"><?php echo e(\Auth::user()->email); ?></p>
            <p class="text-muted"><i class="fe fe-map-pin"></i> <?php echo e(\Auth::user()->location); ?></p>
            <?php $__currentLoopData = \Auth::user()->sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <span class="tag"><?php echo e($sport->name); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

        </div>

      </div>

      </div>
    </div>


  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>