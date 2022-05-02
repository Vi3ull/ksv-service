<?php namespace KSV\Services\Models;

use Model;

/**
 * Item Model
 */
class Item extends Model
{

    public function scopeListFrontEnd($query, $options = []) 
    {
        extract(array_merge([
            'page'    => 1,
            'perPage' => 9,
            'category' => null
        ], $options));

        if ($category) {
            $query->where('category_id', $category);
        }

        return $query->paginate($perPage, $page);
    }

    /**
     * @var string table associated with the model
     */
    public $table = 'ksv_services_items';

    /**
     * @var array dates attributes that should be mutated to dates
     */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    /**
     * @var array hasOne and other relations
     */
    public $belongsTo = [
        'category' => ['KSV\Services\Models\Category']
    ];

    public $implement = [
        'ReaZzon.Editor.Behaviors.ConvertToHtml'
    ];

    public function getDescriptionHtmlAttribute()
    {
        return $this->convertJsonToHtml($this->description);
    }
}
