<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * InstancesUser Entity
 *
 * @property int $instance_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\Instance $instance
 * @property \App\Model\Entity\User $user
 */
class InstancesUser extends Entity
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
        '*' => true,
        'instance_id' => false,
        'user_id' => false
    ];
}
