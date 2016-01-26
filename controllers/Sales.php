<?php namespace KurtJensen\Eggs\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Sales Back-end Controller
 */
class Sales extends Controller
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

        BackendMenu::setContext('KurtJensen.Eggs', 'eggs', 'sales');
    }
}