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
        <h3 class="card-title"><b>Requests</b></h3>
      </div>
      <ul class="list-group list-group-flush">
        <?php if(\Auth::user()->requests->count()==0): ?>
          <li class="list-group-item">
            <small class="text-muted">
              You don't have sent any request yet
            </small>
          </li>
        <?php endif; ?>
      <?php $__currentLoopData = \Auth::user()->requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="list-group-item">
          <div class="d-flex justify-content-between align-items-center">
            <div>
               You sent a request to join the
               <a href="/events/<?php echo e($request->game->id); ?>">event</a>
               <br>
               <small class="text-muted">
                 <?php echo e(\Carbon\Carbon::parse($request->created_at)->diffforhumans()); ?>

               </small>
            </div>
            <?php if($request->state==0): ?>
              <span class="tag">Pending</span>
            <?php elseif($request->state==1): ?>
              <span class="tag tag-green">Accepted</span>
            <?php elseif($request->state==2): ?>
              <span class="tag tag-red">Rejected</span>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>

  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>