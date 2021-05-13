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
