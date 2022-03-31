<?php
/**
 * User Controller
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author  Orkhan Shafizada
 */

namespace App\Controllers;

use App\Core\Controller;
use App\Core\DB;
use App\Models\Users;
use App\Core\Validation;

class UserController extends Controller
{
    /**
     * @return array|null
     */
    public function index(){
        $users = Users::all();

        print_r(json_decode(json_encode($users,true)));
    }

    /**
     * @param $request
     * @return array|false
     */
    public function store($request){
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => password_hash($request->password, PASSWORD_DEFAULT)
        ];

        $validation = new Validation();
        if (!$validation->validate([
            "Name" => [$request->fullname, "alphaNumWithSpaces|minLen(4)|maxLen(30)"],
            "Password" => [$request->password, "minLen(6)|password"],
            "Email" => [$request->email, "email|maxLen(50)"]])) {
            print_r($validation->errors());
            return false;
        }

        $user = Users::insert($data);

        print_r(json_decode(json_encode($user,true)));
    }
}