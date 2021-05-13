<div class="row" style="background-color:#dad7d7;padding:1em">
    <div class="column col-md-10 col-md-offset-1">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab_general"><?php echo e('general', true); ?></a></li>
            <li><a data-toggle="tab" href="#tab_users"><?php echo e('users', true); ?></a></li>
            <li><a data-toggle="tab" href="#tab_boards"><?php echo e('boards', true); ?></a></li>
            <li><a data-toggle="tab" href="#tab_containers"><?php echo e('columns', true); ?></a></li>
        </ul>

        <div class="tab-content bck">
            <div id="tab_general" class="tab-pane fade in active">
                <h2 style="text-align:center"><?php echo e('General Settings', true); ?></h2>
                <p style="text-align:center"><?php echo e('Setup general configurations', true); ?></p>
<br />
                <div class="row" style="background-color:#fafafa;padding:1em">
                    <div class="column col-md-12 ">

                    <form class="" action="<?php echo base_url(); ?>ajax/save_configs" method="post" enctype="multipart/form-data">

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo e('Administrator Name', true); ?></label>
                            <div class="col-sm-4">
                                <input type="text" name="conf_administrator_name" class="form-control"
                                       value="<?php echo $data['configs']['conf_administrator_name']; ?>"
                                       placeholder="Your Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo e('Administrator E-mail address', true); ?></label>
                            <div class="col-sm-4">
                                <input type="text" name="conf_administrator_email" class="form-control"
                                       value="<?php echo $data['configs']['conf_administrator_email']; ?>"
                                       placeholder="Your E-mail">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="task_color" class="col-sm-3 col-form-label"><?php echo e('Background image', true); ?></label>
                            <div class="col-sm-4">
                                <input type="file" name="conf_background_image" accept="image/*">
                                <?php if ($data['configs']['conf_background_image']): ?>
                                    <img width="90" src="<?php echo base_url('uploads/'.$data['configs']['conf_background_image']);?>" />
                                    <a href="<?php echo base_url();?>datab/remove_background">Remove</a>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="conf_background_opacity" class="col-sm-3 col-form-label"><?php echo e('Background opacity', true); ?></label>
                            <div class="col-sm-4">
                                <input style="width:100px" type="text" name="conf_background_opacity" class="form-control" value="<?php echo $data['configs']['conf_background_opacity']; ?>" > min. 0.0 max 1.0
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="task_color" class="col-sm-3 col-form-label"><?php echo e('Top Bar Color', true); ?></label>
                            <div class="col-sm-4">
                                <select class="colorselector" name="conf_navbar_color">
                                    <?php foreach (unserialize(NAVBAR_COLORS) as $key => $color): ?>
                                        <option <?php if ($data['configs']['conf_navbar_color'] == $key) echo 'selected="selected"' ?>
                                            value="<?php echo $key; ?>"
                                            data-color="<?php echo $color; ?>"><?php echo $color; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php echo e('Date format', true); ?></label>
                            <div class="col-sm-4">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="conf_date_format"
                                               value="1" <?php if ($data['configs']['conf_date_format'] == 1) echo 'checked="checked"'; ?>>
                                        YYYY/MM/DD HH:MM
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="conf_date_format"
                                               value="2" <?php if ($data['configs']['conf_date_format'] == 2) echo 'checked="checked"'; ?>>
                                        DD/MM/YYY HH:MM
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="conf_date_format"
                                               value="3" <?php if ($data['configs']['conf_date_format'] == 3) echo 'checked="checked"'; ?>>
                                        MM/DD/YYY HH:MM
                                    </label>
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary"><?php echo e('Save configs', true); ?></button>

                    </form>

                </div>
                </div>
            </div>

            <div id="tab_users" class="tab-pane fade">
                <h2 style="text-align:center"><?php echo e('User Management', true); ?></h2>

                <div class="container">

                    <div class="row">
                        <div class="col-lg-6">
                            <h3>Create a new user</h3>
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

                        </div>
                        <div class="col-lg-6">
                            <h3><?php echo e('User List', true); ?></h3>
                            <table class="table">

                                <thead>
                                <tr>
                                    <th><?php echo e('Name', true); ?></th>
                                    <th><?php echo e('Last Name', true); ?></th>
                                    <th><?php echo e('E-mail', true); ?></th>
                                    <th><?php echo e('Action', true); ?></th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data['users'] as $user): ?>

                                    <tr>
                                        <th scope="row"><?php echo $user['user_name']; ?></th>
                                        <td><?php echo $user['user_last_name']; ?></td>
                                        <td><?php echo $user['user_email']; ?></td>
                                        <td><a href="#"
                                               data-toggle="modal"
                                               data-target="#editUserModal"
                                               data-user_id="<?php echo $user['user_id']; ?>"><?php echo e('Edit', true); ?></a> | <a href="#"
                                                                                                            data-toggle="modal"
                                                                                                            data-target="#deleteUserModal"
                                                                                                            data-user_id="<?php echo $user['user_id']; ?>"><?php echo e('Delete', true); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>


            <div id="tab_boards" class="tab-pane fade">

                <div class="text-center">
                    <h2><?php echo e('Add a new board', true); ?></h2>
                    <form class="formAjax" action="<?php echo base_url(); ?>ajax/new_board" method="post">

                        <div class="input-group input-group-lg" style="margin: 0 auto">
                            <input type="text" name="board_name" class="form-control" placeholder="Name">
                        </div>

                        <!-- User sharing option -->
                        <?php if (count($data['users']) > 1): ?>
                            <h3>Sharing with (option)</h3>
                            <?php foreach ($data['users'] as $user): ?>
                                <?php if ($user['user_id'] == $this->session->userdata('user_session')['user_id']) continue; ?>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="board_sharing[]"
                                               value="<?php echo $user['user_id']; ?>"/> <?php echo $user['user_name'] . " " . $user['user_last_name'];; ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <button type="submit" class="btn btn-primary"><?php echo e('Insert', true); ?></button>

                    </form>
                    <br/>
                    <br/>
                    <h4><?php echo e('Select your prefer order with Drag & Drop', true); ?></h4>
                </div>

                <nav class="navbar navbar-inverse navbar-fixed">
                    <div class="container">


                        <div id="navbar" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav sortable">
                                <?php foreach ($data['boards'] as $board): ?>
                                    <li class="active" id="<?php echo $board['board_id']; ?>">
                                        <a href="#"
                                           data-toggle="modal"
                                           data-target="#editBoardModal"
                                           data-board_id="<?php echo $board['board_id']; ?>">
                                            <?php echo $board['board_name']; ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div><!--/.nav-collapse -->
                    </div>
                </nav>

            </div>


            <div id="tab_containers" class="tab-pane fade">

                <div class="row" style="margin-bottom:30px">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h2>Select Board</h2>
                            <select id="boards" onchange="setBoard(this);" class="form-control form-control-lg"
                                    style="width:auto;margin:0 auto">
                                <option value=""><?php echo e('Select one...', true); ?></option>
                                <?php foreach ($data['boards'] as $board): ?>
                                    <option <?php if ($data['board_id'] == $board['board_id']) echo 'selected="selected"'; ?>
                                        value="<?php echo $board['board_id']; ?>"><?php echo $board['board_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php if ($data['board_id']): ?>
                    <div class="row" style="margin-bottom:30px">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h2><?php echo e('Add a new container', true); ?></h2>


                                <form class="formAjax " action="<?php echo base_url(); ?>ajax/new_container"
                                      method="post">

                                    <input type="hidden" name="container_board"
                                           value="<?php echo $data['board_id'] ?>"/>
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <select class="colorselector" name="container_color">
                                                <?php $container_colors = unserialize(CONTAINER_COLORS);
                                                $x = 0; ?>
                                                <?php foreach ($container_colors as $key => $color): ?>
                                                    <option value="<?php echo $key; ?>"
                                                            data-color="<?php echo $color; ?>" <?php if ($x == 1) echo 'selected="selected"'; ?>><?php echo $color; ?></option>
                                                    <?php $x++;
                                                endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="text" name="container_name"
                                                   class="container_name form-control form-control-md"
                                                   placeholder="Name">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <br/>
                                        <label for="container_name" class="form-control-label"><?php echo e('Is this "Done"
                                            column?', true); ?></label> <br/>
                                        <input name="container_done" value="1" type="checkbox" class="container_done"/>
                                        Yes! <br/>
                                        <small id="fileHelp" class="form-text text-muted"><?php echo e('If checked, all task moved
                                            into this colum will \'closed\' automatically.', true); ?>
                                        </small>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"><?php echo e('Insert', true); ?></button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <?php if (count($data['containers']) > 0): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="text-center">
                                        <h2><?php echo e('Select your prefer order', true); ?></h2>

                                    </div>
                                    <div class="sortable_container">
                                        <?php $column_value = round(12 / count($data['containers']), 0, PHP_ROUND_HALF_DOWN); ?>
                                        <?php foreach ($data['containers'] as $container): ?>
                                            <div class="column col-md-<?php echo $column_value; ?>"
                                                 id="<?php echo $container['container_id']; ?>" style="min-height:0;">
                                                <div class="column-header"
                                                     style="background-color:<?php echo unserialize(CONTAINER_COLORS)[$container['container_color']]; ?>;">
                                                    <?php echo $container['container_name']; ?>
                                                    <div class="btn-group">

                                                        <button style="padding:4px" type="button"
                                                                class="btn btn-danger dropdown-toggle"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#" data-toggle="modal"
                                                                   data-target="#editContainerModal"
                                                                   data-container_id="<?php echo $container['container_id']; ?>"><?php echo e('Edit', true); ?></a>
                                                            </li>
                                                            <li><a href="#" data-toggle="modal"
                                                                   data-target="#deleteContainerModal"
                                                                   data-container_id="<?php echo $container['container_id']; ?>"><?php echo e('Delete', true); ?></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>

                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- *************************** E D I T MODAL ********************************** -->
<div class=" modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editBoardModallLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editBoardModalLabel"><?php echo e('Edit user', true); ?></h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/edit_user/" method="post">
                <input class="user_id" type="hidden" name="user_id" value=""/>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="user_name" class="form-control-label"><?php echo e('Name', true); ?>:</label>
                        <input name="user_name" type="text" class="user_name form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_last_name" class="form-control-label"><?php echo e('Lastname', true); ?>:</label>
                        <input name="user_last_name" type="text" class="user_last_name form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_email" class="form-control-label"><?php echo e('E-mail', true); ?>:</label>
                        <input name="user_email" type="text" class="user_email form-control">
                    </div>

                    <div class="form-group">
                        <label for="user_password" class="form-control-label"><?php echo e('Password', true); ?>:</label>
                        <input name="user_password" type="text" class="user_password form-control">
                        <small><?php echo e('Leave blank to not change the password', true); ?></small>
                    </div>

                    <div class="form-group">
                        <label for="user_daily_reminder" class="form-control-label"><?php echo e('Daily e-mail reminder:', true); ?></label>
                        <input type="checkbox" name="user_daily_reminder" class="form-control user_daily_reminder" value="1" />
                        <small><?php echo e('Check this if you want to receive daily email with deadline tasks', true); ?></small>
                    </div>


                    <div class="form-group">
                        <label for="user_password" class="form-control-label"><?php echo e('Permissions', true); ?></label>

                            <select class="user_permissions" name="user_permissions">
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
                <div class="modal-footer">
                    <button class="btn btn-danger delete_button_board" data-dismiss="modal" data-toggle="modal"
                            data-target="#deleteBoardModal"
                            data-board_id=""><?php echo e('Delete this board', true); ?>
                    </button>
                    <button type="button"
                            class="btn btn-secondary close_button"
                            data-dismiss="modal"><?php echo e('Close', true); ?>
                    </button>
                    <button type="submit" class="btn btn-primary"><?php echo e('Save', true); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class=" modal fade" id="editBoardModal" tabindex="-1" role="dialog" aria-labelledby="editBoardModallLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editBoardModalLabel"><?php echo e('Edit Board', true); ?></h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/edit_board/" method="post">
                <input class="board_id" type="hidden" name="board_id" value=""/>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="board_name" class="form-control-label"><?php echo e('Name', true); ?>:</label>
                        <input name="board_name" type="text" class="board_name form-control">
                    </div>
                    <div class="form-group">
                        <label for="board_default" class="form-control-label"><?php echo e('Default Board', true); ?></label>
                        <input name="board_default" value="1" type="checkbox" class="board_default form-control"/>
                        <small id="fileHelp" class="form-text text-muted"><?php echo e('If checked, will open this board at start', true); ?>
                        </small>
                    </div>

                    <!-- User sharing option -->
                    <?php if (count($data['users']) > 1): ?>
                        <h3><?php echo e('Sharing with (option)', true); ?></h3>
                        <?php foreach ($data['users'] as $user): ?>
                            <?php if ($user['user_id'] == $this->session->userdata('user_session')['user_id']) continue; ?>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" name="board_sharing[]" class="board_sharing"
                                           rel="<?php echo $user['user_id']; ?>"
                                           value="<?php echo $user['user_id']; ?>"/> <?php echo $user['user_name'] . " " . $user['user_last_name'];; ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger delete_button_board" data-dismiss="modal" data-toggle="modal"
                            data-target="#deleteBoardModal"
                            data-board_id=""><?php echo e('Delete this board', true); ?>
                    </button>
                    <button type="button"
                            class="btn btn-secondary close_button"
                            data-dismiss="modal"><?php echo e('Close', true); ?>
                    </button>
                    <button type="submit" class="btn btn-primary"><?php echo e('Save', true); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class=" modal fade" id="editContainerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?php echo e('Edit column', true); ?></h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/edit_container/" method="post">
                <input class="container_id" type="hidden"
                       name="container_id" value=""/>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="container_name" class="form-control-label"><?php echo e('Name', true); ?>:</label>
                        <input name="container_name" type="text" class="container_name form-control">
                    </div>
                    <div class="form-group">
                        <label for="task_color" class="form-control-label"><?php echo e('Color', true); ?>:</label>
                        <div class="form-group">
                            <select id="task_color" class="colorPicker" name="container_color">
                                <?php foreach (unserialize(CONTAINER_COLORS) as $key => $color): ?>
                                    <option value="<?php echo $key; ?>"
                                            data-color="<?php echo $color; ?>"><?php echo $color; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="container_name" class="form-control-label"><?php echo e('This is "Done" column?', true); ?></label>
                        <input name="container_done" value="1" type="checkbox" class="container_done form-control"/>
                        <small id="fileHelp" class="form-text text-muted"><?php echo e('If checked, all task moved into this colum will \'closed\' automatically.', true); ?>
                        </small>
                    </div>

                    <hr/>
                    <div class="form-group">
                        <label for="task_color" class="form-control-label"><?php echo e('Move to board:', true); ?></label>
                        <div class="form-group">
                            <select id="boards" name="container_board"
                                    class="form-control form-control-lg">
                                <?php foreach ($data['boards'] as $board): ?>
                                    <option <?php if ($data['board_id'] == $board['board_id']) echo 'selected="selected"'; ?>
                                        value="<?php echo $board['board_id']; ?>"><?php echo $board['board_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary close_button"
                            data-dismiss="modal"><?php echo e('Close', true); ?>
                    </button>
                    <button type="submit" class="btn btn-primary"><?php echo e('Save', true); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- *************************** DELETE MODAL ********************************** -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?php echo e('Attention', true); ?>!</h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/delete_user/" method="post">
                <div class="modal-body modal-warning">
                    <h3><?php echo e('Are you sure?', true); ?></h3>
                    <p><?php echo e('This user has', true); ?> <span class="counter_boards" style="font-weight:bold"></span> <?php echo e('boards. If you
                        delete this user, you will lose all the board and task. If you want to prevent
                        this from happening, move the boards to another user. ', true); ?></p>

                    <input class="user_id" type="hidden" name="user_id" value=""/>
                    <div class="form-group">
                        <label for="task_color" class="form-control-label"><?php echo e('Assign to user:', true); ?></label>
                        <div class="form-group">
                            <select id="move_user_selector" name="move_user"
                                    class="form-control form-control-lg">
                                <option value="0"><?php echo e('No! I want to lose all data of this user:', true); ?>
                                </option>
                                <?php foreach ($data['users'] as $user): ?>
                                    <option
                                        value="<?php echo $user['user_id']; ?>"><?php echo $user['user_name']." ".$user['user_last_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-body modal-normal">
                    <h3><?php echo e('Are you really sure?', true); ?></h3>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_button"
                            data-dismiss="modal"><?php echo e('Close', true); ?>
                    </button>
                    <button type="submit" class="btn btn-danger"><?php echo e('Delete user', true); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteBoardModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?php echo e('Attention', true); ?>!</h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/delete_board/" method="post">
                <input type="hidden" class="board_id" name="board_id" value=""/>
                <div class="modal-body modal-warning">
                    <p><?php echo e('If you delete this board, you will lost all associated task and all associated columns!!', true); ?></p>


                    <div class="modal-body modal-normal">
                        <h3><?php echo e('Are you really sure?', true); ?></h3>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_button" data-dismiss="modal"><?php echo e('I\'m wrong. Cancel.', true); ?>
                    </button>
                    <button type="submit" class="btn btn-danger"><?php echo e('Yes. Delete board.', true); ?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="deleteContainerModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?php echo e('Attention', true); ?>!</h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/delete_container/" method="post">
                <div class="modal-body modal-warning">

                    <h4><?php echo e('Are you sure?', true); ?></h4>
                    <p><?php echo e('You have', true); ?> <span class="counter_tasks" style="font-weight:bold"></span> <?php echo e('tasks in this column. If you
                        delete the column, you will lose its tasks. If you want to prevent
                        this from happening, move the tasks to column:', true); ?> </p>


                    <input class="container_id" type="hidden" name="container_id" value=""/>
                    <div class="form-group">
                        <label for="task_color" class="form-control-label"><?php echo e('Move to colum', true); ?>:</label>
                        <div class="form-group">
                            <select id="move_column_selector" name="move_container"
                                    class="form-control form-control-lg">
                                <option value="0"><?php echo e('No! I want to lose the tasks!', true); ?>
                                </option>
                                <?php foreach ($data['containers'] as $container): ?>
                                    <option
                                        value="<?php echo $container['container_id']; ?>"><?php echo $container['container_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-body modal-normal">
                    <h3><?php echo e('Are you really sure?', true); ?></h3>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_button"
                            data-dismiss="modal"><?php echo e('Close', true); ?>
                    </button>
                    <button type="submit" class="btn btn-danger"><?php echo e('Delete column', true); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    function setBoard(sel) {
        window.location.href = base_url + 'home/settings/' + sel.value + '#tab_containers';
    }

    var base_url = '<?php echo base_url();?>';


    $(function () {

        var hash = window.location.hash;
        if (hash) {
            var elementID = hash.replace('#', '');
            $('.nav-tabs a[href="#' + elementID + '"]').tab('show');

        }

        $('.colorselector').colorselector();


        /*
         * MODALS
         *
         */
        $('#deleteBoardModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var board_id = button.data('board_id');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);

            <?php if ($this->config->item('demo_mode') == TRUE): ?>
            if (board_id == 1 || board_id == 4) {
                alert('You can\'t delete this board in this live demo' + board_id);
            } else {
                modal.find('.board_id').val(board_id);
            }
            <?php else: ?>
                modal.find('.board_id').val(board_id);
            <?php endif; ?>

        });

        $('#editUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var user_id = button.data('user_id');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)

            $.ajax({
                url: base_url + "ajax/get_user_details/" + user_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    modal.find('.user_id').val(data.user_data.user_id);
                    modal.find('.user_name').val(data.user_data.user_name);
                    modal.find('.user_last_name').val(data.user_data.user_last_name);
                    modal.find('.user_email').val(data.user_data.user_email);
                    modal.find('.user_permissions').val(data.user_data.user_permissions);

                    if (data.user_data.user_daily_reminder == "1") {
                        modal.find('.user_daily_reminder').attr("checked", "checked");
                    }
                },
            });
        });

        $('#editBoardModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var board_id = button.data('board_id');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);

            $.ajax({
                url: base_url + "ajax/get_board_details/" + board_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    modal.find('.board_id').val(data.board_data.board_id);
                    modal.find('.delete_button_board').attr('data-board_id', data.board_data.board_id);
                    modal.find('.board_name').val(data.board_data.board_name);
                    if (data.board_data.board_default == "1") {
                        modal.find('.board_default').attr("checked", "checked");
                    }

                    if (data.boards_users.length > 0) {
                        data.boards_users.forEach(function (p) {
                            modal.find('.board_sharing[rel=' + p.user_id + ']').attr('checked', 'checked');
                        });
                    }
                },
            });
        });

        $('#editContainerModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var container_id = button.data('container_id');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)

            $.ajax({
                url: base_url + "ajax/get_container_details/" + container_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    modal.find('.container_id').val(data.container_data.container_id);
                    modal.find('.container_name').val(data.container_data.container_name);
                    modal.find('.colorPicker').colorselector("setValue", data.container_data.container_color);
                    if (data.container_data.container_done == "1") {
                        modal.find('.container_done').attr("checked", "checked");
                    }
                },
            });

        });

        $('#deleteUserModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var user_id = button.data('user_id');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);

            $.ajax({
                url: base_url + "ajax/get_user_details/" + user_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.user_boards.count < 1) {
                        $('.modal-warning').hide();
                        $('.modal-normal').show();
                    } else {
                        $('.modal-warning').show();
                        $('.modal-normal').hide();
                    }
                    modal.find('.user_boards').html(data.user_boards.count);
                    modal.find('.user_id').val(user_id);
                },
            });
            $("#move_user_selector option[value=" + user_id + "]").each(function () {
                $(this).attr("disabled", "disabled");
            });

            $('#deleteContainerModal').on('hide.bs.modal', function (event) {
                $("#move_user_selector option[value=" + user_id + "]").each(function () {
                    $(this).removeAttr("disabled");
                });
            });
        });

        $('#deleteContainerModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var container_id = button.data('container_id');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);

            $.ajax({
                url: base_url + "ajax/get_container_details/" + container_id,
                dataType: 'json',
                cache: false,
                success: function (data) {
                    if (data.container_tasks_count.count < 1) {
                        $('.modal-warning').hide();
                        $('.modal-normal').show();
                    } else {
                        $('.modal-warning').show();
                        $('.modal-normal').hide();
                    }
                    modal.find('.counter_tasks').html(data.container_tasks_count.count);
                    modal.find('.container_id').val(data.container_data.container_id);
                },
            });
            $("#move_column_selector option[value=" + container_id + "]").each(function () {
                $(this).attr("disabled", "disabled");
            });

            $('#deleteContainerModal').on('hide.bs.modal', function (event) {
                $("#move_column_selector option[value=" + container_id + "]").each(function () {
                    $(this).removeAttr("disabled");
                });
            });
        });


        /* Sort boards order */
        $('.sortable').sortable({
            axis: "x",
            placeholder: "li-placeholder",
            update: function (event, ui) {
                var data = $(this).sortable('toArray');
                console.log(data);

                $.ajax({
                    url: base_url + "ajax/update_boards_position",
                    type: 'post',
                    dataType: 'json',
                    data: {boards_id: data},
                    cache: false
                });
            }
        });

        /* Sort boards order */
        $('.sortable_container').sortable({

            update: function (event, ui) {
                var data = $(this).sortable('toArray');
                console.log(data);

                $.ajax({
                    url: base_url + "ajax/update_containers_position",
                    type: 'post',
                    dataType: 'json',
                    data: {containers_id: data},
                    cache: false
                });
            }
        });


    });
</script>