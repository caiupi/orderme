<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dish[]|\Cake\Collection\CollectionInterface $dishs
 */
?>
<div class="dishs index content">
    <?= $this->Html->link(__('New Dish'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Dishs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('description') ?></th>
                <th><?= $this->Paginator->sort('type') ?></th>
                <th><?= $this->Paginator->sort('price') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dishs as $dish): ?>
                <tr>
                    <td><?= $this->Number->format($dish->id) ?></td>
                    <td><?= h($dish->name) ?></td>
                    <td><?= h($dish->description) ?></td>
                    <td><?= h($dish->type) ?></td>
                    <td><?= $this->Number->format($dish->price) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $dish->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dish->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dish->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dish->id)]) ?>
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
