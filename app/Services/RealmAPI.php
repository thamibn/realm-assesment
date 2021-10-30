<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RealmAPI
{
    protected $baseURL = "https://interview-assessment-1.realmdigital.co.za/";

    /**
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function getEmployees($endpoint){
        $completeUrl = $this->baseURL.Str::replace('/', '', $endpoint);
        $response = Http::get($completeUrl);
        $response->throw(); //it will throw exception for us when status code >=400 client/server error.
        return $response->json();
    }

    public function getDontSendBirthdayWishes($endpoint){
        $completeUrl = $this->baseURL.Str::replace('/', '', $endpoint);
        $response = Http::get($completeUrl);
        $response->throw(); //it will throw exception for us when status code >=400 client/server error.
        return $response->json();
    }
}
