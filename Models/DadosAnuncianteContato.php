<?php

namespace Modules\Anuncio\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class DadosAnuncianteContato extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

}
