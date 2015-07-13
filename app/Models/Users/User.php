<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa un usuario.
 * 
 * @property integer $id_user LLave primaria
 * @property String $login Nombre de usuario
 * @property String $password Contraseña
 * 
 * @version 1.0.0
 * @author Sergio Sinuco
 * @license Datatraffic General License
 * @copyright Datatraffic S.A.S.
 */
class User extends Model
{
    /**
     * Nombre de la tabla
     * @var String 
     */    
    protected $table = 'users.user';
    
    /**
     * Nombre de la columna que representa la llave primaria
     * @var String 
     */    
    protected $primaryKey = 'id_user';  
        
    /**
     * Indica si la tabla tiene las columnas created_at, updated_at y deleted_at
     * @var Boolean
     */    
    public $timestamps = false;
}
