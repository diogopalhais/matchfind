<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Match Find</title>
        <link href="css/dashboard.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <style>
            html, body {
                color: #636b6f;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
                align-items: center;
            }


            .title {
                font-size: 80px;
            }

            .title-sm {
                font-size: 40px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 10px;
                font-size: 15px;
                font-weight: 600;
            }

            .m-b-md {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <?php if(Route::has('login')): ?>
                <div class="top-right links">
                    <?php if(Auth::check()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>">Home</a>
                    <?php else: ?>
                        <a href="<?php echo e(url('/login')); ?>">LOGIN</a>
                        <a href="<?php echo e(url('/register')); ?>">REGISTER</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="content flex-column justify-content-between">

                <div class="d-none d-sm-flex title m-b-md header-brand align-items-center">
                  <span style="background:#3742fa" class="avatar avatar-xxl"></span>
                   &nbsp;match<span class="text-muted">find</span>
                   <sup><small style="font-size:20px" class="text-muted"> &nbsp; beta</small></sup>
                </div>

                <div class="d-block d-sm-none title-sm m-b-md header-brand align-items-center">
                  <span style="background:#3742fa" class="avatar avatar-l"></span>
                   &nbsp;match<span class="text-muted">find</span>
                   <sup><small style="font-size:15px" class="text-muted"> &nbsp; beta</small></sup>
                </div>

                <p style="font-weight:400" class="d-none d-sm-block text-muted lead">Find sport events to attend, and players for your event.</p>
                <p style="font-weight:400" class="d-block d-sm-none text-muted mr-7 ml-7">Find sport events to attend, and players for your event.</p>

                <div class="fixed-bottom links mb-4">
                  Developed by<a href="http://twitter.com/diogopalhais" target="_blank">@diogopalhais</a>
                </div>

            </div>
        </div>
    </body>
</html>
