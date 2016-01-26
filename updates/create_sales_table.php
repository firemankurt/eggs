<?php namespace KurtJensen\Eggs\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateSalesTable extends Migration
{

    public function up()
    {
        Schema::create('kurtjensen_eggs_sales', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('peep_id')->unsigned()->nullable()->index();
            $table->string('description')->nullable()->index();
            $table->integer('qty')->unsigned()->nullable();
            $table->decimal('amount', 5, 2);
            $table->decimal('total', 6, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kurtjensen_eggs_sales');
    }

}
