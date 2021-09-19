<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cart $cart
 */
?>
<div class="row">

    <div class="column-responsive column-80">
        <div class="carts view content">
            <h3><?= h($cart->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cart->has('user') ? $this->Html->link($cart->user->name, ['controller' => 'Users', 'action' => 'view', $cart->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Dish') ?></th>
                    <td><?= $cart->has('dish') ? $this->Html->link($cart->dish->name, ['controller' => 'Dishs', 'action' => 'view', $cart->dish->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cart->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($cart->quantity) ?></td>
                </tr>
            </table>
        </div>
    </div>

</div>
