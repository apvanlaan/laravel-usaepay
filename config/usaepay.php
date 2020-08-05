<?php

return [
    'default'=> [
        'apikey' => env('EPAYAPI'),
        'publickey'=> env('EPAYPUBLIC'),
        'pin' => env('EPAYPIN', ''),
        'epaysub' => env('EPAY_SUB', 'sandbox'),
        'endpoint' => env('EPAY_ENDPOINT', 'v2'),
        'capture_type'=>'reauth', // {'','error','reauth','override'}
    ],
];
