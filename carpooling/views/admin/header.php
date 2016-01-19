<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title> Carpooling </title>

        <script type="text/javascript">
            var baseurl = "<?php print base_url(); ?>";
        </script>
        <!-- bootstrap -->

        <script src="<?php echo admin_js('jquery.js'); ?>"></script>
        <?php echo admin_css('bootstrap/bootstrap.min.css', true); ?>


        <!-- RTL support - for demo only -->

        <?php echo admin_js('demo-rtl.js', true); ?>

        <!-- 
        If you need RTL support just include here RTL CSS file <link rel="stylesheet" type="text/css" href="css/libs/bootstrap-rtl.min.css" />
        And add "rtl" class to <body> element - e.g. <body class="rtl"> 
        -->

        <!-- libraries -->
        <?php echo admin_css('libs/font-awesome.css', true); ?>


        <?php echo admin_css('libs/nanoscroller.css', true); ?>

        <!-- global styles -->

        <?php echo admin_css('compiled/theme_styles.css', true); ?>
        <!-- this page specific styles -->
        <?php echo admin_css('libs/datepicker.css', true); ?>
        <?php echo admin_css('libs/daterangepicker.css', true); ?>
        <?php echo admin_css('libs/bootstrap-timepicker.css', true); ?>
        <?php echo admin_css('libs/select2.css', true); ?>


        <!-- Favicon -->

        <!-- google font libraries -->
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>

        <!--[if lt IE 9]>
                <script src="js/html5shiv.js"></script>
                <script src="js/respond.min.js"></script>
        <![endif]-->
        
        <link rel="shortcut icon" href="<?php echo theme_img('favicon.ico');?>">
    </head>
    <body>

        <?php
        $this->CI = & get_instance();
        $admin_session['admin_session'] = $this->CI->admin_session->userdata('admin');
        $name = $admin_session['admin_session']['name'];
        $admin_img = (array) $this->auth->get_admin($admin_session['admin_session']['id']);
        ?>
        <?php $admin_url = site_url($this->config->item('admin_folder')) . '/'; ?>
        <!--Smooth Scroll-->
        <?php echo admin_js('jquery.livequery.js', true); ?>
        <?php echo admin_js('jquery.timeago.js', true); ?>
        <script type="text/javascript" language="javascript">

                    $("span.time").livequery(function () {
                        $(this).timeago();
                    });

        </script>

        <div id="theme-wrapper">
            <header class="navbar" id="header-navbar">
                <div class="container">
                    <a href="<?php echo base_url('admin/dashboard'); ?>" id="logo" class="navbar-brand">
                        <img src="<?php echo theme_logo_img($this->logo->name); ?>" style="width:131px; height:30px;" alt="" class="normal-logo logo-white"/>
                    </a>

                    <div class="clearfix">
                        <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="fa fa-bars"></span>
                        </button>

                        <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
                            <ul class="nav navbar-nav pull-left">
                                <li>
                                    <a class="btn" id="make-small-nav">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell"></i>
                                    </a>
                                    <ul class="dropdown-menu notifications-list">
                                        <li class="pointer">
                                            <div class="pointer-inner">
                                                <div class="arrow"></div>
                                            </div>
                                        </li>
                                        <li class="item-header">You have <?= sizeof($this->trips)?> new notifications</li>
                                        <?php
                                        if ($this->trips) {
                                            foreach ($this->trips as $trips) {
                                                ?>
                                                <li class="item">
                                                    <a href="<?= base_url('admin/trip') ?>">
                                                        <i class="fa fa-plus"></i>
                                                        <span class="content"><?= 'New trip posted ' . $trips['source'] . ' to ' . $trips['destination'] ?></span>
                                                        <span class="time" title="<?= $trips['trip_created_date'] ?>"></span>
                                                    </a>
                                                </li>
                                            <?php }
                                        } ?>
                                        <li class="item-footer">
                                            <a href="#">										
                                            </a>
                                        </li>
                                    </ul>
                                </li>						
                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        Master
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>country">
                                                <i class="fa  fa-arrows-alt"></i> 
                                                Country
                                            </a>
                                        </li>
                                        <li class="item">
                                                <a href="<?php echo $admin_url; ?>currency">
                                                        <i class="fa fa-archive"></i> 
                                                        Currency
                                                </a>
                                        </li>
                                        <li class="item">
                                                <a href="<?php echo $admin_url; ?>language">
                                                        <i class="fa fa-archive"></i> 
                                                        Language
                                                </a>
                                        </li>
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>category">
                                                <i class="fa  fa-arrows-alt"></i> 
                                                Vehicle Brand
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>vehicle">
                                                <i class="fa  fa-car"></i> 
                                                Vehicles
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>radius">
                                                <i class="fa fa-circle-o-notch"></i> 
                                                Radius
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        Site Users
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>traveller/form">
                                                <i class="fa fa-plus"></i>
                                                Add Site User
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>traveller">
                                                <i class="fa fa-male"></i>
                                                List Site User 
                                            </a>
                                        </li>
                                        <!--<li class="item">
                                                <a href="<?php echo $admin_url; ?>traveller/details">
                                                        List Site User Details
                                                </a>
                                        </li>-->
                                    </ul>
                                </li>

                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        User Management
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>admin"><i class="fa fa-users"></i> Admin</a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        CMS
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>pages">
                                                <i class="fa fa-file"></i> 
                                                Pages
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>testimonials">
                                                <i class="fa fa-sliders"></i> 
                                                Testimonials
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        Trips
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>trip">
                                                <i class="fa  fa-map-marker"></i> 
                                                List of Trips
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown hidden-xs">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown">
                                        Notification
                                        <i class="fa fa-caret-down"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>settings">
                                                <i class="fa fa-inbox"></i> 
                                                Email Templates
                                            </a>
                                        </li>
                                        <li class="item">
                                            <a href="<?php echo $admin_url; ?>subscriber">
                                                <i class="fa fa-bookmark-o"></i> 
                                                Subscribers
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="nav-no-collapse pull-right" id="header-nav">
                            <ul class="nav navbar-nav pull-right">

                                <li class="dropdown profile-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                                        <span class="hidden-xs">Welcome <?= $name; ?> </span> <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="<?php echo base_url('admin/admin/edit_profile'); ?>"><i class="fa fa-user"></i>Edit Profile</a></li>
                                        <li><a href="<?php echo base_url('admin/admin/edit_settings'); ?>"><i class="fa fa-wrench"></i>Edit Settings</a></li>	
                                        <li><a href="<?php echo base_url('admin/admin/changepwd_form'); ?>"><i class="fa fa-cog"></i>Change Password</a></li>						
                                         <li><a href="<?php echo base_url('admin/admin/change_logo'); ?>"><i class="fa fa-cog"></i>Change logo</a></li>
                                        		
                                        <li><a href="<?php echo base_url('admin/login/logout'); ?>"><i class="fa fa-power-off"></i>Logout</a></li>
                                    </ul>
                                </li>
                                <li class="hidden-xxs" >
                                    <a class="btn" href="<?php echo base_url('admin/login/logout'); ?>" >
                                        <i class="fa fa-power-off"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <div id="page-wrapper" class="container">
                <div class="row">
                    <?php
                    //lets have the flashdata overright "$message" if it exists
                    if ($this->session->flashdata('message')) {
                        $message = $this->session->flashdata('message');
                    }

                    if ($this->session->flashdata('error')) {
                        $error = $this->session->flashdata('error');
                    }

                    if (function_exists('validation_errors') && validation_errors() != '') {
                        $error = validation_errors();
                    }
                    ?>

                    <div class="main-box-body clearfix">
                    <?php if (!empty($message)): ?>
                            <div class="alert alert-success fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-check-circle fa-fw fa-lg"></i>
                                <strong>Well done!</strong> <?php echo $message; ?>
                            </div>
<?php endif; ?>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger fade in">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="fa fa-times-circle fa-fw fa-lg"></i>
                                <strong>Oh snap!</strong><?php echo $error; ?>
                            </div>              
<?php endif; ?>
                    </div>

