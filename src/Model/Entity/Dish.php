<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dish Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property int $price
 *
 * @property \App\Model\Entity\Cart[] $carts
 * @property \App\Model\Entity\Order[] $orders
 */
class Dish extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'description' => true,
        'type' => true,
        'price' => true,
        'carts' => true,
        'orders' => true,
    ];
}
