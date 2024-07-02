<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\License $license
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit License'), ['action' => 'edit', $license->id]) ?> </li>
        <li><?= $this->Html->link(__('Activate'), ['action' => 'activate', $license->id]) ?></li>
        <li><?= $this->Html->link(__('Deactivate'), ['action' => 'deactivate', $license->id]) ?></li>
        
        <li><?= $this->Form->postLink(__('Delete License'), ['action' => 'delete', $license->id], ['confirm' => __('Are you sure you want to delete # {0}?', $license->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Licenses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="licenses view large-9 medium-8 columns content">
    <h3><?= h($license->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $license->has('client') ? $this->Html->link($license->client->firstname." ".$license->client->secondname, ['controller' => 'Clients', 'action' => 'view', $license->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($license->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= h($license->is_active) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('UUID') ?></th>
            <td><?= h($license->uuid) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Serial') ?></th>
            <td><?= h($license->serial) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($license->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started') ?></th>
            <td><?= h($license->started) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expired') ?></th>
            <td><?= h($license->expired) ?></td>
        </tr>
    </table>
</div>
