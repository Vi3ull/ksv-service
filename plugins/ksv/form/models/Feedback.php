<?php namespace KSV\Form\Models;

use Model;

/**
 * Feedback Model
 */
class Feedback extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'ksv_form_feedback';

    protected $fillable = ["name", "phone", "email", "form_message"];

    public $rules = [];
}
