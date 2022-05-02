<?php namespace KSV\Services\Components;

use Cms\Classes\ComponentBase;;
use RainLab\Pages\Classes\MenuItemReference;

use KSV\Services\Models\Category as CategoryModel;
use KSV\Services\Models\Item as ItemModel;

/**
 * Item Component
 */
class Item extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Страница услуги',
            'description' => 'Отображает страницу услуг и ее контент'
        ];
    }

    public function defineProperties()
    {
        return [
            'slugCategory' => [
                'title'       => 'Ссылка категории',
                'default'     => '{{ :category }}',
            ],
            'slugItem' => [
                'title'       => 'Ссылка услуги',
                'default'     => '{{ :item }}',
            ]
        ];
    }

    public function onRun()
    {   
        $category = CategoryModel::where('slug', $this->property('slugCategory'))->first();

        if (empty($category)){
            return $this->controller->run('404');
        }

        $item = ItemModel::where('category_id', $category->id)->where('slug', $this->property('slugItem'))->first();

        if (empty($item)){
            return $this->controller->run('404');
        }

        $this->addCss("/plugins/reazzon/editor/assets/css/editorjs.css");

        $this->page['item'] = $item;

        $this->page->title = $item->name;

        $refCategory = new MenuItemReference(); 
        $refCategory->title = $category->name; 
        $refCategory->url = $this->page->controller->pageUrl("services/category", ["category" => $category->slug, "item" => null]); 
        $refCategory->isActive = false; 
        $refCategory->viewBag = null; 
        $refCategory->code = null; 

        $refItem = new MenuItemReference(); 
        $refItem->title = $item->name; 
        $refItem->url = $this->page->currentPageUrl(); 
        $refItem->isActive = true; 
        $refItem->viewBag = null; 
        $refItem->code = null; 

        $breadcrumbs[] = $refCategory;
        $breadcrumbs[] = $refItem; 
        $this->breadcrumbs = $this->page['breadcrumbs'] = $breadcrumbs;
    }
}
