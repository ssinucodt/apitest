<?php

use Illuminate\Http\Request;

class PositionsTest extends TestCase{
    
    private $access_token;
    private $refresh_token;
    
    public function setUp()
    {
        parent::setUp();
        
        //Peticion
        $json = '{
                    "user": "juan",
                    "password": "e10adc3949ba59abbe56e057f20f883e"
                }';
        $method = 'POST';
        $uri = '/login';
        $parameters = [];
        $cookies = [];
        $files = [];
        $server = [];
        $content = $json;
        
        $request = Request::create(
            $uri, $method, $parameters,
            $cookies, $files, $server, $content
        );
        
        //Headers
        $request->headers->add(['X-imei'=>'asdfsr234']);        
        
        //Session
        $this->app['session']->start();
        $token = $this->app['session']->token();
        $request->headers->add(['X-CSRF-TOKEN'=>$token]);                
        
        //Hacer peticion
        $response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);
        
        //Asserts
        $obj = json_decode($response->getContent());
        
        if(!$obj->error)
        {
            $this->access_token = $obj->access_token;
            $this->refresh_token = $obj->refresh_token;
        }
    }
    
    /**
     * @covers App\Http\Controllers\Users\LoginController::login
     * @covers App\Http\Controllers\Users\LoginController::generateToken     
     * @covers App\Http\Controllers\Positions\PositionController::index
     */
    public function testGetPositions()
    {        
        //Peticion
        $method = 'GET';
        $uri = '/positions';
        
        $filters = '[
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
          ]';        
        $sort = '[
            {
              "field": "updatetime",
              "direction": "ASC"
            }
          ]';        
        $page = 1;
        $limit = 2;        
        $parameters = [
            'filters' => $filters,
            'sort' => $sort,
            'page' => $page,
            'limit' => $limit
        ];
        
        $cookies = [];
        $files = [];
        $server = [];
        $content = null;
        
        $request = Request::create(
            $uri, $method, $parameters,
            $cookies, $files, $server, $content
        );
        
        //Headers
        $request->headers->add(['X-imei'=>'asdfsr234']);        
        $request->headers->add(['X-OS'=>'android']);        
        $request->headers->add(['X-Session-Token'=>$this->access_token]);        
        
        //Session
        $this->app['session']->start();
        $token = $this->app['session']->token();
        $request->headers->add(['X-CSRF-TOKEN'=>$token]);                
        
        //Hacer peticion
        $response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);
        
        //Content
        $obj = json_decode($response->getContent());
        
        //Assets
        $this->assertFalse($obj->error);
        $this->assertEquals("OK", $obj->msg);
        $this->assertGreaterThan(0, $obj->data->total);
        $this->assertGreaterThan(0, count($obj->data->data));
        $item = $obj->data->data[0];
        $this->assertObjectHasAttribute('id_position',$item);
        $this->assertObjectHasAttribute('latitude',$item);
        $this->assertObjectHasAttribute('longitude',$item);
        $this->assertObjectHasAttribute('updatetime',$item);
    }
    
    /**
     * @covers App\Http\Controllers\Users\LoginController::login
     * @covers App\Http\Controllers\Users\LoginController::generateToken
     * @covers App\Http\Controllers\Positions\PositionController::store
     */
    public function testPostPositions()
    {        
        //Peticion
        $method = 'POST';
        $uri = '/positions';
        $str = '{
          "latitude": 4.712,
          "longitude": -74.454,
          "updatetime": "2015-07-07 16:35:00"
        }';
        $parameters = ['values'=>$str];
        $cookies = [];
        $files = [];
        $server = [];
        $content = null;
        
        $request = Request::create(
            $uri, $method, $parameters,
            $cookies, $files, $server, $content
        );
        
        //Headers
        $request->headers->add(['X-imei'=>'asdfsr234']);        
        $request->headers->add(['X-OS'=>'android']);        
        $request->headers->add(['X-Session-Token'=>$this->access_token]);        
        
        //Session
        $this->app['session']->start();
        $token = $this->app['session']->token();
        $request->headers->add(['X-CSRF-TOKEN'=>$token]);                
        
        //Hacer peticion
        $response = $this->app->make('Illuminate\Contracts\Http\Kernel')->handle($request);
        
        //Content
        $obj = json_decode($response->getContent());
        
        //Assets
        $this->assertFalse($obj->error);
        $this->assertEquals("OK", $obj->msg);
        $this->assertObjectHasAttribute('data',$obj);
        $this->assertObjectHasAttribute('id_position',$obj->data);
    }    
}
