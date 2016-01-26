<?php namespace KurtJensen\Eggs\Models;

use Carbon\Carbon;
use KurtJensen\Eggs\Models\Peep;
use KurtJensen\Eggs\Models\Settings;
use Model;

/**
 * Sales Model
 */
class Sale extends Model
{

    /**
     * @var array Cache Peeps.
     */
    public $peepOptions = [];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'kurtjensen_eggs_sales';

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
    public $belongsTo = ['peep' => ['KurtJensen\Eggs\Models\Peep', 'table' => 'kurtjensen_eggs_peeps']];

    public function getDescriptionOptions()
    {
        $desc = explode("\n", Settings::get('products'));
        return array_combine($desc, $desc);
    }

    public function getPeepIdOptions()
    {
        if (count($this->peepOptions)) {
            return $this->peepOptions;
        }

        return $this->peepOptions = Peep::orderBy('name')->lists('name', 'id');
    }

    public $attributes = [
        'total' => 0,
        'time' => 0,
        'date' => 0,
    ];

    public function getTotalAttribute()
    {
        return '$' . number_format($this->amount * $this->qty, 2, '.', '');
    }

    public function beforeSave()
    {
        $this->attributes['total'] = $this->amount * $this->qty;
        if (isset($this->created_at)) {
            $t = $this->created_at->format('H:i');
            $d = $this->created_at->toDateString();

            if ($this->time != $t || $this->date != $d) {
                $this->attributes['created_at'] = new Carbon($this->date . ' ' . $this->time);
            }
        } else {
            $this->attributes['created_at'] = new Carbon($this->date . ' ' . $this->time);
        }

        unset(
            $this->attributes['time'],
            $this->attributes['date']
        );
    }

    public function getTimeAttribute()
    {
        if (isset($this->created_at)) {
            return $this->created_at->format('H:i');
        }
    }

    public function getDateAttribute()
    {
        if (isset($this->created_at)) {
            return $this->created_at->toDateString();
        }

    }

}
