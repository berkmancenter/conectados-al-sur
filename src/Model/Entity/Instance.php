<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Instance Entity
 *
 * @property int $id
 * @property string $name
 * @property string $name_es
 * @property string $namespace
 * @property string $description
 * @property string $description_es
 * @property $logo
 * @property string $passphrase
 * @property bool $use_org_types
 * @property bool $use_user_genre
 * @property bool $use_user_organization
 * @property bool $use_proj_cities
 * @property bool $use_proj_stage
 * @property bool $use_proj_categories
 * @property bool $use_proj_description
 * @property bool $use_proj_url
 * @property bool $use_proj_contribution
 * @property bool $use_proj_contributing
 * @property bool $use_proj_organization
 * @property bool $use_proj_location
 * @property bool $use_proj_dates
 * @property int $proj_max_categories
 *
 * @property \App\Model\Entity\Category[] $categories
 * @property \App\Model\Entity\OrganizationType[] $organization_types
 * @property \App\Model\Entity\Project[] $projects
 * @property \App\Model\Entity\User[] $users
 */
class Instance extends Entity
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
