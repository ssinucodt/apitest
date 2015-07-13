<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * Representa un token de sesion de un usuario.
 *
 * @property integer $id_user_token LLave primaria
 * @property String $id_user Usuario asociado al token
 * @property String $token_push_android Token push android
 * @property String $token_push_ios Token push ios
 * @property String $access_token Token de acceso
 * @property String $refresh_token Token de refresco
 * @property String $imei Imei del equipo
 * @property boolean $is_valid Indica si el token de acceso es valido
 * @property date $ts_valid_until Indica hasta que fecha y hora el token de acceso es valido
 * 
 * @version 1.0.0
 * @author Sergio Sinuco
 * @license Datatraffic General License
 * @copyright Datatraffic S.A.S.
 */
class UserToken extends Model
{
    /**
     * Nombre de la tabla
     * @var String 
     */    
    protected $table = 'users.user_token';
    
    /**
     * Nombre de la columna que representa la llave primaria
     * @var String 
     */     
    protected $primaryKey = 'id_user_token';    
    
    /**
     * Indica si la tabla tiene las columnas created_at, updated_at y deleted_at
     * @var Boolean
     */    
    public $timestamps = false;
}

