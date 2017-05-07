<?php

const TOKEN = "";
const TIMEOUT_REFRESH = 0.5;
const API_METHOD_URL = "https://api.vk.com/method/";

$messages_layers = [
    'вопрос' => 'ответ',
    'привет' => 'Это бот',
    'пока' => 'саси',
    '/help' => 'помощь'
];
while(true) {
    $j = json_decode(file_get_contents(API_METHOD_URL."messages.get?count=1&out=0&time_offset=30&v=5.62&access_token=" . TOKEN), true);
    //print_r($j);
    if(isset($j['response'])){
        $response = $j['response'];
        if(isset($response['items'])){
            $items = $response['items'];
            foreach ($items as $item){
                $text = strtolower($item['body']);
                $read_state = $item['read_state'];
                $user_id = $item['user_id'];
                $mid = $item['id'];
                foreach ($messages_layers as $key => $answer) {
                    if ($text == $key) {
                        $random_value = microtime(true);
                        $request_params = [
                            'user_id' => $user_id,
                            'random_id' => $random_value,
                            'message' => $answer,
                            'v' => '5.62',
                            'access_token' => TOKEN
                        ];
                        if ($mid !== $random_value) {
                            $url = API_METHOD_URL."messages.send?" . http_build_query($request_params);
                            file_get_contents($url);
                        }
                    }
                }
            }
        }
    }

    sleep(TIMEOUT_REFRESH);
}
?>
