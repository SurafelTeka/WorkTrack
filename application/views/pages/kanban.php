<div class="row">

    <?php if (count($data['containers']) < 1) : ?>
        <a href="<?php echo base_url(); ?>home/settings/<?php echo $data['board_id']; ?>#tab_containers"><?php echo e('no containers', true); ?></a>
    <?php endif; ?>

    <?php $numItems = count($data['containers']);
    $i = 0; ?>
    <?php foreach ($data['containers'] as $container) : ?>
        <?php $division = round(12 / $numItems, 0, PHP_ROUND_HALF_DOWN); ?>
        <?php if ($numItems == 7) $division = 1; ?>
        <?php $column_value = (count($data['containers']) > 2) ? $division : 4; ?>
        <?php if (++$i === $numItems && ($division * $numItems) < 12) $column_value = round(12 - ($division * ($numItems - 1)), 0, PHP_ROUND_HALF_UP); ?>
        <div class="column sortable col-md-<?php echo $column_value; ?>" rel="<?php echo $container['container_id']; ?>" style="background-color:<?php echo "rgba({$container['container_rgb']}, {$data['configs']['conf_background_opacity']})"; ?>;">

            <div class="column-header nodrag" style="background-color:<?php echo unserialize(CONTAINER_COLORS)[$container['container_color']]; ?>;"><?php echo $container['container_name']; ?>
                <?php if ($this->session->userdata('user_session')['user_permissions'] <= 10) : ?>
                    <img src="<?php echo base_url(); ?>images/plus_icon.png" class="plus_button" data-toggle="modal" data-target="#addTaskModal" data-container_name="<?php echo $container['container_name']; ?>" data-container_id="<?php echo $container['container_id']; ?>" />
                <?php endif; ?>
            </div>


            <?php foreach ($data['tasks'][$container['container_id']] as $task) : ?>
                <div class="portlet task_element" <?php if ($task['task_color']) : ?>style="border-left: solid 4px <?php echo unserialize(TASK_COLORS)[$task['task_color']]; ?>;<?php endif; ?>" id="<?php echo $task['task_id']; ?>" data-toggle="modal" data-target="#editTaskModal" data-task_id="<?php echo $task['task_id']; ?>">
                    <div class="portlet-border"></div>
                    <div class="portlet-header">
                        <span class="task_title"><?php echo $task['task_title']; ?></span>

                        <span class="portlet-date">
                            <?php if ($task['task_description']) : ?>
                                <span class='ui-icon ui-icon-plusthick portlet-toggle nodrag'></span>
                            <?php endif; ?>
                            <span class="<?php if (date('Y-m-d', strtotime($task['task_due_date'])) < date('Y-m-d')) : ?>danger_date<?php endif; ?>"><?php echo ($task['task_due_date'] != 0) ? print_date($task['task_due_date']) : null; ?></span>
                            <?php echo ($task['task_time_estimate'] != "00:00:00") ? "Est.: " . $task['task_time_estimate'] : null; ?>
                            <?php echo ($task['task_time_spent'] != "00:00:00") ? "Spent: " . $task['task_time_spent'] : null; ?>
                        </span>

                        <div class="action_button hidden-xs">
                            <?php if ($this->session->userdata('user_session')['user_permissions'] <= 10) : ?>
                                <img class="time_tracker_action" rel="<?php echo $task['task_id']; ?>" src="<?php echo base_url(); ?>images/icon_start.png" />
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ($task['task_description']) : ?>
                        <div class="portlet-content" style="display:none"><?php echo nl2br($task['task_description']); ?></div>
                    <?php endif; ?>


                </div>
            <?php endforeach; ?>

        </div>
    <?php endforeach; ?>


</div>

<div class="drag_options" style="display:none;">

    <div class="darg_options_container">

        <div class="icon icon_archive sortable pull-left" rel="archive">


        </div>
        <div class="icon icon_bin sortable pull-right" rel="bin">

        </div>
        <div class="clearfix"></div>
    </div>

</div>

