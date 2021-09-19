<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Desk $desk
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Desk'), ['action' => 'edit', $desk->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Desk'), ['action' => 'delete', $desk->id], ['confirm' => __('Are you sure you want to delete # {0}?', $desk->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Desks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Desk'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="desks view content">
            <h3><?= h($desk->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $desk->has('user') ? $this->Html->link($desk->user->name, ['controller' => 'Users', 'action' => 'view', $desk->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($desk->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Available') ?></th>
                    <td><?= $desk->available ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Ordered') ?></th>
                    <td><?= $desk->ordered ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Reserve Table') ?></th>
                    <td><?= $desk->available ? $this->Html->link(__('Reserve'), ['action' => 'reserve', $desk->id], ['class' => 'button'])
                            : __('Not possible'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
