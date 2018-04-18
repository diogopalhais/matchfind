<?php $__env->startSection('content'); ?>

  <div class="container">


    <div class="row">
              <div class="col-md-3">
                <h3 class="page-title mb-5">Event</h3>
                <?php if(\Auth::user()->id != $game->user->id): ?>
                    <?php if($game->players->where('user_id',\Auth::user()->id)->count()==0): ?>
                      <a href="/events/<?php echo e($game->id); ?>/join" class="btn btn-primary btn-block mb-6"><i class="fe fe-send"></i> &nbsp; Request to Join</a>
                    <?php else: ?>
                      <?php if($game->players->where('user_id',\Auth::user()->id)->first()): ?>
                        <?php if($game->players->where('user_id',\Auth::user()->id)->first()->state==0): ?>
                          <div class="btn btn-azure btn-block mb-6 " >Waiting for Response</div>
                        <?php elseif($game->players->where('user_id',\Auth::user()->id)->first()->state==1): ?>
                            <div class="btn btn-green btn-block mb-6 " >Attending</div>
                          <?php elseif($game->players->where('user_id',\Auth::user()->id)->first()->state==2): ?>
                              <div class="btn btn-red btn-block mb-6 " >Rejected</div>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                  <a href="/events/<?php echo e($game->id); ?>/invite" class="btn btn-block btn-primary mb-6"><i class="fe fe-user-plus"></i> &nbsp; Invite Players</a>
                <?php endif; ?>
                <div>

                  <div class="list-group list-group-transparent mb-6" id="myTab" role="tablist">
                      <a class="list-group-item list-group-item-action d-flex align-items-center" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        <span class="icon mr-3">
                          <i class="fe fe-chevron-right"></i></span>
                          <small><b>ATTENDING</b></small>
                          <span class="ml-auto avatar avatar-green"><?php echo e($game->attending->count() + $game->num_players_confirmed); ?></span>
                      </a>
                      <a class="list-group-item list-group-item-action d-flex align-items-center" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
                        <span class="icon mr-3">
                          <i class="fe fe-chevron-right"></i></span>
                          <small><b>REJECTED</b></small>
                          <span class="ml-auto avatar avatar-red"><?php echo e($game->players->where('state',2)->count()); ?></span>
                      </a>
                      <a class="list-group-item list-group-item-action d-flex align-items-center" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                        <span class="icon mr-3">
                        <i class="fe fe-chevron-right"></i></span>
                        <small><b>PENDING</b></small>
                        <span class="ml-auto avatar avatar-cyan"><?php echo e($game->players->where('state',0)->count()); ?></span>
                      </a>

                  </div>

                </div>
              </div>
              <div class="col-md-9">

                <?php if(Session::has('success')): ?>
                	<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"></button>
                    <i class="fe fe-check mr-2" aria-hidden="true"></i> <?php echo e(Session::get('success')); ?>

                  </div>
                <?php endif; ?>

                <div class="card">

                  <div class="card-header">
                    <h3 class="card-title"><b>Event Details</b></h3>
                    <?php if($game->user->id == \Auth::user()->id): ?>
                      <div class="card-options">
                        <a href="/events/<?php echo e($game->id); ?>/edit" class="btn btn-secondary btn-sm ml-2"><i class="fe fe-edit mr-2"></i>Edit</a>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="list-group list-group-flush">

                    <div class="list-group-item">
                      <div class="d-flex justify-content-start">
                        <div style="background:#f8f9fa;border:none" class="card mb-0 col-sm-4 col-md-4 col-lg-3 col-xl-2 d-none d-sm-flex mr-4">
                          <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                            <div class="text-muted"><?php echo e(\Carbon\Carbon::parse($game->date)->format('D')); ?></div>
                            <div class="h1 m-0"><?php echo e(\Carbon\Carbon::parse($game->date)->format('d')); ?></div>
                            <div class="text-muted"><?php echo e(\Carbon\Carbon::parse($game->date)->format('M y')); ?></div>
                          </div>
                        </div>
                        <div class="col-sm-8 col-md-8 col-lg-9 col-xl-10 col-xs-12 flex-column">
                          <div class="d-flex justify-content-between">
                            <h3 class="card-title mb-1"><?php echo e($game->title); ?></h3>
                            <span class="tag mt-1"><?php echo e($game->sport->name); ?></span>
                          </div>
                          <div class="text-muted"><i class="fe fe-clock"></i>   <?php echo e(\Carbon\Carbon::parse($game->time_start)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($game->time_end)->format('H:i')); ?>

                          &nbsp;  • &nbsp; <i class="fe fe-dollar-sign"></i><?php echo e($game->cost); ?> per player</div>
                          <div class="text-muted d-sm-none d-flex"><i class="fe fe-calendar"></i> &nbsp;  <?php echo e(\Carbon\Carbon::parse($game->date)->format('D, d M y')); ?></div>
                          <div class="text-muted"><i class="fe fe-map-pin"></i>  <?php echo e($game->local); ?></div>
                          <div class=" d-flex justify-content-start mt-3">
                            <div class="d-flex flex-column align-items-center">
                              <span class="avatar avatar-green"><?php echo e($game->attending->count() + $game->num_players_confirmed); ?></span>
                              <small style="font-size:10px" class="text-muted"><b>ATTENDING</b></small>
                            </div>
                            <div class="d-flex flex-column align-items-center ml-3">
                              <span class="avatar avatar-gray"><?php echo e($game->num_players  - ($game->attending->count() + $game->num_players_confirmed)); ?></span>
                              <small style="font-size:10px" class="text-muted"><b>SPOTS LEFT</b></small>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

              </div>

              <div class="card-body">

                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h4 style="color: #6e7687;" class="card-title">
                      <span class="status-icon bg-success"></span>
                      <b>Players Attending</b>
                    </h4>
                    <ul class="list-group mt-2">

                        <li class="list-group-item">
                          <div class="d-flex justify-content-between align-items-center">
                            <span>
                              <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mt-auto">
                                  <div class="avatar avatar-md mr-3" style="background-image: url(<?php echo e($game->photo); ?>)"></div>
                                  <div>
                                    <a href="/player/<?php echo e($game->user->id); ?>" class="text-default"><b><?php echo e($game->user->name); ?></b></a> + <?php echo e($game->num_players_confirmed -1); ?>

                                    <?php if($game->user->location): ?>
                                      <small class="d-block text-muted"><?php echo e($game->user->location); ?></small>
                                    <?php endif; ?>
                                  </div>
                                </div>
                              </div>
                            </span>
                            <div >
                              <div class="tag">Owner</div>
                          </div>
                        </div>
                        </li>

                        <?php $__currentLoopData = $game->players->where('state',1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                              <span>
                                <div class="d-flex flex-column">
                                  <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar avatar-md mr-3" style="background-image: url(<?php echo e($player->photo); ?>)"></div>
                                    <div>
                                      <a href="/player/<?php echo e($player->user->id); ?>" class="text-default"><b><?php echo e($player->user->name); ?></b></a>
                                      <?php if($player->user->location): ?>
                                        <small class="d-block text-muted"><?php echo e($player->user->location); ?></small>
                                      <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                              </span>
                              <?php if(\Auth::user()->id == $game->user->id): ?>
                                <div class="dropdown">
                                  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                     Manage
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/events/<?php echo e($game->id); ?>/player/<?php echo e($player->id); ?>/reject">Reject</a>
                                  </div>
                                </div>
                              <?php endif; ?>
                          </div>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                  </div>
                  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <h3 style="color: #6e7687;" class="card-title">
                        <span class="status-icon bg-danger"></span>
                        <b>Players Rejected</b></h3>
                      <ul class="list-group mt-2">
                        <?php if($game->players->where('state',2)->count()==0): ?>
                         <li class="list-group-item">
                          <small class="text-muted">No players rejected</small>
                         </li>
                        <?php endif; ?>
                        <?php $__currentLoopData = $game->players->where('state',2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                              <span>
                                <div class="d-flex flex-column">
                                  <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar avatar-md mr-3" style="background-image: url(<?php echo e($player->photo); ?>)"></div>
                                    <div>
                                      <a href="/player/<?php echo e($player->user->id); ?>" class="text-default"><b><?php echo e($player->user->name); ?></b></a>
                                      <?php if($player->user->location): ?>
                                        <small class="d-block text-muted"><?php echo e($player->user->location); ?></small>
                                      <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                              </span>
                              <?php if(\Auth::user()->id == $game->user->id): ?>
                                <div class="dropdown">
                                  <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                     Manage
                                  </button>
                                  <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/events/<?php echo e($game->id); ?>/player/<?php echo e($player->id); ?>/accept">Accept</a>
                                  </div>
                              </div>
                              <?php endif; ?>
                            </div>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                  </div>
                  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <h3 style="color: #6e7687;" class="card-title">
                      <span class="status-icon bg-teal"></span>
                      <b>Players Pending</b></h3>
                    <ul class="list-group mt-2">
                        <?php if($game->players->where('state',0)->count()==0): ?>
                         <li class="list-group-item">
                          <small class="text-muted">No players pending</small>
                         </li>
                        <?php endif; ?>
                        <?php $__currentLoopData = $game->players->where('state',0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $player): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                              <span>
                                <div class="d-flex flex-column">
                                  <div class="d-flex align-items-center mt-auto">
                                    <div class="avatar avatar-md mr-3" style="background-image: url(<?php echo e($player->photo); ?>)"></div>
                                    <div>
                                      <a href="/player/<?php echo e($player->user->id); ?>" class="text-default"><b><?php echo e($player->user->name); ?></b></a>
                                      <?php if($player->user->location): ?>
                                        <small class="d-block text-muted"><?php echo e($player->user->location); ?></small>
                                      <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                              </span>
                              <?php if(\Auth::user()->id == $game->user->id): ?>
                                  <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown">
                                       Manage
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="/events/<?php echo e($game->id); ?>/player/<?php echo e($player->id); ?>/accept">Accept</a>
                                      <a class="dropdown-item" href="/events/<?php echo e($game->id); ?>/player/<?php echo e($player->id); ?>/reject">Reject</a>
                                    </div>
                                </div>
                              <?php endif; ?>
                          </div>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     </ul>
                  </div>
                </div>
              </div>
              <?php if($game->players->where('user_id',\Auth::user()->id)->where('state',1)->count()>0 OR $game->user->id == \Auth::user()->id): ?>
              <div class="card-footer">
                <h4 class="card-title"><i class="fe fe-message-circle mr-2"></i><b>Messages</b></h4>
                <div class="card">
                  <div class="card-header p-2">
                    <form class="w-100" action="/events/<?php echo e($game->id); ?>/message/send" method="post">
                      <?php echo e(csrf_field()); ?>

                      <div class="input-group">
                          <input type="text" name="message" class="form-control" placeholder="Message">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                              <i class="fe fe-send"></i>
                            </button>
                          </div>
                        </div>
                    </form>
                  </div>
                  <ul class="list-group card-list-group">
                    <?php if($game->messages->count()==0): ?>
                      <li class="list-group-item">
                        <small>No messages yet</small>
                      </li>
                    <?php endif; ?>
                    <?php $__currentLoopData = $game->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="list-group-item py-5">
                        <div class="media">
                          <div class="media-object avatar avatar-md mr-4" style="background-image: url(<?php echo e($message->user->photo); ?>)"></div>
                          <div class="media-body">
                            <div class="media-heading">
                              <small class="float-right text-muted"><?php echo e(\Carbon\Carbon::parse($message->created_at)->diffforhumans()); ?></small>
                              <h5><?php echo e($message->user->name); ?></h5>
                            </div>
                            <div>
                              <?php echo e($message->message); ?>

                            </div>
                          </div>
                        </div>
                      </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  </ul>
                </div>
              </div>
              <?php endif; ?>

            </div>

          </div>
        </div>




  </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>