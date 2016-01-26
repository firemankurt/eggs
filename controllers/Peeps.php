<?php namespace KurtJensen\Eggs\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Peeps Back-end Controller
 */
class Peeps extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('KurtJensen.Eggs', 'eggs', 'peeps');
    }
}