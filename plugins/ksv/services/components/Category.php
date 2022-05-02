<?php namespace KSV\Services\Components;

use Cms\Classes\ComponentBase;
use RainLab\Pages\Classes\MenuItemReference;
use Input;

use KSV\Services\Models\Category as CategoryModel;
use KSV\Services\Models\Item as ItemModel;

/**
 * Category Component
 */
class Category extends ComponentBase
{
    public $category;

    public function componentDetails()
    {
        return [
            'name' => 'Страница услуг',
            'description' => 'Отображает каталог услуг или категорию'
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'     => 'Ссылка категории',
                'default'   => '{{ :category }}',
            ],
            'perPage' => [
                'title'         => 'Количество',
                'description'   => 'Количество элементов на странице',
                'default'       => '9'
            ],
            'pageNumber' => [
                'title'       => 'Номер страницы',
                'description' => 'Номер текущей страницы',
                'type'        => 'string',
                'default'     => '{{ :page }}',
            ],
            'type' => [
                'title'       => 'Тип страницы',
                'description' => 'Показывать категорию или католог',
                'type'        => 'dropdown',
                'default'     => 'catalog',
            ],
        ];
    }

    public function getTypeOptions() {
        return [
            'catalog' => 'Каталог',
            'category' => 'Категория'
        ];
    }

    public function onRun()
    {  
        $this->page['categories'] = CategoryModel::get();

        if ($this->property('type') == 'catalog') {
            $this->page['items'] = $this->loadItems();
        } else {
            $this->category = CategoryModel::where('slug', $this->property('slug'))->first();
            
            $this->page->title = $this->category->name;
        
            if (empty($this->category)){
                return $this->controller->run('404');
            }
  
            $this->page['items'] = $this->loadItems(); 
        }     
        
        $reference = new MenuItemReference(); 
        $reference->title = $this->page->title; 
        $reference->url = $this->page->currentPageUrl(); 
        $reference->isActive = true; 
        $reference->viewBag = null; 
        $reference->code = null; 
        $breadcrumbs[] = $reference; 
        $this->breadcrumbs = $this->page['breadcrumbs'] = $breadcrumbs;
    }

    public function loadItems()
    {
        $options = [];

        if ($this->category != null) {
            $options += ['category'=> $this->category->id];
        }    

        $options += ['page'    => $this->property('pageNumber')];
        $options += ['perPage' => $this->property('perPage')];

        $items = ItemModel::listFrontEnd($options);

        return $items;
    }

    public function onLoadMore()
    {
        $pageNumber = Input::get('page') + 1;

        $this->setProperty('pageNumber', $pageNumber);
        $this->onRun();

        if ($pageNumber < $this->loadItems()->lastPage()) {
            $more_link = $this->renderPartial('@btnloadmore.htm', ['pageNumber' => $pageNumber]);
        } else {
            $more_link = ''; 
        }

        return [
            '@#list'         => $this->renderPartial('@list.htm'),
            '#btn-load-more' => $more_link,
        ];
    }
}