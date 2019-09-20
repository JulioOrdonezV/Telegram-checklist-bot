<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/vendor/autoload.php';

$app = new \Slim\App();

$app->post('/message', function(Request $req, Response $res){
    $body = $req->getBody();
    $data = json_decode($body,true);
    $message = $data['message']['text'];
    $action = strtok($message, ' ');
    $text = strtolower(strtok(' '));

    if($text){
        if($action == '/checklist_add'){
            $fp = fopen('checklist.txt', 'a');
            fwrite($fp, $text . "\n");
            fclose($fp);
        }
        elseif($action == '/checklist_del'){
            $fcontent = file('checklist.txt');
            $result = array();
            foreach($fcontent as $line){
                if (strpos($line, $text) !== false){
                    continue;
                }
                $result[] = $line;
            }
            $fcontent = implode($result);
            $fp = fopen('checklist.txt','w');
            fwrite($fp, $fcontent);
            fclose($fp);
        }
    }
    if($action == '/checklist'){
        $url = 'https://api.telegram.org/botYOUR-BOT-API-KEY/sendMessage';
        $ch = curl_init($url);
        $checklist = file_get_contents('checklist.txt');
        $jsonData = json_encode(array(
                'chat_id' => $data['message']['chat']['id'],
                'text' => $checklist
            ));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);
        $res->getBody()->write($result);
        return $res;
    }
});
$app->run();
