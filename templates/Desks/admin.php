<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Desk[]|\Cake\Collection\CollectionInterface $desks
 */
?>
<div class="desks index content">
    <?= $this->Html->link(__('New Desk'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Reserve the desk to make the order') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('available') ?></th>
                <th><?= $this->Paginator->sort('ordered') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($desks as $desk): ?>
                <tr>
                    <td><?= $this->Number->format($desk->id) ?></td>
                    <td><?= $desk->has('user') ? $this->Html->link($desk->user->name, ['controller' => 'Users', 'action' => 'view', $desk->user->id]) : '' ?></td>
                    <td><?= h($desk->isAvailable()) ?></td>
                    <td><?= h($desk->isOrdered()) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $desk->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $desk->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $desk->id], ['confirm' => __('Are you sure you want to delete # {0}?', $desk->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

