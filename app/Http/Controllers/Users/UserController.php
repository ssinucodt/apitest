<?php

/**
  The MIT License (MIT)

  Copyright (c) <Taylor Otwell>

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
 */

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users\User;

/**
 * A summary informing the user what the associated element does.
 *
 * A *description*, that can span multiple lines, to go _in-depth_ into the details of this element
 * and to provide some background information or textual references.
 *
 * @version
 * @author
 * @license
 * @copyright
 */
class UserController extends Controller {
    
    public function index()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO2";
        
        return $resp;
    }
    
    public function store()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO2";
        
        return $resp;
    }
    
    public function create()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO";
        
        return $resp;
    }  
    
    public function show()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO";
        
        return $resp;
    }    
    
    public function edit()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO";
        
        return $resp;
    }  
    
    public function update()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO";
        
        return $resp;
    }    
    
    public function destroy()
    {
        $resp = array();
        $resp['msg'] = "HOLA MUNDO";
        
        return $resp;
    }    
}