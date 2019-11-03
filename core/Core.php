<?php
    class Core{
        public function run(){
            $url = '/';
            if(!empty($_GET['url'])) {
                $url .= $_GET['url'];
            }
            $params = array();
            if(!empty($url) && $url != "/"){
                $url = explode("/",$url);
                array_shift($url);
                $currentController = $url[0]."Controller";
                array_shift($url);
                if(isset($url) && !empty($url[0])){
                    $currentAction = $url[0];
                    array_shift($url);
                }else{
                    $currentAction = "index";
                }
                
                if(count($url) > 0){
                    $params = $url;
                }       
                //print_r($url);
                //echo "<hr>";
                
                
            }else{
                $currentController = "homeController";
                $currentAction = "index";
            }
            
            if(!file_exists("controllers/".$currentController.".php") || !method_exists($currentController, $currentAction)){
                $currentController = "notFoundController";
                $currentAction = "index";
            }
            $c = new $currentController();
            call_user_func_array(array($c,$currentAction),$params);
            
            
            /*
            echo "Controller:".$currentController."<br>";
            echo "Action:".$currentAction."<br>";
            echo "Params:".$params."<br>";
            */
        }
    }