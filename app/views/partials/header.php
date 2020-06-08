<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo Config::meta('sitename'); ?></title>

    <link rel="shortcut icon" type="image/png" href="<?php echo asset('app/views/assets/img/favicon.png'); ?>"/>
    <script src="<?php echo asset('app/views/assets/js/jquery-3.4.1.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/css/dropzone.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/css/admin.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/fontawesome/css/all.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/css/simple-iconpicker.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/css/sweetalert2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/assets/css/trumbowyg.min.css'); ?>">

    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="viewport" content="width=600">
  </head>
  <body class="<?php echo Auth::guest() ? 'login' : 'admin'; ?> <?php echo str_replace('_', '-',
      Config::app('language')); ?>">

      <?php echo Notify::read(); ?>

    <header class="top">
      <div class="wrap">
          <?php if (Auth::user()): ?>
            <nav>
                <ul>
                    <li class="logo">
                        <?php $page = 'marquee-reservation'; ?>
                        <a href="<?php echo Uri::to('admin/' . $page); ?>">A-Class Admin Panel</a>
                    </li>

                    <?php
                        $menu = [
                            'marquee-reservation' => 'Reservations',
                            'pages' => 'Content',
                            'services' => 'Services',
                            'event-marquee' => 'Event Marquee',
                            // 'clientele' => 'Clientele',
                            // 'marquee-feature' => 'Features',
                            'extend/metadata' => 'Config',
                        ];
                    ?>
                    <?php foreach ($menu as $url => $title): ?>
                        <li <?php if (strpos(Uri::current(), $url) !== false) { echo 'class="active"'; } ?>>
                            <a href="<?php echo Uri::to('admin/' . $url); ?>"><?php echo $title; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

            <?php echo Html::link('admin/logout', __('global.logout'), ['class' => 'btn']); ?>

            <?php $home = '/' ?>
            
            <?php else: ?>
                <aside class="logo">
                    <a href="<?php echo Uri::to('admin/login'); ?>">A-Class Admin Panel</a>
                </aside>
            <?php endif; ?>
      </div>
    </header>
