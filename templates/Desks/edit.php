<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Desk $desk
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $desk->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $desk->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Desks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="desks form content">
            <?= $this->Form->create($desk) ?>
            <fieldset>
                <legend><?= __('Edit Desk') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('available');
                    echo $this->Form->control('ordered');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
