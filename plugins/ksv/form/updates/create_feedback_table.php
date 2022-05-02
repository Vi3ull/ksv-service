<?php namespace KSV\Form\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFeedbackTable Migration
 */
class CreateFeedbackTable extends Migration
{
    public function up()
    {
        Schema::create('ksv_form_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('form_message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ksv_form_feedback');
    }
}
