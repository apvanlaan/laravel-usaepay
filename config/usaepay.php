<?php

return [
    'apikey' => env('EPAYAPI'),
    'pin' => env('EPAYPIN'),
    'publickey'=> env('EPAYPUBLIC'),
    'epaysub' => env('EPAY_SUB'),
    'endpoint' => env('EPAY_ENDPOINT'),
    'capture_type'=>'reauth' // {'','error','reauth','override'}

];