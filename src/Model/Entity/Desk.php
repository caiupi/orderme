<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Desk Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property bool|null $available
 * @property bool|null $ordered
 *
 * @property \App\Model\Entity\User $user
 */
class Desk extends Entity
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
        'user_id' => true,
        'available' => true,
        'ordered' => true,
        'user' => true,
    ];
    function isAvailable(): string
    {
        if($this->available)
            return 'Yes';
        return 'No';
    }
    function isOrdered(): string
    {
        if($this->ordered)
            return 'Yes';
        return 'No';
    }

}
