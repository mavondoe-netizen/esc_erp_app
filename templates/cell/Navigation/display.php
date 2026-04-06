<ul class="nav">

<?php foreach ($modules as $module): ?>

<li>
<?= $this->Html->link(
    $module->name,
    ['controller'=>$module->model,'action'=>'index']
) ?>
</li>

<?php endforeach; ?>

</ul>