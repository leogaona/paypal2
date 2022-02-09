<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class PayPalCardController extends Controller
{

    private $client;
    private $clientId;
    private $secret;



    public function __construct(){
        $this->client = new Client([
        'base_uri' => 'https://api-m.sandbox.paypal.com'
        ]);

        $this->clientId = env('PAYPAL_CLIENT_ID');
        $this->secret = env('PAYPAL_SECRET');
    }


    private function getAccessToken()
    {
        $response = $this->client->request('POST', '/v1/oauth2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => 'grant_type=client_credentials',
                'auth' => [
                    $this->clientId, $this->secret, 'basic'
                ]
            ]
        );

        $data = json_decode($response->getBody(), true);
        return $data['access_token'];
    }


    public function process($orderId, Request $request ){
        /*
        $client = new Client([
            'base_uri' => 'https://api-m.sandbox.paypal.com'
        ]);

        $clientId = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_SECRET');

        */
        $accessToken = $this->getAccessToken();

        $response =  $this->client->request('GET', '/v2/checkout/orders/' . $orderId, [
            /*
            'headers' => [
            'User-Agent' => 'testing/1.0',
            'Accept'     => 'application/json',
            'X-Foo'      => ['Bar', 'Baz']
            ]
            */
            

            'headers' => [
                'Accept' => 'application/json',
                //'Content-Type' => 'application/json',
                'Authorization' => "Bearer $accessToken"
            ]
            
            /*
            'body' => 'grant_type=client_credentials',
            'auth' => [
                $this->clientId, $this->secret, 'basic'
            ]

            $data = json_decode($response->getBody(), true);
            return $data['access_token'];
            */

        ]);

        //return json_decode($response->getBody());
        return (string) ($response->getBody());
        //$data = json_decode($response->getBody(), true);
        
        /// PAGO EXITOSO
        //if ($data['status'] === 'APPROVED'){
            
            
            //$userId = Solution::where('id', $solution_id)->value('user_id');
            
            //$solution_id = $request->input('solution_id');
            //$solution = Solution::findOrFail($solution_id);
            //$amount = $data['purchase_units'][0]['amount']['value'];


            

            //guardar datos
            //$this->registerSuccessfulPayment();

           /*
            return [
                'success' => $this->registerSuccessfulPayment($userId, $amount, $orderId),
                'url' => $solution->getResultsLink()
            ];
            */
        //}

        // ERROR en la compra
        //return [
          //  'success' => false
        //];
    }

    /*
    public function registerSuccessfulPayment($solution, $amount, $orderId): bool
    {
         
    }
    */


}
