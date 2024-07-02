<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $license->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $license->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Licenses'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="licenses form large-9 medium-8 columns content">
    <?= $this->Form->create($license) ?>
    <fieldset>
        <legend><?= __('Edit License') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients, 'empty' => true]);
            echo $this->Form->control('type');
            echo $this->Form->control('uuid');
            echo $this->Form->control('serial');
            echo $this->Form->control('is_active');
            echo $this->Form->control('started', ['empty' => true]);
            echo $this->Form->control('expired', ['empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
