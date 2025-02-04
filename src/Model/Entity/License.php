<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * License Entity
 *
 * @property int $id
 * @property int $client_id
 * @property string $type
 * @property string $uuid
 * @property string $serial
 * @property string $subscription_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $is_active
 *
 * @property \App\Model\Entity\Client $client
 */
class License extends Entity
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
