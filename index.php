<?php

// quations 
$questions = array(
    array("1", "Kaip vaidimi zmonės, kurie plaukioja laivaias ir plėšia kitus laivus?", 
        "Degeneratai", "Piratai", "Seimūnai", 
        'atsakymas' => "Piratai"),
    array("4", "Koks chemines lenteles elementas pavadintas piktos dvasios, nykstuko vardu? ",
        "Hafnis",
        "Kobaltas",
        "Berilis", 'atsakymas' => "Kobaltas"),
    array("5", "Mažiausia valstybė pagal gyventoju skaiciu? ",
        "Nauru",
        "Niujė",
        "Vatikanas", 'atsakymas' => "Vatikanas")
);
$countQ = count($questions);
//


include (__DIR__ . '/vendor/autoload.php');

$access_token = 'EAAB9YNjCHZAwBADOe5Qslk6rBlKvgZBbV3H3eefwZADSRv4mCq4w6jnrXYZCruuhTtkqQWjfc00iq6ArpT4XZBEZA2heuVlBjCyz1T3ZBHxGcQTzX70JspSVLXTXlWzlfxqb4ZBBHdSrxqTf9mdCW1qmFbAbHKBXEGSlSYTugjN1PQZDZD';
$verify_token = 'TOKEN';
$appId = '137854906932636';
$appSecret = '3ecc648d697ebbd840902a14b8f044d5';



if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    if ($_REQUEST['hub_verify_token'] === $verify_token) {
        echo $challenge; die();
    }
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
    exit;
}


$message = $input['entry'][0]['messaging'][0]['message']['text'];
$sender = $input['entry'][0]['messaging'][0]['sender']['id'];

$arteisingai = 1;
if(strcasecmp( $message, $questions[0]['atsakymas']) == 0 ) {
    $arteisingai = 0;
}

$fb = new \Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
]);

$data = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
        'text' => $questions[0][0] . ': ' . $questions[0][1]
    ]
];
$response = $fb->post('/me/messages', $data, $access_token);


$data = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
        'text' => 'Galimi atsakymai: ',
        'quick_replies' => [
            [
                'content_type' => 'text',
                'title' => $questions[0][2],
                'payload' => '<POSTBACK_PAYLOAD>',
            ],
            [
                'content_type' => 'text',
                'title' => $questions[0][3],
                'payload' => '<POSTBACK_PAYLOAD>',
            ],
            [
                'content_type' => 'text',
                'title' =>  $questions[0][4],
                'payload' => '<POSTBACK_PAYLOAD>',
            ]
        ]
    ]
];

$response = $fb->post('/me/messages', $data, $access_token);


if($arteisingai == 0) {
    
    $data2 = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => 'Teisinga'
        ]
    ];
    $response = $fb->post('/me/messages', $data2, $access_token);
}