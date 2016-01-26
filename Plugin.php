<?php namespace KurtJensen\Eggs;

use Backend;
use System\Classes\PluginBase;

/**
 * Eggs Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Eggs',
            'description' => 'Record very simple sale invoices',
            'author' => 'KurtJensen',
            'icon' => 'icon-list-alt',
        ];
    }

    public function registerComponents()
    {
        return [
            'KurtJensen\Eggs\Components\Invoice' => 'Invoice',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'kurtjensen.eggs.peeps' => [
                'tab' => 'Eggs',
                'label' => 'peeps',
            ],
            'kurtjensen.eggs.sales' => [
                'tab' => 'Eggs',
                'label' => 'peeps',
            ],
            'kurtjensen.eggs.settings' => [
                'tab' => 'Eggs',
                'label' => 'settings',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return [
            'eggs' => [
                'label' => 'Eggs',
                'url' => Backend::url('kurtjensen/eggs/sales'),
                'icon' => 'icon-list-alt',
                'permissions' => ['kurtjensen.eggs.sales'],
                'order' => 500,
                'sideMenu' => [
                    'peeps' => [
                        'label' => 'People',
                        'icon' => 'icon-user',
                        'code' => 'send',
                        'owner' => 'KurtJensen.Eggs',
                        'url' => Backend::url('kurtjensen/eggs/peeps'),
                        'permissions' => ['kurtjensen.eggs.peeps'],
                    ],
                    'sales' => [
                        'label' => 'Egg Invoices',
                        'url' => Backend::url('kurtjensen/eggs/sales'),
                        'icon' => 'icon-list-alt',
                        'permissions' => ['kurtjensen.eggs.sales'],
                        'order' => 500,
                    ],
                    'settings' => [
                        'label' => 'Settings',
                        'url' => Backend::url('system/settings/update/kurtjensen/eggs/settings'),
                        'icon' => 'icon-gears',
                        'permissions' => ['kurtjensen.eggs.settings'],
                        'order' => 900,
                    ],
                ],
            ],

        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'Eggs',
                'description' => 'Configure Egg Sales.',
                'icon' => 'icon-linux',
                'category' => 'Eggs',
                'class' => 'KurtJensen\Eggs\Models\Settings',
                'order' => 100,
                'keywords' => 'eggs',
                'permissions' => ['kurtjensen.eggs.settings'],
            ],
        ];
    }

}
