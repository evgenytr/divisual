<?php
/**
  * @var \App\View\AppView $this
  * @var \App\Model\Entity\License[]|\Cake\Collection\CollectionInterface $licenses
  */
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New License'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="licenses index large-9 medium-8 columns content">
    <h3><?= __('Licenses') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('uuid') ?></th>
                <th scope="col"><?= $this->Paginator->sort('serial') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started') ?></th>
                <th scope="col"><?= $this->Paginator->sort('expired') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_active') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($licenses as $license): ?>
            <tr>
                <td><?= $this->Html->link($license->id, ['action' => 'view', $license->id]) ?></td>
                <td><?= $license->has('client') ? $this->Html->link($license->client->firstname." ".$license->client->secondname, ['controller' => 'Clients', 'action' => 'view', $license->client->id]) : '' ?></td>
                <td><?= h($license->type) ?></td>
                <td><?= h($license->uuid) ?></td>
                <td><?= h($license->serial) ?></td>
                <td><?= h($license->started) ?></td>
                <td><?= h($license->expired) ?></td>
                 <td><?= h($license->is_active) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Activate'), ['action' => 'activate', $license->id]) ?>
                    <?= $this->Html->link(__('Deactivate'), ['action' => 'deactivate', $license->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $license->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $license->id], ['confirm' => __('Are you sure you want to delete # {0}?', $license->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
