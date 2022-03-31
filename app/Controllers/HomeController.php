<?php
/**
 * Home Controller
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author  Orkhan Shafizada
 */

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(){
        print 'Welcome';
    }
}