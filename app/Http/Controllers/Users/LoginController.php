<?php
/**
 * Controlador que proporciona logica para las acciones de login y logout.
 *
 * Controlador que proporciona logica para las acciones de login y logout.
 * 
 * @version 1.0.0
 * @author Sergio Sinuco
 * @license Datatraffic General License
 * @copyright Datatraffic S.A.S.
 */

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users\User;
use App\Models\Users\UserToken;
use Carbon\Carbon;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Verifica el usuario y contraseña dados. Si son correctos genera un access token y un refresh token.
     * <p>
     * Ejemplo: 
     * </p>
     * </p>
     * <p>JSON DE ENTRAA</p>
     * <p>
     * {
     *"user": "juan",
     *"password": "e10adc3949ba59abbe56e057f20f883e",
     *"imei": "XCVSDF2343"
     *}
     * </p>
     * <p>JSON DE SALIDA</p>
     * <p>
     * {
     * "error": false,
     * "msg": "OK",
     * "access_token": "OrrotWVZJXyGx42RnnBkdtXrwrk2gTrtVUuBr5dJiwPJtN3X",
     * "refresh_token": "q16d7NHS2b3M8OTgTKqbgBoRKsZahUWqk3tuTujHqjETS6dq",
     * "valid_until": "2015-07-08 15:00:00"
     * }
     * </p>
     *
     * @param Request $request
     *
     * @return Array
     *
     */
    public function login(Request $request)
    {
        $resp = array();
        $status = 200;
        $resp['error'] = true;
        $resp['msg'] = 'Ocurrió un error';
        $resp['access_token'] = null;
        $resp['refresh_token'] = null;
        
        $in = json_decode($request->getContent());
        $imei = $request->header('X-imei');
        
        if(property_exists($in,'user') && property_exists($in,'password'))// && !is_null($imei))
        {
            $user = User::where('login','=',$in->user)->where('password','=',$in->password)->first();
            if($user)
            {
                $access_token = $this->generateToken();
                $refresh_token = $this->generateToken();
                
                $userToken = new UserToken();
                $userToken->access_token = $access_token;
                $userToken->refresh_token = $refresh_token;
                $userToken->id_user = $user->id_user;
                $userToken->imei = $imei;
                $userToken->save();
                
                $hoy = Carbon::now();
                $hoy->addDay();
                
                $resp['error'] = false;
                $resp['msg'] = 'OK';
                $resp['access_token'] = $access_token;
                $resp['refresh_token'] = $refresh_token;   
                $resp['valid_until'] = $hoy->toDateTimeString();
            }
            else
            {
                $status = 401;
                $resp['msg'] = 'Login y/o password inválidos';
            }
        }
        else
        {
            $resp['msg'] = 'El login y/o password son obligatorios';
        }
        
        return (new Response($resp, $status));        
    }
    
    /**
     * Genera un string aleatorio de numeros y letras en minuscula y mayuscula de la longitud especificada.
     *
     * @param integer $length
     *
     * @return String
     *
     */
    private function generateToken($length = 48) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }    
}