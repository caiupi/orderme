<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dish $dish
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $dish->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $dish->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Dishs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="dishs form content">
            <?= $this->Form->create($dish) ?>
            <fieldset>
                <legend><?= __('Edit Dish') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('type');
                    echo $this->Form->control('price');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
