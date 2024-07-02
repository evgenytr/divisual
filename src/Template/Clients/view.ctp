<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\Client $client
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Client'), ['action' => 'edit', $client->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Client'), ['action' => 'delete', $client->id], ['confirm' => __('Are you sure you want to delete # {0}?', $client->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Clients'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Client'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Licenses'), ['controller' => 'Licenses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New License'), ['controller' => 'Licenses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="clients view large-9 medium-8 columns content">
    <h3><?= h($client->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($client->firstname." ".$client->secondname) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Company') ?></th>
            <td><?= h($client->company) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($client->email) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Licenses') ?></h4>
        <?php if (!empty($client->licenses)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('UUID') ?></th>
                <th scope="col"><?= __('Serial') ?></th>
                <th scope="col"><?= __('Started') ?></th>
                <th scope="col"><?= __('Expired') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($client->licenses as $licenses): ?>
            <tr>
                <td><?= h($licenses->type) ?></td>
                <td><?= h($licenses->uuid) ?></td>
                <td><?= h($licenses->serial) ?></td>
                <td><?= h($licenses->started) ?></td>
                <td><?= h($licenses->expired) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Licenses', 'action' => 'view', $licenses->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Licenses', 'action' => 'edit', $licenses->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Licenses', 'action' => 'delete', $licenses->id], ['confirm' => __('Are you sure you want to delete # {0}?', $licenses->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
