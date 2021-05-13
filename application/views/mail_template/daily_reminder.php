<p>Hi <strong><?php echo $data['user']['user_name']; ?></strong>,</p>

<p>Here are your deadline tasks today:</p>

<?php foreach($data['boards'] as $board): ?>
<p><strong><?php echo $board['board_name'] ;?></strong></p>
<ul>
    <?php foreach($data['tasks'][$board['board_id']] as $task): ?>
    <li><strong><?php echo $task['task_title']; ?></strong> <?php echo word_limiter($task['task_description'], 20); ?></li>
    <?php endforeach; ?>
</ul>
<?php endforeach; ?>

<p><a href="<?php echo $this->config->item('base_url'); ?>">Login now</a> into your pKanban board</p>

<p>Good job and good day!</p>

<p>Your pKanban board.</p>