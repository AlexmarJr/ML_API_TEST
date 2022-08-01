<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ML_Categories;

class MainControler extends Controller
{
    public function loadMLData(){
        ini_set('max_execution_time', 300);
        $client = new \GuzzleHttp\Client();
        $URL = 'https://api.mercadolibre.com/sites/MLB/categories/all';
        $response = $client->request('GET', $URL);
        $data = json_decode($response->getBody(), true);
        
        try {
            foreach($data as $value){
                $dataArray = [
                    'id' => $value['id'],
                    'name' => $value['name'],
                    'picture' => $value['picture'],
                    'permalink' => $value['permalink'],
                    'total_items_in_this_category' => $value['total_items_in_this_category'],
                    'path_from_root' => json_encode($value['path_from_root']),
                    'children_categories' => json_encode($value['children_categories']),
                    'date_created' => $value['date_created']
                ];
                $find = ML_Categories::find($value['id']);
                if($find){ //Não deu pra usar o UpdateOrCreate aqui pq mudei a primary key la
                    $find->update($dataArray);
                } else {
                    ML_Categories::create($dataArray);
                }
            }
        } catch (Throwable $e) {
            return $this->sendResponse('500', 'Deu ruim, tudo culpa do '. $e);
        }

        return $this->sendResponse('200', 'Tudo fino do fino');

    }

    public function details($id){
        $data = ML_Categories::find($id);
        return $data;
    }

    public function sendResponse($status, $mensage)
    {
        return [
            'status' => $status,
            'data' => $mensage
        ];
    }
}






 // $ACCESS_TOKEN = env('SECRET_ML');
        // $SITE_ID = env('ML_ID_APP');
        // $URL = "https://api.mercadolibre.com/sites/$SITE_ID/domain_discovery/search";
        // $response = $client->request('GET', $URL, ['query' => [
        //     'q' => $Q,
            
        // ]],
        // ['headers' => 
        //     [
        //         'Authorization' => "Bearer {$ACCESS_TOKEN}"
        //     ]
        // ]);