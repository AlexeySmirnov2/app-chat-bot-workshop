<?php

$questions = array(
    array("Kiek tau metu?", "40", "20"),
    array("Koks tavo svoris?", "20", "100")
);
$questionsC = count($questions);

include (__DIR__ . '/vendor/autoload.php');

// for connection
$access_token = 'EAAB9YNjCHZAwBAJQp02wRI75C1bJdRwLAQETebAOylqvDeyEkelTzq02lEWbD3eFutAuw0IM9C57kj5VQK0vgnZCydxRapZCOZBHnZBGZC6FZAJzDJu1Y1n7b2NyOqZAbnqyvsxP1WrZBzwaZClbvZBs9oVvCfIEoMufgq7rYsgPqCnBQZDZD';
$verify_token = 'TOKEN';
$appId = '137854906932636';
$appSecret = '3ecc648d697ebbd840902a14b8f044d5';

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    if ($_REQUEST['hub_verify_token'] === $verify_token) {
        echo $challenge; die();
    }
}

$input = json_decode(file_get_contents('php://input'), true); // to json

if ($input === null) {
    exit;
}

// // responce 2
// $sender = $input['entry'][0]['messaging'][0]['sender']['id']; // ???
// $data = [
//     'messaging_type' => 'RESPONSE', // type
//     'recipient' => [
//         'id' => $sender,
//     ],
//     'message' => [
//         'text' => 'lalalal',
//     ]
// ];

// $response = $fb->post(
//     '/me/messages', // ????
//     $data, //
//     $access_token); // key

// $client = new GuzzleHttp\Client();

    
// apdorojimas
$message = $input['entry'][0]['messaging'][0]['message']['text'];
$sender = $input['entry'][0]['messaging'][0]['sender']['id']; // ???

// connect for responce
$fb = new \Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
]);


// responce
$data = [
    'messaging_type' => 'RESPONSE', // type
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
//         'text' => 'You wrote: ' . $quations[0][0] . $message,
        'text' => 'Klausimas: ' . $questions[0][0],
    ]
];

$response = $fb->post(
    '/me/messages', // ????
    $data, // 
    $access_token); // key

    
