<!-- File: /app/View/Posts/index.ctp -->
<div class="form-group text-left">
    <h1>Messages List</h1>
</div>
<div class="form-group text-right">
    <p><?php echo $this->Html->link('New Message', array('action' => 'add')); ?></p>
</div>
<table>
    <tr>
        <th></th>
        <th></th>
    </tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php echo $user['User']['name']; ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>