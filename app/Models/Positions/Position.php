<?php
namespace App\Models\Positions;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa una posicion.
 * 
 * @property integer $id_position LLave primaria
 * @property integer $id_user Usuario asociado a la posicion
 * @property double $latitude Latitud
 * @property double $longitude Longitud
 * @property date $updatetime Fecha y hora de la posicion
 * 
 * @version 1.0.0
 * @author Sergio Sinuco
 * @license Datatraffic General License
 * @copyright Datatraffic S.A.S.
 */
class Position extends Model
{
    /**
     * Nombre de la tabla
     * @var String 
     */
    protected $table = 'positions.position';
    
    /**
     * Nombre de la columna que representa la llave primaria
     * @var String 
     */
    protected $primaryKey = 'id_position';  
    
    /**
     * Indica si la tabla tiene las columnas created_at, updated_at y deleted_at
     * @var Boolean
     */
    public $timestamps = false;
}
