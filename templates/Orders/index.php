<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */
?>
<div class="orders index content">
    <?= $this->Html->link(__('Payment'), ['action' => 'payment'],
        ['confirm' => 'Are you sure, your action will delete the order and make the payment?','class' => 'button float-right']) ?>
    <h3><?= __('Your orders: '.$user->name) ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('dish_id') ?></th>
                <th><?= $this->Paginator->sort('order->dish->price', 'Price') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order->has('dish') ? $this->Html->link($order->dish->description, ['controller' => 'Dishs', 'action' => 'view', $order->dish->id]) : '' ?></td>
                    <td><?= $this->Number->format($order->dish->price) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $order->id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <h4 align="center"><?= __('Total price : € ');
            echo $total;
            ?>
        </h4>
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
