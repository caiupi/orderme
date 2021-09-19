<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart[]|\Cake\Collection\CollectionInterface $carts
 */
?>
<div class="row">
    <div class="dishs index content">
        <h3><?= __('Add the dishs to the cart') ?></h3>
        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php /** @var Dish $dishs */
                foreach ($dishs as $dish): ?>
                    <tr>
                        <td><?= h($dish->name) ?></td>
                        <td><?= h($dish->description) ?></td>
                        <td><?= h($dish->type) ?></td>
                        <td><?= $this->Number->format($dish->price) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Add To Cart'), ['action' => 'add', $dish->id]) ?>
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
    <div class="carts index content">
        <?= $this->Html->link(__('Press order'), ['controller' => 'Orders', 'action' => 'press'],
            ['confirm' => 'Are you sure?','class' => 'button float-right']) ?>
        <h3><?= __('Carts') ?></h3>
        <h4><?= __('Desk: ') ?>
            <?= __($desk) ?>
        </h4>

        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('dish_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($carts as $cart): ?>
                    <tr>
                        <td><?= $this->Number->format($cart->id) ?></td>
                        <td><?= $cart->has('user') ? $this->Html->link($cart->user->name, ['controller' => 'Users', 'action' => 'view', $cart->user->id]) : '' ?></td>
                        <td><?= $cart->has('dish') ? $this->Html->link($cart->dish->name, ['controller' => 'Dishs', 'action' => 'view', $cart->dish->id]) : '' ?></td>
                        <td><?= $this->Number->format($cart->quantity) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $cart->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cart->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cart->id)]) ?>
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
</div>
