<?php
namespace App\Http\Adapters;

use Illuminate\Support\Facades\Http;
use App\Http\Core\ports\repository\HttpRequest;

class GuzzleHttpRequest implements HttpRequest {
  public function post (string $url, array $data, array $options)
  {
    $response = Http::post($url, $data, $options);
    return $response;
  }

  public function get (string $url, array $options) 
  {
    $response = count($options) > 0 
      ? Http::withOptions($options)->get($url)
      : Http::get($url);
      
    return $response;
  }
}