<div class="board-footer hidden-xs" style="background-color:<?php echo unserialize(NAVBAR_COLORS)[$data['configs']['conf_navbar_color']]; ?>;">

    <span><?php echo e('WorkTrack', false); ?> v<?php echo $this->config->item('version'); ?></span>
    <span class="separator">|</span>
    <?php foreach ($data['containers'] as $container) : ?>
        <span class="col-title"><?php echo $container['container_name']; ?></span> <span style="color:<?php echo unserialize(CONTAINER_COLORS)[$container['container_color']]; ?>;">
            <?php echo count($data['tasks'][$container['container_id']]); ?>
        </span>
        <span class="separator">|</span>
    <?php endforeach; ?>

    <span class="board-time-spent"><?php echo e('TIME SPENT ON THIS BOARD', true); ?>
        <strong><?php echo $data['board_time_spent_active']; ?></strong> (<?php echo $data['board_time_spent_archived']; ?> Archived task)</span>

</div>


<!------------------ ############################ MODALS ########################################## -->

<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?php echo e('Add Task', true); ?></h4>
            </div>
            <form class="formAjax" action="<?php echo base_url(); ?>ajax/save_task" method="post">

                <div class="modal-body">
                    <input id="task_container" name="task_container" type="hidden" value="" />
                    <div class="form-group">
                        <label for="task_title" class="form-control-label"><?php echo e('Title', true); ?>:</label>
                        <input id="task_title" name="task_title" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="task_description" class="form-control-label"><?php echo e('Description', true); ?>
                            :</label>
                        <textarea id="task_description" name="task_description" class="form-control"></textarea>
                    </div>

                    <div class="form-group to_do">
                        <label for="task_todo" class="form-control-label"><?php echo e('ToDo List', true); ?>:</label>

                        <div class="header">
                            <input type="text" class="todoInput" id="AddTodoInput" placeholder="Title...">
                            <span id="newTaskAddBtn" class="addBtn">Add</span>
                        </div>
                        <input type="hidden" name="task_todo" id="add_task_todo" value="" />
                        <ul id="newTaskTodoUl" class="todo_ul">
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-5 form-group">
                            <label for="task_time_estimate" class="form-control-label"><?php echo e('Time estimate (hh:mm)', true); ?>:</label>
                            <input id="task_title" name="task_time_estimate" type="text" class="form-control" value="00:00">
                        </div>

                        <div class="col-md-5 form-group">
                            <label for="task_time_spent" class="form-control-label"><?php echo e('Time spent (hh:mm)', true); ?>:</label>
                            <input id="task_time_spent" name="task_time_spent" type="text" class="form-control" value="00:00">
                        </div>

                        <div class="col-md-2 form-group">
                            <label for="task_color" class="form-control-label"><?php echo e('Color', true); ?>:</label>
                            <div class="form-group">
                                <select id="task_color" class="colorPicker" name="task_color">
                                    <option value=""></option>
                                    <?php foreach (unserialize(TASK_COLORS) as $key => $color) : ?>
                                        <option value="<?php echo $key; ?>" data-color="<?php echo $color; ?>"><?php echo $color; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="task_time_spent" class="form-control-label"><?php echo e('Due date', true); ?>
                            :</label>
                        <div class='input-group date datetimepicker'>
                            <input id="task_due_date" name="task_due_date" type='text' class="form-control" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_button" data-dismiss="modal"><?php echo e('Close', true); ?></button>

                    <button type="submit" class="btn btn-primary"><?php echo e('Save task', true); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- *************************** E D I T MODAL ********************************** -->
