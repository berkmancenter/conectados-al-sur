<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Subcontinent Entity
 *
 * @property int $id
 * @property string $name
 * @property string $name_es
 * @property int $continent_id
 *
 * @property \App\Model\Entity\Continent $continent
 * @property \App\Model\Entity\Country[] $countries
 */
class Subcontinent extends Entity
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
        'id' => false
    ];
}
