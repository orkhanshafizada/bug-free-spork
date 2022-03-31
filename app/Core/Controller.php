<?php
/**
 * Home Controller
 *
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author  Orkhan Shafizada
 */

namespace App\Core;

class Controller
{
    /**
     * @param string $path
     * @param array $data
     * @return void
     */
    public function view(string $path, array $data){
        $file_path = realpath('.') . '/app/Views/' . $path . '.php';
        if (!file_exists($file_path)) {
            exit($file_path . " not found!");
        }
        extract($data);

        require($file_path);
    }
}