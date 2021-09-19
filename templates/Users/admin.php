<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<nav class="nav">
    <div class="nav">
        Admin menu
        <h4 style="text-align:center">
            <?= $this->Html->link('AdminUsers', ['controller' => 'users', 'action' => 'admin']) ?> |
            <?= $this->Html->link('Carts', ['controller' => 'carts', 'action' => 'index']) ?> |
            <?= $this->Html->link('Orders', ['controller' => 'orders', 'action' => 'index']) ?> |
            <?= $this->Html->link('Dishes', ['controller' => 'dishs', 'action' => 'index']) ?> |
            <?= $this->Html->link('Desks', ['controller' => 'desks', 'action' => 'index']) ?>|
            <?= $this->Html->link('Login', ['controller' => 'users', 'action' => 'login']) ?>|
            <?= $this->Html->link('Logout', ['controller' => 'users', 'action' => 'logout']) ?>
        </h4>
    </div>
</nav>
<p>Welcome <?= $user ?></p>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('email') ?></th>
                <th><?= $this->Paginator->sort('password') ?></th>
                <th><?= $this->Paginator->sort('role') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->password) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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


