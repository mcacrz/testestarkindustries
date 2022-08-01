<?php
namespace App\Http\Core\useCases;

use App\Http\Core\ports\repository\DbClient as DbClientPortRepository;
use App\Http\Core\ports\repository\HttpRequest as HttpRequestPortRepository;
use App\Http\Core\services\Clients as ClientsService;
use Exception;

class Clients {
  use ClientsService;

  public function __construct () {}
  
  public function insert (array $client, DbClientPortRepository $db)
  {
    try{
      $db->insert($client);
      return true;
    } catch (Exception $ex) {
      throw new Exception($ex->getMessage(), $ex->getCode());
    }
  }

  public function find (string $field, string $value, DbClientPortRepository $db) 
  {
    try {
      $data = $db->findByField($field, $value);

      $result = array_reduce(
        $data,
        function($acr, $client) {
          $clientReduce = (array) $client;
          $hasFraudRisk = $this->hasFraudRisk($clientReduce['birthday'], $clientReduce['cpf']);
          $clientReduce['hasFraudRisk'] = $hasFraudRisk;
          array_push($acr, $clientReduce);
          return $acr;
        },
        []
      );

      return $result;  
    } catch (Exception $ex) {
      throw new Exception($ex->getMessage(), 500);
    }
  }

  public function cepSearch (string $url, HttpRequestPortRepository $httpRequest) 
  {
    try {
      $response = $httpRequest->get($url, ['verify' => false]);
      return $response;
    } catch (Exception $ex) {
      throw new Exception($ex->getMessage(), $ex->getCode());
    }
  }
}