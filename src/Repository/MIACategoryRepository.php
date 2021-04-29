<?php 

namespace Mia\Blog\Repository;

use \Illuminate\Database\Capsule\Manager as DB;
use Mia\Blog\Model\MIACategory;

class MIACategoryRepository
{
    /**
     * 
     * @param \Mia\Database\Query\Configure $configure
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function fetchByConfigure(\Mia\Database\Query\Configure $configure)
    {
        $query = MIACategory::select('mia_blog_category.*');
        
        if(!$configure->hasOrder()){
            $query->orderByRaw('id DESC');
        }
        $search = $configure->getSearch();
        if($search != ''){
            //$values = $search . '|' . implode('|', explode(' ', $search));
            //$query->whereRaw('(firstname REGEXP ? OR lastname REGEXP ? OR email REGEXP ?)', [$values, $values, $values]);
        }
        
        // Procesar parametros
        $configure->run($query);

        return $query->paginate($configure->getLimit(), ['*'], 'page', $configure->getPage());
    }
}