<div class="card-columns">
<?php $__currentLoopData = $players; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <div class="card">
        <div class="card-body d-flex flex-column">
          <div class="d-flex align-items-center mt-auto">
            <div class="avatar avatar-md mr-3" style="background-image: url(<?php echo e($player->photo); ?>)"></div>
            <div>
              <a href="#" class="text-default"><?php echo e($player->name); ?></a>
              <small class="d-block text-muted"><?php echo e(\Carbon\Carbon::parse($player->created_at)->diffforhumans()); ?></small>
            </div>
          </div>
        </div>
        <?php if($player->location OR $player->sports->count()>0): ?>
          <div class="card-footer">
            <div class="text-muted"><i class="fe fe-map-pin"></i>  <?php echo e($player->location); ?></div>
            <div class="mt-2">
            <?php $__currentLoopData = $player->sports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sport): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <span class="tag"><?php echo e($sport->name); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php echo e($players->links()); ?>

