<?php namespace KurtJensen\Eggs\Models;

use Form;
use Model;

/**
 * Peeps Model
 */
class Peep extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'kurtjensen_eggs_peeps';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['*'];

    /**
     * @var array Relations
     */
    public $hasMany = ['sale' => ['KurtJensen\Eggs\Models\Sale', 'table' => 'kurtjensen_eggs_sales']];

    /**
     * @var array Cache for nameList() method
     */
    protected static $nameList = [];

    public static function getNameList($includeBlank = false)
    {
        if (count(self::$nameList)) {
            return self::$nameList;
        }

        $list = self::orderBy('name')->lists('name', 'id');
        if ($includeBlank) {
            $list = [0 => '- Select One -'] + $list;
        }

        return self::$nameList = $list;
    }

    public static function selector($selectedValue = null, $options = [], $name = 'peep_id', $includeBlank = true)
    {
        return Form::select($name, self::getNameList($includeBlank), $selectedValue, $options);
    }

}
