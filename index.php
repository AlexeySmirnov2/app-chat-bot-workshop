<?php

// quations 
$questions = array(
    array("1", "Kaip vaidimi zmonės, kurie plaukioja laivaias ir plėšia kitus laivus?", 
        "Degeneratai", "Piratai", "Seimūnai", 
        'atsakymas' => "Piratai"),
    array("2", "Koks chemines lenteles elementas pavadintas piktos dvasios, nykstuko vardu? ",
        "Hafnis",
        "Kobaltas",
        "Berilis", 'atsakymas' => "Kobaltas"),
    array("3", "Mažiausia valstybė pagal gyventoju skaiciu? ",
        "Nauru",
        "Niujė",
        "Vatikanas", 'atsakymas' => "Vatikanas")
);
$countQ = count($questions);
//


include (__DIR__ . '/vendor/autoload.php');

$access_token = 'EAAB9YNjCHZAwBAEZASyECF61eZAzIm9PHIqlqVZAYHdZC5pPHBImBOejZA3y8QPNZA1xvFKDpQsEnuJxM5QLIHmsJcQ4t9ZButeYDJwvZCDWi8kgYa8KQ8e2Q4XpE2BAzPmnhtmELiJKN9L1KRSoiLftaRGAMH1tdN4UZAZCyUqdozzWgZDZD';
$verify_token = 'TOKEN';
$appId = '137854906932636';
$appSecret = '3ecc648d697ebbd840902a14b8f044d5';


// for ($i=0; $i < $countQ; $i++) {


// }
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

$fb = new \Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => $appSecret,
]);

if(strcasecmp( $message, "start") == 0 ) {

$i=0;

$arteisingai = 1;
$teisingai = "";
if(strcasecmp( $message, $questions[$i]['atsakymas']) == 0 ) {
    $arteisingai = 0;
    $teisingai = "Taip";
}

if($arteisingai == 0) {
    
//     $fb2 = new \Facebook\Facebook([
//         'app_id' => $appId,
//         'app_secret' => $appSecret,
//     ]);
    
    $data = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => 'Teisinga'
        ]
    ];
    $response = $fb->post('/me/messages', $data, $access_token);
}



$data = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
        'text' => $questions[$i][0] . ': ' . $questions[$i][1] .' '.$teisingai
    ]
//     'tag' => 'SHIPPING_UPDATE',
];
$response = $fb->post('/me/messages', $data, $access_token);

$data = [
//     'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => $sender,
    ],
    'message' => [
        'text' => 'Galimi atsakymai: ',
        'quick_replies' => [
            [
                'content_type' => 'text',
                'title' => $questions[$i][2],
                'payload' => '<POSTBACK_PAYLOAD>',
            ],
            [
                'content_type' => 'text',
                'title' => $questions[$i][3],
                'payload' => '<POSTBACK_PAYLOAD>',
            ],
            [
                'content_type' => 'text',
                'title' =>  $questions[$i][4],
                'payload' => '<POSTBACK_PAYLOAD>',
            ]
        ]
    ]
];

$response = $fb->post('/me/messages', $data, $access_token);

// sleep(10); // 20s
} else {
    
    $data = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => $sender,
        ],
        'message' => [
            'text' => "Papuga: " . $message
        ]
        //     'tag' => 'SHIPPING_UPDATE',
    ];
    $response = $fb->post('/me/messages', $data, $access_token);
}
