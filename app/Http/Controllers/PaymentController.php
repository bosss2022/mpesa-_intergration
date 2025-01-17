<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PaymentController extends Controller
{
   public function token(){
    $consumerkey='e7drS5cZVloUQANb5MA6uoZGyIllpngWtg3jPbrGGaACnoDB';
    $consumerSecret='aAkkCNlYgKv62xUsAEcbtoC106i18jp1i8tpyLotRCBGHmeRaOB37CJA6knKlfMc';
    $url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';


    $response=Http::withBasicAuth($consumerkey,$consumerSecret)->get($url);
    return $response['access_token'];
   }

   public function initiateStkPush(){
        $accessToken=$this->token();
        $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $PassKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $BusinessShortCode='174379';
        $Timestamp=Carbon::now()->format('YmdHis');
        $password=base64_encode($BusinessShortCode.$PassKey.$Timestamp);
        $TransactionType='CustomerPayBillOnline';
        $Amount=1;
        $PartyA=254790995201;
        $PartyB='174379';
        $PhoneNumber=254790995201;
        $CallBackURL='https://mydomain.com/path';
        $AccountReference='Coders Base';
        $TransactionDesc='payment for goods';

        $response=Http::withToken($accessToken)->post($url,[
            'BusinessShortCode'=>$BusinessShortCode,
            'Password'=>$password,
            'Timestamp'=>$Timestamp,
            'TransactionType'=>$TransactionType,
            'Amount'=>$Amount,
            'PartyA'=>$PartyA,
            'PartyB'=>$PartyB,
            'PhoneNumber'=>$PhoneNumber,
            'CallBackURL'=>$CallBackURL,
            'AccountReference'=>$AccountReference,
            'TransactionDesc'=>$TransactionDesc
        ]);
   }

   public function stkCallback(){

   } 
}
