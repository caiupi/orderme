<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart[]|\Cake\Collection\CollectionInterface $carts
 */
?>
<div class="row">
    <div class="dishs index content">
        <h3><?= __('Add the dishes to the cart') ?></h3>
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
            ['confirm' => 'Are you sure to press order?','class' => 'button float-right']) ?>
        <h3><?= __('Your Cart') ?></h3>
        <h4><?= __('Desk: ') ?>
            <?= __($desk) ?>
        </h4>

        <div class="table-responsive">
            <table>
                <thead>
                <tr>
                    <th><?= $this->Paginator->sort('dish_id') ?></th>
                    <!-- <th><?= $this->Paginator->sort('quantity') ?></th> -->
                    <th class="actions"><?= __('Action') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($carts as $cart): ?>
                    <tr>
                        <td><?= $cart->dish->name ?></td>
                        <!-- <td><?= $this->Number->format($cart->quantity) ?></td> -->
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $cart->id], ['confirm' => __('Are you sure you want to delete the item?', $cart->id)]) ?>
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
