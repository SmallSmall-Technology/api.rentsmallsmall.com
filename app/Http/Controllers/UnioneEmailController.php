<?php

namespace App\Http\Controllers;


class UnioneEmailController extends Controller
{
public function unioneEmail(){
require '../vendor/autoload.php';
$headers = array(
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
    'X-API-KEY' => '6tkb5syz5g1bgtkz1uonenrxwpngrwpq9za1u6ha',
);

$client = new \GuzzleHttp\Client([
    'base_uri' => 'https://eu1.unione.io/en/transactional/api/v1/'
]);

$requestBody = [
  "message" => [
    "recipients" => [
      [
        "email" => "dikcondtn@yahoo.com",
        "substitutions" => [
          "CustomerId" => 5761057,
          "to_name" => "Dove"
        ],
        "metadata" => [
          "campaign_id" => "c77f4f4e-3561-49f7-9f07-c35be01b4f43",
          "customer_hash" => "b253ac7"
        ]
      ]
    ],
    "template_id" => "936cc5e8-52e1-11ee-b5d3-eefdb2fabe59",
    "tags" => [
      "string1"
    ],
    "skip_unsubscribe" => 0,
    "global_language" => "en",
    "template_engine" => "simple",
    "global_substitutions" => [
      "property1" => "string",
      "property2" => "string"
    ],
    "global_metadata" => [
      "property1" => "string",
      "property2" => "string"
    ],
    "body" => [
      "html" => "<b>Hello, {{to_name}}</b>",
      "plaintext" => "Hello, {{to_name}}",
      "amp" => "<!doctype html><html amp4email><head> <meta charset=\"utf-8\"><script async src=\"https://cdn.ampproject.org/v0.js\"></script> <style amp4email-boilerplate>body[visibility:hidden]</style></head><body> Hello, AMP4EMAIL world.</body></html>"
    ],
    "subject" => "string",
    "from_email" => "cs@smallsmall.com",
    "from_name" => "John Smith",
    "reply_to" => "cs@smallsmall.com",
    "track_links" => 0,
    "track_read" => 0,
    "bypass_global" => 0,
    "bypass_unavailable" => 0,
    "bypass_unsubscribed" => 0,
    "bypass_complained" => 0,
    "headers" => [
      "X-MyHeader" => "some data",
      "List-Unsubscribe" => "<mailto: unsubscribe@smallsmall.com?subject=unsubscribe>, <http://www.smallsmall.com/unsubscribe/{{CustomerId}}>"
    ],
    "attachments" => [
      [
        "type" => "text/plain",
        "name" => "readme.txt",
        "content" => "SGVsbG8sIHdvcmxkIQ=="
      ]
    ],
    "inline_attachments" => [
      [
        "type" => "image/gif",
        "name" => "IMAGECID1",
        "content" => "R0lGODdhAwADAIABAP+rAP///ywAAAAAAwADAAACBIQRBwUAOw=="
      ]
    ],
    "options" => [
      "send_at" => "2023-09-16 23:24:00",
      "unsubscribe_url" => "https://example.org/unsubscribe/{{CustomerId}}",
      
    ]
  ]
];

try {
    $response = $client->request('POST','email/send.json', array(
        'headers' => $headers,
        'json' => $requestBody,
       )
    );
    print_r($response->getBody()->getContents());
 }
 catch (\GuzzleHttp\Exception\BadResponseException $e) {
    // handle exception or api errors.
    print_r($e->getMessage());
 }
}

}