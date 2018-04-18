<?php $__env->startSection('content'); ?>

  <div class="container">

    <h1 class="mb-4" id="title">Profile</h1>


        <p>
          Name:
          <?php echo e(\Auth::user()->name); ?>

        </p>
        <p>
          Email:
          <?php echo e(\Auth::user()->email); ?>

        </p>
        <p>
          <?php echo e(\Auth::user()->location); ?>

        </p>
        <p>
          <?php echo e(\Auth::user()->photo); ?>

        </p>
        <p>
          Sports:
          <?php echo e(\Auth::user()->sports); ?>

        </p>
    



  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>