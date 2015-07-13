<?php
/**
 * Controlador que proporciona metodos para las operaciones CRUD de posiciones
 *
 * @author    Sergio Sinuco <sergiosinuco@datatraffic.com.co>
 * @copyright 2000-2015 Datatraffic S.A.S.
 * @license   Datatraffic http://www.datatraffic.com.co/licenses
 * @version   1.0.0
 */

namespace App\Http\Controllers\Positions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Positions\Position;
use App\Models\Users\UserToken;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;

class PositionController extends Controller
{
    /**
     * Lista, orderna y pagina las posiciones segun las opciones especificadas
     *
     * <p>Ejemplo:</p>
     * <p>JSON DE ENTRADA:</p>
        {
          "filter": [
            {
              "field": "updatetime",
              "comparison": "gte",
              "value": "2015-07-07"
            },
            {
              "field": "updatetime",
              "comparison": "lte",
              "value": "2015-07-08"
            }
          ],
          "sort": [
            {
              "field": "updatetime",
              "direction": "ASC"
            }
          ],
          "page": 1,
          "limit": 2
        }
     * <p>
     * </p>
     * <p>JSON DE SALIDA:</p>
        {
          "error": false,
          "msg": "OK",
          "data": {
            "total": 10,
            "per_page": 2,
            "current_page": 1,
            "last_page": 5,
            "from": 1,
            "to": 2,
            "data": [
              {
                "id_position": 2,
                "id_user": 1,
                "latitude": "4.712",
                "longitude": "-74.454",
                "updatetime": "2015-07-07 16:35:00"
              },
              {
                "id_position": 1,
                "id_user": 1,
                "latitude": "4.712",
                "longitude": "-74.454",
                "updatetime": "2015-07-07 16:35:00"
              }
            ]
          }
        }
     * <p>
     * </p>
     *
     * @param Request $request
     *
     * @return Json
     */
    public function index(Request $request)
    {
        $resp = array();
        $status = 200;
        $resp['error'] = true;
        $resp['msg'] = 'Ocurrió un error';
        $resp['data'] = null;
        
        $access_token = $request->header('X-Session-Token');
        $imei = $request->header('X-imei');
        $os = $request->header('X-OS');
                
        if (!is_null($imei) && !is_null($os) && !is_null($access_token)) {
            $user = UserToken::where('access_token', '=', $access_token)->where('is_valid', '=', true)->where('ts_valid_until', '>=', 'NOW()')->first();
            if ($user) {
                $posiciones = new Position();
                $posiciones = $posiciones->where('id_user', '=', $user->id_user);
                
                if ($request->has('filters')) {
                    $filtros = json_decode($request->input('filters'), false);
                    foreach ($filtros as $filtro) {
                        $campo = $filtro->field;
                        $operador = $filtro->comparison;
                        
                        switch ($operador) {
                            case 'eq':
                                $operador = '=';
                                break;
                            case 'lt':
                                $operador = '<';
                                break;
                            case 'gt':
                                $operador = '>';
                                break;
                            case 'lte':
                                $operador = '<=';
                                break;
                            case 'gte':
                                $operador = '>=';
                                break;
                            default:
                                $operador = '=';
                                break;
                        }
                        
                        $valor = $filtro->value;
                        $posiciones = $posiciones->where($campo, $operador, $valor);
                    }
                }
                
                if ($request->has('sort')) {
                    $sorts = json_decode($request->input('sort'), false);
                    foreach ($sorts as $sort) {
                        $campo = $sort->field;
                        $direccion = $sort->direction;
                        
                        $posiciones = $posiciones->orderBy($campo, $direccion);
                    }
                }
                
                if ($request->has('page')) {
                    $page = json_decode($request->input('page'), false);
                } else {
                    $page = 1;
                }
                Input::merge(array('page' => $page));
                
                if ($request->has('limit')) {
                    $limit = json_decode($request->input('limit'), false);
                } else {
                    $limit = 2;
                }
                
                $coleccion = $posiciones->paginate($limit);
                $status = 200;
                $resp['error'] = false;
                $resp['msg'] = 'OK';
                $resp['data'] = array();
                $resp['data'] = $coleccion->toArray();
            } else {
                $resp['msg'] = 'Acess token inválido';
                $status = 401;
            }
        } else {
            $resp['msg'] = 'Faltan campos que son obligatorios';
        }
        
        return (new Response($resp, $status));
    }
       
    /**
     * Almacena un posicion con la informacion reportada en el json de entrada
     *
     * <p>Ejemplo:</p>
     * <p>JSON DE ENTRADA:</p>
     * <p>
        {
          "latitude": 4.712,
          "longitude": -74.454,
          "updatetime": "2015-07-07 16:35:00",
          "os": "android",
          "imei": "XCVSDF2343"
        }
     * </p>
     * <p>JSON DE SALIDA:</p>
     * <p>
        {
          "error": false,
          "msg": "OK",
          "data": {
            "id_position": 11
          }
        }
     * </p>
     *
     * @param Request $request
     *
     * @return Json
     */
    public function store(Request $request)
    {
        $status = 200;
        $resp = array();
        $resp['error'] = true;
        $resp['msg'] = 'Ocurrió un error';
        $resp['data'] = null;
        
        $in = json_decode($request->input('values'), false);
        $access_token = $request->header('X-Session-Token');
        $imei = $request->header('X-imei');
        $os = $request->header('X-OS');
        
        if (property_exists($in, 'latitude') && property_exists($in, 'longitude') && property_exists($in, 'updatetime') && !is_null($imei) && !is_null($os) && !is_null($access_token)) {
            $user = UserToken::where('access_token', '=', $access_token)->where('is_valid', '=', true)->where('ts_valid_until', '>=', 'NOW()')->first();
            if ($user) {
                $position = new Position();
                $position->latitude = $in->latitude;
                $position->longitude = $in->longitude;
                $position->id_user = $user->id_user;
                $position->updatetime = $in->updatetime;
                $position->save();
                
                $status = 201;
                $resp['error'] = false;
                $resp['msg'] = 'OK';
                $resp['data'] = array();
                $resp['data']['id_position'] = $position->id_position;
            } else {
                $resp['msg'] = 'Acess token inválido';
                $status = 401;
            }
        } else {
            $resp['msg'] = 'Faltan campos que son obligatorios';
        }
        return (new Response($resp, $status));
    }
}
