<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use http\Env\Response;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    protected $client;
    public function __construct()
    {
        $this->client= new Client([
            'verify' => false
        ]);
    }

    public function show(){
        try {
            $data = $this->client->request('GET', 'https://gemeinde24.at/admin/API/data.php?auth_token=8lz9ezi8sfufsk30t4gf');
            $response =$data->getBody();
            /* using json_decode becase regular response was not working   */
            return response()->json([
                "status" => "SUCCESS",
                "message" => " list loaded successfully",
                "data" => json_decode($response, true),
            ]);
            /* returning curl second method of getting the data */

            // return $this->get_curl_data();
        }
        catch (\Exception $e){
            return response()->json([
                "status" => "Fail",
                "message" => $e->getMessage(),
                "data" => []
            ]);
        }

    }
    public function show_pdf(Request $request){
        try {
            $data= $this->client->request('Get','https://gemeinde24.at/admin/upload/pdf/73/1642410344.pdf');
            $response= $data->getBody();
            return base64_encode($response);
        }catch (\Exception $e){
            return response()->json([
                'status'=>'Fail',
                'message'=>$e->getMessage() ,

            ]);
        }
    }
}
