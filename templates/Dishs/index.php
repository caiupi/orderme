<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dish[]|\Cake\Collection\CollectionInterface $dishs
 */
?>
<div class="dishs index content">
    <?= $this->Html->link(__('Login'), ['controller'=>'Users','action' => 'login'], ['class' => 'button float-right']) ?>
    <h3><?= __('Menu') ?></h3>
    <h4 align="center"><?= __('Dishes') ?></h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dishes as $dish): ?>
                <tr>
                    <td><?= h($dish->name) ?></td>
                    <td><?= h($dish->description) ?></td>
                    <td><?= h($dish->type) ?></td>
                    <td><?= $this->Number->format($dish->price) ?></td>
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
