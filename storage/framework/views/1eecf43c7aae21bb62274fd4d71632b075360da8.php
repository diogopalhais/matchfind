<div class="card-columns">
<?php $__currentLoopData = $games; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $game): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


  <div href="/games/<?php echo e($game->id); ?>" class="card card-game">
    <div class="card-body">

      <h5 class="card-subtitle mb-2 text-muted">
        <span class="badge badge-primary"><?php echo e($game->sport->name); ?></span>
      </h5>

      <h5 class="card-title"><?php echo e($game->title); ?></h5>

      <h6 class="card-subtitle mb-2 text-muted">
        <?php echo e(\Carbon\Carbon::parse($game->date)->format('d M')); ?>

        •
        <?php echo e(\Carbon\Carbon::parse($game->time_start)->format('H:i')); ?>-<?php echo e(\Carbon\Carbon::parse($game->time_end)->format('H:i')); ?>

      </h6>

      <p class="card-text card-divider">
        <small class="sub-header">
          <i class="fa fa-info"></i>
          INFO
        </small>
        <?php echo e($game->description); ?>

      </p>

      <p class="card-text card-divider">
        <small class="sub-header">
          <i class="fa fa-map-marker"></i>
          LOCATION
        </small>
        <?php echo e($game->local); ?>

      </p>

      <p class="card-text card-divider">
        <small class="sub-header">
          <i class="fa fa-user"></i>
          CREATED BY
        </small>
        <?php echo e($game->user->name); ?>

      </p>

      <a href="/games/<?php echo e($game->id); ?>" class="btn btn-outline-primary w-100">View Details</a>
    </div>
  </div>


<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php echo e($games->links()); ?>

