<?php

namespace App;

use App\Product as Product;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use UxWeb\SweetAlert\SweetAlert as Alert;

class Product extends Model
{

    use Sortable;

    public $table = 'products';

    protected $fillable = [
        'id',
        'clave',
        'descripcion',
        'precio_lista',
        'm60',
        'm48',
        'm36',
        'm24',
        'm12',
        'apertura',
        'marca',
        'tipo',
        'categoria',
        'cilindrada'
    ];
                         
    public $sortable = [
        'clave',
        'marca',
        'descripcion',
        'precio_lista',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function transactions() {
    	return $this->hasMany('App\Transaction');
    }

}
