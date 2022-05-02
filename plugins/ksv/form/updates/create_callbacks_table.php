<?php namespace KSV\Form\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateCallbacksTable Migration
 */
class CreateCallbacksTable extends Migration
{
    public function up()
    {
        Schema::create('ksv_form_callbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ksv_form_callbacks');
    }
}
