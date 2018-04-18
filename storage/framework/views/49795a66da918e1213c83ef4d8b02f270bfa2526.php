<?php $__env->startSection('content'); ?>

  <div class="container">

    <?php if(Session::has('success')): ?>
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"></button>
        <i class="fe fe-check mr-2" aria-hidden="true"></i> <?php echo e(Session::get('success')); ?>

      </div>
    <?php endif; ?>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><b>Invite Players</b></h3>
      </div>

    <div class="list-group list-group-flush">
      <?php if($players->count()==0): ?>
        <li class="list-group-item">
          <small class="text-muted">
            No players available for now
          </small>
        </li>
      <?php endif; ?>
    <?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

          <div class="list-group-item">

            <div class="d-flex justify-content-between align-items-center">
              <div class="d-flex flex-column">
                <div class="d-flex align-items-center mt-auto">
                  <div class="avatar avatar-md mr-3" style="background-image: url(<?php echo e($player->photo); ?>)"></div>
                  <div>
                    <a href="/player/<?php echo e($player->id); ?>" class="text-default"><b><?php echo e($player->name); ?></b></a>
                    <small class="d-block text-muted"><?php echo e($player->location); ?></small>
                    <div class="mt-1">
                    <?php $__currentLoopData = $player->sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <span class="tag"><?php echo e($sport->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  </div>
                </div>
              </div>
              <a href="/events/<?php echo e($game->id); ?>/invite/<?php echo e($player->id); ?>" class="btn btn-primary">Invite</a>
            </div>
          </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php echo e($players->links()); ?>


  </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>