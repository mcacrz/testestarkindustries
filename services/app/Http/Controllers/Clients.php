<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Adapters\IlluminateDbClient as DbClientAdapterRepository;
use App\Http\Adapters\GuzzleHttpRequest as HttpRequestAdapterRepository;
use App\Http\Core\domain\Clients as ClientsDomain;
use App\Http\Core\domain\Address as AddressDomain;
use App\Http\Core\useCases\Clients as ClientsUseCase;
use Exception;

class Clients extends Controller {
  use ValidatesRequests;

  private $client;
  private $address;
  private $useCase;
  private $db;
  private $httpRequest;

  public function __construct ()
  {
    $this->client = new ClientsDomain();
    $this->address = new AddressDomain();
    $this->useCase = new ClientsUseCase();
    $this->db = new DbClientAdapterRepository();
    $this->httpRequest = new HttpRequestAdapterRepository();
  }

  public function insert (Request $request) 
  {
    try{
      $this->insertSetData($request);
      $dbData = $this->insertSetDbData();
      $this->useCase->insert($dbData, $this->db);
    
      return response()->json(['status' => true], 200);  
    } catch (Exception $ex) {
      return response()->json(['status' => false, 'response' => $ex->getMessage()], $ex->getCode());
    }
  }

  public function find ($field, $value) 
  {
    try {
      $field = $field;
      $value = $value;
  
      $result = $this->useCase->find($field, $value, $this->db);
      
      return count($result) > 0
        ? response()->json(['status' => true, 'response' => $result], 200)
        : response()->json(['status' => false, 'response' => 'Cliente não encontrado'], 200);
    } catch (Exception $ex) {
      return response()->json(['status' => false, 'response' => $ex->getMessage().' | '.$ex->getFile().' | '.$ex->getLine()], $ex->getCode());
    }
  }

  public function cepSearch ($cep) 
  {
    try{
      $this->address->setCep($cep);

      $url = str_replace('|cep|', $this->address->getCep(), env('API_CEP_URL'));

      $result = $this->useCase->cepSearch($url, $this->httpRequest);

      return is_null($result->json('erro'))
        ? response()->json(['status' => true, 'response' => $result->json()], 200)
        : response()->json(['status' => false, 'response' => 'CEP não encontrado'], 400);
    } catch (Exception $ex) {
      return response()->json(['status' => false, 'response' => $ex->getMessage()], $ex->getCode());
    }
  }

  private function insertSetData(Request $request) 
  {
    $this->address->setCep($request->input('cep'));
    $this->address->setCity($request->input('cidade'));
    $this->address->setNeighborhood($request->input('bairro'));
    $this->address->setNumber($request->input('numero'));
    $this->address->setState($request->input('uf'));
    $this->address->setStreet($request->input('logradouro'));

    $this->client->setName($request->input('nome'));
    $this->client->setBirthday($request->input('dataNascimento'));
    $this->client->setCpf($request->input('cpf'));
    $this->client->setRg($request->input('rg'));
    $this->client->setPhoto($request->input('foto'));
    $this->client->setAddress($this->address);
  }

  private function insertSetDbData() 
  {
    return [
      'name' => $this->client->getName(),
      'birthday' => $this->client->getBirthday(),
      'cpf' => $this->client->getCpf(),
      'rg' => $this->client->getRg(),
      'cep' => $this->client->getAddressData('cep'),
      'street' => $this->client->getAddressData('street'),
      'number' => $this->client->getAddressData('number'),
      'neighborhood' => $this->client->getAddressData('neighborhood'),
      'city' => $this->client->getAddressData('city'),
      'state' => $this->client->getAddressData('state'),
      'photo' => $this->client->getPhoto()
    ];
  }
}