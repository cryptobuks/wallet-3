<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('page'); ?> - <?php echo e(setting('site.site_name')); ?></title>

    <!-- Styles -->
    <!-- Fonts -->
    

    <!-- Styles -->
    
    
   

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/jquery-jvectormap-2.0.3.min.css')); ?>"/>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/morris.min.css')); ?>" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/ecommerce.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/color_skins.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap-select.min.css')); ?>">
    

    <style type="text/css">
    .jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}
    .jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
    .bitcoin .body {position: absolute;word-break: break-all;}
    .remove{cursor: pointer;}
    </style>


    <?php echo $__env->make('partials.footerstyles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script src="<?php echo e(asset('js/vue.min.js')); ?>"></script>
    
</head>
<body class="theme-green menu_dark" id="app">
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="<?php echo e(asset('assets/images/logo.svg')); ?>" width="48" height="48" alt="sQuare"></div>
        <p>Please wait...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
<?php echo $__env->make('layouts.topnavbar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('layouts.aside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<section class="content">
            <div class="container">
                <?php if(auth()->guard()->check()): ?>
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong><?php echo e(__('Active')); ?></strong> <?php echo e(__('Wallet')); ?></h2>
                                <ul class="header-dropdown">
                                    <?php if(count(\App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get())): ?>
                                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                        <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                                            <?php $__currentLoopData = \App\Models\Currency::where('id', '!=', Auth::user()->currentCurrency()->id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                               <li>
                                                <a href="<?php echo e(url('/')); ?>/wallet/<?php echo e($currency->id); ?>"><span> <?php echo e($currency->name); ?></span></a>
                                                </li> 
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </li>
                                    <?php endif; ?>
                                    <li class="remove">
                                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="body block-header">
                                <div class="row">
                                    <div class="col">
                                        <h2><?php echo e(Auth::user()->currentCurrency()->name); ?> </h2>
                                        <ul class="breadcrumb p-l-0 p-b-0 ">
                                            <li class="breadcrumb-item"><a href="<?php echo e(url('/')); ?>"><i class="icon-home"></i></a></li>
                                            <li class="breadcrumb-item ">
                                                <span class="text-primary"><?php echo e(Auth::user()->currentCurrency()->code); ?> (<?php echo e(Auth::user()->currentCurrency()->symbol); ?>)</span>
                                            </li>
                                        </ul>
                                    </div>            
                                    <div class="col text-right">
                                       <a href="<?php echo e(route('add.credit')); ?>" class="btn btn-primary btn-round  float-right  m-l-10"><?php echo e(__('Add Funds')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row clearfix">
                   <?php if(count(Auth::user()->wallets())): ?>
                        <?php $__currentLoopData = Auth::user()->wallets(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $someWallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col hidden-xs hidden-sm">
                            <div class="card info-box-2">
                                <div class="header" style="padding-bottom: 0">
                                    <h2><strong><?php echo e($someWallet->currency->name); ?></strong> <?php echo e(__('Balance')); ?></h2>
                                    <ul class="header-dropdown">
                                        <li class="remove">
                                            <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body" style="padding-top: 0">
                                    <div class="content">
                                        <div class="number"><?php echo e(\App\Helpers\Money::instance()->value($someWallet->amount, $someWallet->currency->symbol)); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>

                
            </div>

      <!-- Scripts -->
    <?php echo $__env->yieldContent('footer'); ?>
</section>
    <!-- Jquery Core Js --> 
    <script src="<?php echo e(asset('assets/js/libscripts.bundle.js')); ?>"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
    <script src="<?php echo e(asset('assets/js/vendorscripts.bundle.js')); ?>"></script> <!-- slimscroll, waves Scripts Plugin Js -->

    <script src="<?php echo e(asset('assets/js/morrisscripts.bundle.js')); ?>"></script><!-- Morris Plugin Js -->
    <script src="<?php echo e(asset('assets/js/jvectormap.bundle.js')); ?>"></script> <!-- JVectorMap Plugin Js -->
    <script src="<?php echo e(asset('assets/js/knob.bundle.js')); ?>"></script> <!-- Jquery Knob-->

    <script src="<?php echo e(asset('assets/js/mainscripts.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/infobox-1.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/index.js')); ?>"></script>

    <?php echo $__env->yieldContent('js'); ?>
    
</body>
</html>
