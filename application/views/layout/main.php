<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e('WorkTrack', false); ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>images/favicon.ico">
    <!-- Css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/jquery-ui/jquery-ui.min.css"/>
    <link href="<?php echo base_url(); ?>template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>template/css/theme.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" data-noprefix>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/bootstrap-colorselector.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>template/css/dropzone.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>template/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body style="background: url('<?php echo base_url('uploads/'.$data['configs']['conf_background_image']);?>') 50% 50% repeat-y;">
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url(); ?>template/js/jquery-ui/jquery-ui.min.js"></script>

<!-- If you want enable task drag on mobile, yuo can uncomment this line, but you can't edit and add new task-->
<!--<script src="<?php echo base_url(); ?>template/js/jquery-ui/jquery.ui.touch-punch-improved.js"></script>-->

<script src="<?php echo base_url(); ?>template/js/moment.js"></script>
<script src="<?php echo base_url(); ?>template/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/notify.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/ajaxform.js"></script>
<script src="<?php echo base_url(); ?>template/js/kanban.js"></script>
<script src="<?php echo base_url(); ?>template/js/bootstrap-colorselector.js"></script>
<script src="<?php echo base_url(); ?>template/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url(); ?>template/js/jquery.runner.js"></script>
<script src="<?php echo base_url(); ?>template/js/dropzone.js"></script>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top"
     style="background-color:<?php echo unserialize(NAVBAR_COLORS)[$data['configs']['conf_navbar_color']]; ?>;">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only"><?php echo e('Toggle navigation', true); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo e('WorkTrack', true); ?></a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php $x = 0; ?>
                <?php foreach ($data['boards'] as $board): ?>
                    <?php if ($x++ <= 5): ?>
                        <li <?php if ($data['board_id_active'] == $board['board_id']): ?>class="active"<?php endif; ?>><a
                                href="<?php echo base_url() . 'home/board/' . $board['board_id']; ?>"><?php echo $board['board_name']; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php $x = 0; ?>
                <?php if (count($data['boards']) > 5): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle admin_name" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Others<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <?php foreach ($data['boards'] as $board): ?>
                                <?php if ($x++ > 5): ?>
                                    <li <?php if ($data['board_id_active'] == $board['board_id']): ?>class="active"<?php endif; ?>>
                                        <a href="<?php echo base_url() . 'home/board/' . $board['board_id']; ?>"><?php echo $board['board_name']; ?></a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <li>
                    <a href="<?php echo base_url();?>home/settings#tab_boards" style="font-size:30px;color:#fafafa">+</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li id="timer_container" style="margin-top:14px" class="">
                    <span class="timer_task_title"></span>
                            <span class="timer_box hide">
                                <span id="timer"></span>
                                <img class="time_tracker_action pause_button" rel=""
                                     src="<?php echo base_url(); ?>images/icon_pause.png"/>
                            </span>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle admin_name" data-toggle="dropdown" role="button"
                       aria-haspopup="true"
                    aria-expanded="false">Hi <?php echo $this->session->userdata('user_session')['user_name']; ?>
                        <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url(); ?>home/archive"><?php echo e('Archive', true); ?></a></li>
                        <li><a href="<?php echo base_url(); ?>home/settings"><?php echo e('Settings', true); ?></a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>access/logout"><?php echo e('Disconnect', true); ?></a></li>
                    </ul>
                </li>
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container-fluid" role="main">
    <?php echo $content; ?>
</div>



</body>
<script>

    var base_url = '<?php echo base_url();?>';
    var current_task_tracking = null;

    $('#timer').runner({
        milliseconds: false,
    });

    window.onbeforeunload = function (e) {

        if (current_task_tracking != null) {
            e = e || window.event;

            // For IE and Firefox prior to version 4
            if (e) {
                e.returnValue = '<?php echo e('You have tracking now... Sure?', true); ?>';
            }

            // For Safari
            return '<?php echo e('You have tracking now... Sure?', true); ?>';
        }
    };

</script>
</html>