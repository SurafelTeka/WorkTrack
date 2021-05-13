<div class="row" style="padding:100px">
    <div class="col-md-12" style="background-color: #fafafa;">
        <h3><?php echo e('Archived tasks!', true); ?></h3>

        <?php if ($data['tasks']->num_rows() < 1): ?>
            <p><?php echo e('Your task archive is empty!', true); ?></p>
        <?php else: ?>
            <table class="table">

                <thead>
                <tr>
                    <th><?php echo e('ID', true); ?></th>
                    <th><?php echo e('Title', true); ?></th>
                    <th><?php echo e('Description', true); ?></th>
                    <th><?php echo e('Action', true); ?></th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($data['tasks']->result_array() as $task): ?>

                    <tr>
                        <th scope="row"><?php echo $task['task_id']; ?></th>
                        <td><?php echo $task['task_title']; ?></td>
                        <td><?php echo $task['task_description']; ?></td>
                        <td><a href="#" class="restore_task" rel="<?php echo $task['task_id']; ?>"><?php echo e('Restore', true); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>
        <?php endif; ?>
    </div>
</div>

<script>
    $('.restore_task').on('click', function (event) {

        var task_id = $(this).attr("rel");

        $.ajax({
            url: base_url + "ajax/update_field/tasks/task_archived/0/task_id/" + task_id,
            dataType: 'json',
            cache: false,
            success: function (data) {
                window.location.reload();
            }
        });

    })
</script>