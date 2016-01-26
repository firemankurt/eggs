<?php namespace KurtJensen\Eggs\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreatePeepsTable extends Migration
{

    public function up()
    {
        Schema::create('kurtjensen_eggs_peeps', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kurtjensen_eggs_peeps');
    }

}
