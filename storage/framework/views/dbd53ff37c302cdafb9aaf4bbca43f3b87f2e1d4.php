<?php $__env->startSection('content'); ?>

  <div class="container">

    <h1 class="page-title mb-5">Players</h1>

    <div id="players">
        <?php echo $__env->make('partials.players', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

  </div>

  <input type="hidden" value="2" id="page">


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>