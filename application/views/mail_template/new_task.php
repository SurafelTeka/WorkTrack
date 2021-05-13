<p>Hi <strong><?php echo $data['user']['user_name']; ?></strong>,</p>

<p>You have a new task on board: <?php echo $data['board']['board_name'];?> in column: <?php echo $data['board']['container_name'];?></p>

<ul>
    <li><strong>Created by: </strong> <?php echo $data['user']['user_name']; ?></li>
    <li><strong>Title:</strong>  <?php echo $data['task']['task_title']; ?></li>
    <li><strong>Description:</strong> <?php echo word_limiter($data['task']['task_description'], 20); ?> </li>
</ul>


<p><a href="<?php echo $this->config->item('base_url'); ?>">Login now</a> into your pKanban board</p>

<p>Good job and good day!</p>

<p>Your pKanban board.</p>