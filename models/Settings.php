<?php namespace KurtJensen\Eggs\Models;

use Model;

/**
 * Settings Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'eggs_settings';
    public $settingsFields = 'fields.yaml';

    public function initSettingsData()
    {
        $this->products = implode("\n",
            [
                'Dozen Eggs',
            ]
        );
        $this->default_price = '4.00';
    }

}
