<?php namespace KurtJensen\Eggs\Components;

use Cms\Classes\ComponentBase;
use KurtJensen\Eggs\Models\Peep;
use KurtJensen\Eggs\Models\Sale;
use KurtJensen\Eggs\Models\Settings;

class Invoice extends ComponentBase
{
    public $sales;
    public $sale;

    public $peeplist;
    public $prodlist;

    public function componentDetails()
    {
        return [
            'name' => 'Invoice Component',
            'description' => 'View and Add Invoices',
        ];
    }

    public function defineProperties()
    {
        return [
        ];
    }

    public function onRun()
    {
        $this->addJs('/modules/backend/formwidgets/datepicker/assets/js/build-min.js');
        $this->addCss('/modules/backend/formwidgets/datepicker/assets/css/datepicker.css');
        $this->addCss('/modules/backend/formwidgets/datepicker/assets/vendor/pikaday/css/pikaday.css');
        $this->addCss('/modules/backend/formwidgets/datepicker/assets/vendor/clockpicker/css/jquery-clockpicker.css');
        $this->sales = $this->page['sales'] = $this->loadSales();
        $this->onSalesTotal();
    }

    protected function loadSales()
    {
        $sales = Sale::with('peep')->orderBy('created_at')->simplePaginate(30);
        return $sales;
    }

    protected function onSalesTotal()
    {
        $year = $this->page['year'] = post('year') ? post('year') : date('Y');
        $this->page['salesTotals'] = Sale::where('created_at', '>=', $year . '-01-01 00:00:00')
             ->where('created_at', '<', $year + 1 . '-01-01 00:00:00')
             ->sum('total');
    }

    protected function getSale()
    {

        $saleId = post('id');

        if (!$saleId) {
            $sale = new Sale();
        } else {
            $sale = Sale::find($saleId);
        }
        return $sale;
    }

    protected function onForm()
    {
        if (!$sale = $this->getSale()) {
            return null;
        }

        $peep = isset($sale->peep_id) ? $sale->peep_id : 0;
        $this->peeplist = $this->page['peeplist'] = Peep::selector(
            $peep,
            array('class' => 'form-control custom-select',
                'id' => 'Form-field-sale-category_id')
        );

        $this->sale = $this->page['sale'] = $sale;
        list($this->page['defProduct']) = explode("\n", Settings::get('products', ''));
    }

    /**
     * Add a Customer
     */
    public function onNewCustomer()
    {
        $peep = new Peep();
        $peep->name = post('name');
        $peep->save();

        $this->peeplist = $this->page['peeplist'] = Peep::selector(
            $peep->id,
            array('class' => 'form-control custom-select',
                'id' => 'peep_id')
        );
    }

    /**
     * Update the sale
     */
    public function onUpdate()
    {
        if (!$sale = $this->getSale()) {
            return null;
        }
        $sale->peep_id = post('peep_id');
        $sale->description = post('description');
        $sale->qty = post('qty');
        $sale->amount = post('amount');
        $sale->created_at = post('created_at');
        $sale->total = post('total');
        $sale->save();

        $this->onRun();
    }

    protected function onDelete()
    {
        $saleId = post('id');

        if (!$saleId) {
            return null;
        }

        $sale = Sale::find($saleId);

        $sale->delete();

        $this->onRun();
    }

}
