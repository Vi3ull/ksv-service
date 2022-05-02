<?php namespace KSV\Form\Models;

use Model;

/**
 * Callback Model
 */
class Callback extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'ksv_form_callbacks';

    protected $fillable = ["name", "phone"];

    public $rules = [];
}
