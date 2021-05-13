<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo e('WorkTrack', true); ?></title>
    <link rel="icon" type="image/png" href="<?php echo base_url(); ?>images/favicon.ico">

    <link href="<?php echo base_url(); ?>template/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>template/css/login.css" rel="stylesheet">

    <link href="//fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" data-noprefix>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>


<body>
<div class="container">
    <div class="card card-container">

        <p class="brand"><?php echo e('WorkTrack', true); ?></p>
        <p class="pay_off"><?php echo e('Your personal task board', true); ?></p>
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"/>
        <!--<p id="profile-name" class="profile-name-card">User</p>-->
        <form class="form-signin" action="<?php echo base_url(); ?>access/login" method="post">
            <span id="reauth-email" class="reauth-email"></span>

            <?php if ($this->config->item('demo_mode') == TRUE): ?>
                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?php echo e('Email address', true); ?>"
                       required autofocus value="demo@pkanban.com">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="<?php echo e('Password', true); ?>"
                       required value="demo">
            <?php else: ?>

                <input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?php echo e('Email address', true); ?>"
                       required autofocus>
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="<?php echo e('Password', true); ?>"
                       required value="admin">
            <?php endif; ?>

            <!--<div id="remember" class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value="true"> Remember me

                </label>


            </div>-->





            <p class="error_danger"><?php echo (isset($error)) ? $error : null; ?></p>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"><?php echo e('Login', true); ?></button>

            <?php if ($this->config->item('demo_mode') == TRUE): ?>
            <p style="text-align:center">Demo access:</p>
            <p>
                Login: demo@pkanban.com<br/>
                Password: demo</p>
            <?php endif; ?>

        </form><!-- /form -->




                            <h3>Register to Use</h3>
                            <form class="formAjax" action="<?php echo base_url(); ?>ajax/save_user" method="post">

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label"><?php echo e('Name', true); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" name="user_name" class="form-control"
                                               value=""
                                               placeholder="User First Name"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label"><?php echo e('Lastname', true); ?></label>
                                    <div class="col-sm-6">
                                        <input type="text" name="user_last_name" class="form-control"
                                               value=""
                                               placeholder="Last Name"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label"><?php echo e('E-mail address', true); ?></label>
                                    <div class="col-sm-6">
                                        <input type="email" name="user_email" class="form-control"
                                               value=""
                                               placeholder="E-mail address">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label"><?php echo e('Password', true); ?></label>
                                    <div class="col-sm-6">
                                        <input type="password" name="user_password" class="form-control"
                                               value=""
                                               placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label"><?php echo e('Daily reminder', true); ?></label>
                                    <div class="col-sm-6">
                                        <input type="checkbox" name="user_daily_reminder" class="form-control" value="1">
                                        <small><?php echo e('Check this if you want receive daily email with deadline tasks', true); ?></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label"><?php echo e('Permissions', true); ?></label>
                                    <div class="col-sm-6">
                                        <select name="user_permissions">
                                            <option value="0">Admin</option>
                                            <option value="10">Normal user</option>
                                            <option value="20">Read-only user</option>
                                        </select>
                                        <ul style="padding-left:0;margin-top:20px;list-style-type: none">
                                            <li><strong>Admin</strong> Super user</li>
                                            <li><strong>Normal</strong>: can create task but can't create/edit boards, columns and users</li>
                                            <li><strong>Read-only</strong>: can only read task but can drag task</li>
                                        </ul>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary"><?php echo e('Save user', true); ?></button>

                            </form>


        <!--<a href="#" class="forgot-password">
            Forgot the password?
        </a>-->
    </div>



    <!-- /card-container -->
</div><!-- /container -->
</body>
</html>