<div class="modal fade" id="editTaskModal" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"><?php echo e('Task', true); ?>: <span class="task_header"></span></h4>
                <small><?php echo e('Created by', true); ?>: <span class="task_user_name"></span></small>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab_edit"><?php echo e('Edit Task', true); ?></a>
                    </li>
                    <li><a data-toggle="tab" href="#tab_attachments"><?php echo e('Attachments', true); ?></a></li>
                    <li><a data-toggle="tab" href="#tab_periods"><?php echo e('Working periods', true); ?></a></li>
                </ul>
                <div class="tab-content bck">
                    <div id="tab_edit" class="tab-pane fade in active">
                        <form class="formAjax" action="<?php echo base_url(); ?>ajax/edit_task/" method="post">
                            <input class="task_id" type="hidden" name="task_id" value="" />

                            <div class="form-group">
                                <label for="task_title" class="form-control-label"><?php echo e('Title', true); ?>
                                    :</label>
                                <input name="task_title" type="text" class="task_title form-control">
                            </div>
                            <div class="form-group">
                                <label for="task_description" class="form-control-label"><?php echo e('Description', true); ?>:</label>
                                <textarea name="task_description" class="task_description form-control" rows="5"></textarea>
                            </div>

                            <div class="form-group to_do">
                                <label for="task_todo" class="form-control-label"><?php echo e('ToDo List', true); ?>
                                    :</label>

                                <div class="header">
                                    <input type="text" id="editTodoInput" class="todoInput" placeholder="Title...">
                                    <span id="editTaskAddBtn" class="addBtn">Add</span>
                                </div>
                                <input type="hidden" name="task_todo" id="edit_task_todo" value="" />
                                <ul id="editTaskTodoUl" class="todo_ul todo_ul_edit_mode">

                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-5 form-group">
                                    <label for="task_time_estimate" class="form-control-label"><?php echo e('Time estimate', true); ?>:</label>
                                    <input name="task_time_estimate" type="text" class="task_time_estimate form-control">
                                </div>

                                <div class="col-md-5 form-group">
                                    <label for="task_time_spent" class="form-control-label"><?php echo e('Time spent', true); ?>:</label>
                                    <input name="task_time_spent" type="text" class="task_time_spent form-control">
                                </div>

                                <div class="col-md-2 form-group">
                                    <label for="task_color" class="form-control-label"><?php echo e('Color', true); ?>
                                        :</label>
                                    <div class="form-group">
                                        <select id="task_color" class="colorPicker" name="task_color">
                                            <option value="" selected="selected"><?php echo e('None', true); ?></option>
                                            <?php foreach (unserialize(TASK_COLORS) as $key => $color) : ?>
                                                <option value="<?php echo $key; ?>" data-color="<?php echo $color; ?>"><?php echo $color; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="task_time_spent" class="form-control-label"><?php echo e('Due date', true); ?>:</label>
                                <div class='input-group date datetimepicker'>
                                    <input name="task_due_date" type='text' class="task_due_date form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="task_time_spent" class="form-control-label"><?php echo e('Move to column', true); ?>:</label>
                                <select class="form-control form-control-lg task_container" name="task_container">
                                    <?php foreach ($data['containers'] as $container) : ?>
                                        <option value="<?php echo $container['container_id']; ?>"><?php echo $container['container_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary close_button" data-dismiss="modal">
                                    <?php echo e('Close', true); ?>
                                </button>
                                <button type="button" class="btn btn-danger" id="delete_task" rel=""><?php echo e('Delete task', true); ?>
                                </button>
                                <button type="submit" class="btn btn-primary"><?php echo e('Save task', true); ?></button>
                            </div>
                        </form>
                    </div>

                    <div id="tab_attachments" class="tab-pane fade in">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo e('Filename', true); ?></th>
                                    <th><?php echo e('User', true); ?></th>
                                    <th><?php echo e('Date', true); ?></th>
                                    <th><?php echo e('Action', true); ?></th>
                                </tr>
                            </thead>
                            <tbody class="attachments_body">

                            </tbody>
                        </table>
                        <?php if ($this->session->userdata('user_session')['user_permissions'] <= 10) : ?>
                            <div class="dropzone_error"></div>
                            <form action="/upload-target" class="dropzone" id="dropzone_form">
                                <input class="upload_task_id" type="hidden" name="task_id" value="" />
                            </form>
                        <?php endif; ?>
                    </div>

                    <div id="tab_periods" class="tab-pane fade in">

                        <div class="row">
                            <div class="col-md-4 text-center">
                                <h3><?php echo e('Date creation', true); ?></h3>
                                <span class="label label-success task_date_creation"></span>
                            </div>
                            <div class="col-md-4 text-center">
                                <h3><?php echo e('Date Closed', true); ?></h3>
                                <span class="label label-danger task_date_closed"></span>
                            </div>
                            <div class="col-md-4 text-center">
                                <h3><?php echo e('Time spent', true); ?></h3>
                                <span class="label label-info total_time_spent"></span>
                            </div>

                        </div>

                        <div class="row" style="margin-top:20px">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th><?php echo e('User', true); ?></th>
                                            <th><?php echo e('From', true); ?></th>
                                            <th><?php echo e('To', true); ?></th>
                                            <th><?php echo e('Total time', true); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="periods_body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


</div>

<?php if ($data['task_standby'] && $this->config->item('demo_mode') == FALSE) : ?>

    <div class="modal fade" id="resumeWorkTaskModal" tabindex="-1" role="dialog" aria-labelledby="resumeWorkTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="resumeWorkTaskModalLabel"><?php echo e('Resume work?', true); ?></h4>
                </div>
                <div class="modal-body">
                    <?php echo e('Hi, in your recent work you have left open the tracking of a task.', true); ?>

                    <ul>
                        <li><strong><?php echo e('Task title', true); ?>
                                :</strong> <?php echo $data['task_standby']['task_title']; ?></li>
                        <li><strong><?php echo e('Time spent', true); ?>
                                :</strong> <?php echo $data['task_standby']['task_time_spent']; ?>
                        </li>
                    </ul>

                    <p><?php echo e('Last tracking is', true); ?>:
                        <strong><?php echo $data['task_standby']['last_tracking']; ?></strong></p>

                    <h2><?php echo e('What do you want to do', true); ?>?</h2>

                    <center>
                        <a href="<?php echo base_url(); ?>datab/delete/task_periods/task_periods_id/<?php echo $data['task_standby']['task_periods_id']; ?>" class="btn btn-secondary"><?php echo e('Dismiss tracking', true); ?></a>
                        <button type="button" class="btn btn-danger" OnClick="$('.time_tracker_action[rel=<?php echo $data['task_standby']['task_id']; ?>]').trigger('click');$('#resumeWorkTaskModal').modal('hide');" id="delete_task" rel=""><?php echo e('Resume work', true); ?>
                        </button>
                    </center>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<script>
    /****************************************************** TODO LIST ********************************************** */

    // Click on a close button to hide the current list item
    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.display = "none";
        }
    }

    var todo_json = [];


    $('.todo_ul_edit_mode').on("click", "li", function(e) {

        if ($(this).hasClass("checked")) {
            new_value = 0;
        } else {
            new_value = 1;
        }
        $(this).toggleClass("checked");
        current_todo_id = $(this).data('todoid');
        $.ajax({
            url: base_url + "ajax/update_field/tasks_todo/status/" + new_value + "/id/" + current_todo_id,
            dataType: 'json',
            cache: false,
            success: function(data) {

            }
        });
        e.preventDefault();
    });

    $('.todo_ul_edit_mode ').on("click", ".close", function(e) {
        e.preventDefault();
        parent_li = $(this).parent();
        current_todo_id = $(this).parent().data('todoid');
        $.ajax({
            url: base_url + "ajax/delete/tasks_todo/id/" + current_todo_id,
            dataType: 'json',
            cache: false,
            success: function(data) {
                parent_li.remove();
            }
        });
        e.stopPropagation();
    });

    $('#newTaskAddBtn').on('click', function() {
        var li = document.createElement("li");
        var inputValue = $('#AddTodoInput').val();
        var t = document.createTextNode(inputValue);
        li.appendChild(t);
        if (inputValue === '') {
            alert("You must write something!");
        } else {
            todo_json.push(inputValue);
            console.log(todo_json);
            $('#add_task_todo').val(JSON.stringify(todo_json));
            $('#newTaskTodoUl').append("<li>" + inputValue + "</li>");;
        }
        $('#AddTodoInput').val("");

    });

    $('#editTaskAddBtn').on('click', function() {
        var li = document.createElement("li");
        var inputValue = $('#editTodoInput').val();
        var t = document.createTextNode(inputValue);
        li.appendChild(t);
        if (inputValue === '') {
            alert("You must write something!");
        } else {
            todo_json.push(inputValue);
            console.log(todo_json);
            $('#edit_task_todo').val(JSON.stringify(todo_json));
            $('#editTaskTodoUl').append("<li>" + inputValue + "</li>");;
        }
        $('#editTodoInput').val("");

    });

    function removeA(arr) {
        var what, a = arguments,
            L = a.length,
            ax;
        while (L > 1 && arr.length) {
            what = a[--L];
            while ((ax = arr.indexOf(what)) !== -1) {
                arr.splice(ax, 1);
            }
        }
        return arr;
    }

    /****************************************************** DROP ZONE UPLOAD ********************************************** */


    var myDropzone = new Dropzone("#dropzone_form", {
        url: "<?php echo base_url(); ?>ajax/upload_attachments",
        dictDefaultMessage: ""
    });

    myDropzone.on("error", function(file, error, errorxhr) {
        error_message = JSON.parse(errorxhr.response);
        $('.dropzone_error').html(error_message.error);
    });
    myDropzone.on("success", function(file, xhrmessage) {
        popolate_attachment(JSON.parse(xhrmessage))
    });
    myDropzone.on("complete", function(file, error, xhrmessage) {
        //$('.dropzone_error').html("");
        myDropzone.removeFile(file);
    });

    Dropzone.autoDiscover = false;

    /****************************************************** VARIOUS ********************************************** */

    $('.colorPicker').colorselector();

    $('#delete_task').on('click', function(event) {
        var result = confirm("Are you sure?");
        var task_id = $(this).attr("rel");
        if (result) {
            $.ajax({
                url: base_url + "ajax/delete/tasks/task_id/" + task_id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    window.location.reload();
                }
            });
        }
    })

    /****************************************************** MODALS  ********************************************** */

    $('#addTaskModal').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget) // Button that triggered the modal
        var container_name = button.data('container_name');
        var container_id = button.data('container_id');

        todo_json = [];
        $('#add_task_todo').val("");

        var modal = $(this)
        modal.find('.modal-title').text('Add Task in: ' + container_name)
        $('#task_container').val(container_id)

        modal.find('.todo_ul').html("");
        modal.find('.todo_ul').on("click", "li", function() {
            removeA(todo_json, $(this).html());
            $('#task_todo').val(JSON.stringify(todo_json));
            $(this).remove();

            /*var index = $.inArray("prova", todo_json);
            if (index >= 0) todo_json.splice(index, 1);*/

        });

    })

    $('#editTaskModal').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget) // Button that triggered the modal
        var current_task_id = button.data('task_id');

        var modal = $(this)
        if (!current_task_id) {
            return false;
        }

        todo_json = [];
        $('#edit_task_todo').val("");

        $.ajax({
            url: base_url + "ajax/get_task_details/" + current_task_id,
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('.upload_task_id').val(data.task.task_id);
                modal.find('.task_id').val(data.task.task_id);
                modal.find('#delete_task').attr('rel', data.task.task_id);
                modal.find('.task_title').val(data.task.task_title);
                modal.find('.task_user_name').html(data.task.user_name + ' ' + data.task.user_last_name);
                modal.find('.task_header').html(data.task.task_title);
                modal.find('.task_description').val(data.task.task_description);
                modal.find('.task_time_estimate').val(data.task.task_time_estimate);
                modal.find('.task_time_spent').val(data.task.task_time_spent);
                modal.find('.colorPicker').colorselector("setValue", data.task.task_color);
                modal.find('.task_container').val(data.task.task_container);

                if (data.task.task_due_date != "0000-00-00 00:00:00")
                    modal.find('.task_due_date').val(data.task.task_due_date);
                else
                    modal.find('.task_due_date').val('');


                // Details tab
                modal.find('.task_date_creation').html(data.task.task_date_creation);
                modal.find('.task_date_closed').html(data.task.task_date_closed);

                // Working periods task
                $('.periods_body').html("");
                if (data.task_periods.length > 0) {
                    data.task_periods.forEach(function(p) {
                        $('.periods_body').append("<tr><td>" + p.user_name + " " + p.user_last_name + "</td><td>" + p.task_date_start + "</td><td>" + p.task_date_stop + "</td><td>" + p.total_time + "</td></tr>");
                    });
                    $('.total_time_spent').html(data.task_time_spent);
                } else {
                    $('.periods_body').append("<tr><td colspan='3'>No working periods found for this task.</td></tr>");
                }

                // Task Todo
                modal.find('.todo_ul').html("");
                if (data.task_todo.length > 0) {
                    data.task_todo.forEach(function(a) {
                        if (a.status == 0) {
                            modal.find('.todo_ul').append("<li data-todoid='" + a.id + "'>" + a.title + "<span class='close'>x</span></li>");
                        } else {
                            modal.find('.todo_ul').append("<li data-todoid='" + a.id + "' class='checked'>" + a.title + "<span class='close'>x</span></li>");
                        }
                    });
                }

                // Attachments
                $('.attachments_body').html("");
                if (data.task_attachments.length > 0) {
                    data.task_attachments.forEach(function(a) {
                        popolate_attachment(a)
                    });


                } else {
                    $('.attachments_body').append("<tr><td colspan='3'>No attachments found for this task.</td></tr>");
                }


            },
        });




        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {

            var tab = $(e.target).attr('href');

            $.ajax({
                url: base_url + "ajax/get_task_details/" + current_task_id,
                dataType: 'json',
                cache: false,
                success: function(data) {
                    modal.find('.task_id').val(data.task_id);

                },
            });

        })

        event.stopPropagation();
    });

    function popolate_attachment(a) {
        $('.attachments_body').append("<tr><td><img width='25' src='<?php echo base_url(); ?>images/file.png' /></td><td><a href='<?php echo base_url(); ?>uploads/" + a.attachment_filename + "'>" + a.attachment_original_filename + "</a></td><td>" + a.user_name + "</td><td>" + a.attachment_creation_date + "</td><td><img class='delete_attachment' rel='" + a.attachment_id + "' width='25' alt='Delete file' title='Delete file' src='<?php echo base_url(); ?>images/delete.png'></tr>");
        $('.delete_attachment').on('click', function(event) {
            var result = confirm("Are you sure?");
            var attachment_id = $(this).attr("rel");
            if (result) {
                $.ajax({
                    url: base_url + "ajax/delete/attachments/attachment_id/" + attachment_id,
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        window.location.reload();
                    }
                });
            }
        })
    }

    $(function() {

        <?php if (!empty($data['task_standby']['task_title'])) : ?>
            $('#resumeWorkTaskModal').modal('show');
        <?php endif; ?>

        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD H:mm'
        });

        /* Here we will store all data */
        var myArguments = {};

        function assembleData(object, arguments) {
            var data = $(object).sortable('toArray'); // Get array data
            var container_id = $(object).attr("rel"); // Get step_id and we will use it as property name
            var arrayLength = data.length; // no need to explain

            /* Create step_id property if it does not exist */
            if (!arguments.hasOwnProperty(container_id)) {
                arguments[container_id] = new Array();
            }

            /* Loop through all items */
            for (var i = 0; i < arrayLength; i++) {
                if (data[i]) {
                    var task_id = data[i];
                    /* push all image_id onto property step_id (which is an array) */
                    arguments[container_id].push(task_id);
                }
            }
            return arguments;
        }

        /* Sort task */
        var globalTimer;
        <?php if ($this->session->userdata('user_session')['user_permissions'] <= 10) : ?>
            $(".sortable").sortable({
                connectWith: ".sortable",
                cancel: ".nodrag",
                opacity: 0.7,
                placeholder: "li-placeholder",
                /* That's fired first */
                start: function(event, ui) {
                    $('.column').css('overflow-y', 'inherit'); // fix for x scroll bug
                    myArguments = {};
                    /*$('.column').css('overflow', 'hidden');*/
                    ui.item.addClass('rotate');
                    globalTimer = setTimeout(function() {
                        $('.drag_options').fadeIn(300);
                    }, 800);
                },
                /* That's fired second */
                remove: function(event, ui) {
                    /* Get array of items in the list where we removed the item */
                    myArguments = assembleData(this, myArguments);
                },
                /* That's fired thrird */
                receive: function(event, ui) {
                    /* Get array of items where we added a new item */
                    myArguments = assembleData(this, myArguments);
                },
                update: function(e, ui) {
                    if (this === ui.item.parent()[0]) {
                        /* In case the change occures in the same container */
                        if (ui.sender == null) {
                            myArguments = assembleData(this, myArguments);
                        }
                    }
                },
                /* That's fired last */
                stop: function(event, ui) {
                    clearTimeout(globalTimer);
                    ui.item.removeClass('rotate');
                    $('.column').css('overflow-y', 'auto'); // fix for x scroll bug
                    if ($(ui.item.parent()[0]).attr('rel') == 'archive' || $(ui.item.parent()[0]).attr('rel') == 'bin') {
                        ui.item.hide();
                    }
                    $('.drag_options').fadeOut(100);

                    $('.bin_container').fadeOut(500);
                    /* Send JSON to the server */
                    console.log("Send JSON to the server:<pre>" + JSON.stringify(myArguments) + "</pre>");

                    if ($(ui.item.parent()[0]).attr('rel') == 'bin') {
                        task_id = $(ui.item).attr('id');

                        $.ajax({
                            url: base_url + "ajax/delete/tasks/task_id/" + task_id,
                            type: 'post',
                            dataType: 'json',
                            data: myArguments,
                            cache: false
                        });
                    } else if ($(ui.item.parent()[0]).attr('rel') == 'archive') {
                        task_id = $(ui.item).attr('id');

                        $.ajax({
                            url: base_url + "ajax/update_field/tasks/task_archived/1/task_id/" + task_id,
                            type: 'post',
                            dataType: 'json',
                            data: myArguments,
                            cache: false
                        });
                    } else {
                        $.ajax({
                            url: base_url + "ajax/update_position",
                            type: 'post',
                            dataType: 'json',
                            data: myArguments,
                            cache: false
                        });
                    }
                },
            });
        <?php endif; ?>


        $(".portlet").addClass("ui-helper-clearfix ui-corner-all");

        $(".portlet-toggle").on("click", function() {
            var icon = $(this);
            icon.toggleClass("ui-icon-minusthick ui-icon-plusthick");
            icon.closest(".portlet").find(".portlet-content").toggle();
            return false;
        });

        $(".column").on("tap", function() {

        });

        $('.time_tracker_action').on("click", function() {

            var task_id = $(this).attr("rel");

            if (current_task_tracking != null && task_id != current_task_tracking) {
                alert("You have already tracking now.");
                return false;
            }

            if (current_task_tracking == null) {

                current_task_tracking = task_id;

                // START TIMER
                $('#timer').runner('start');
                $.ajax({
                    url: base_url + "ajax/time_tracker/start/" + task_id,
                    type: 'get',
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        $('.timer_task_title').html(data.task_title.substring(0, 10) + '...');

                    },
                });
                $('.timer_box').removeClass("hide");
                $('#timer_container').addClass("label label-warning")
                $('.pause_button').attr("rel", task_id);

                // Change button
                var src = $('.time_tracker_action[rel=' + current_task_tracking + ']').attr("src").replace('icon_start.png', 'icon_pause.png');
                $('.time_tracker_action[rel=' + current_task_tracking + ']').attr("src", src);


            } else {
                // STOP TIMER

                $('#timer').runner('reset');
                $('#timer').runner('stop');
                $.ajax({
                    url: base_url + "ajax/time_tracker/stop/" + task_id,
                    type: 'get',
                    dataType: 'json',
                    cache: false
                });
                $('.timer_box').addClass("hide");
                $('#timer_container').removeClass("label label-warning")
                $('.pause_button').attr("rel", null);
                $('.timer_task_title').html("");

                // Change button
                var src = $('.time_tracker_action[rel=' + current_task_tracking + ']').attr("src").replace('icon_pause.png', 'icon_start.png');
                $('.time_tracker_action[rel=' + current_task_tracking + ']').attr("src", src);

                current_task_tracking = null;
            }

            return false;
        });
    });
</script>