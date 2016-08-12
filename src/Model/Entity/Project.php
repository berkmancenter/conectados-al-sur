<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity
 *
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property string $description
 * @property string $url
 * @property string $contribution
 * @property string $contributing
 * @property string $organization
 * @property int $organization_type_id
 * @property int $project_stage_id
 * @property int $country_id
 * @property int $city_id
 * @property float $latitude
 * @property float $longitude
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $start_date
 * @property \Cake\I18n\Time $finish_date
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\OrganizationType $organization_type
 * @property \App\Model\Entity\ProjectStage $project_stage
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\City $city
 * @property \App\Model\Entity\Category[] $categories
 */
class Project extends Entity
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
