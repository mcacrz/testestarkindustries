<?php
namespace App\Http\Core\domain;

use App\Http\Core\ports\domain\Address as AddressPortDomain;
use \Exception;

class Address extends AddressPortDomain {
  public function setCep (string $cep) 
  {
    if (strlen($cep) === 0) throw new Exception ('Informe o CEP', 422);
    if (strlen($cep) !== 8) throw new Exception ('A quantidade de caracteres é diferente da esperada para o campo CEP (8)', 422);
  
    $this->cep = $cep;
  }

  public function setStreet (string $street) 
  {
    if(strlen($street) === 0) throw new Exception ('Informe o logradouro',422);
    if(strlen($street) > 250) throw new Exception ('A quantidade de caracteres excede o tamanho do campo logradouro (250)', 422);

    $this->street = $street;
  }

  public function setNumber (int $number) 
  {
    if($number === 0) throw new Exception ('Informe o número',422);
  
    $this->number = $number;
  }

  public function setNeighborhood (string $neighborhood) 
  {
    if(strlen($neighborhood) === 0) throw new Exception ('Informe o bairro',422);
    if(strlen($neighborhood) > 250) throw new Exception ('A quantidade de caracteres excede o tamanho do campo logradouro (250)', 422);

    $this->neighborhood = $neighborhood;
  }
  
  public function setCity (string $city) 
  {
    if(strlen($city) === 0) throw new Exception ('Informe uma cidade',422);
    if(strlen($city) > 100) throw new Exception ('A quantidade de caracteres excede o tamanho do campo cidade (100)', 422);

    $this->city = $city;
  }

  public function setState (string $state) 
  {
    if(strlen($state) === 0) throw new Exception ('Informe um logradouro válido',422);
    if(strlen($state) !== 2) throw new Exception ('A quantidade de caracteres é diferente da esperada para o campo estado (2)', 422);

    $this->state = $state;
  }

  public function getCep ()
  {
    $cep = str_replace('-','',$this->cep); 
    return $cep;
  }

  public function getStreet () 
  {
    return $this->street;
  }

  public function getNumber () 
  {
    return $this->number;
  }

  public function getNeighborhood () 
  {
    return $this->neighborhood;
  }

  public function getCity () 
  {
    return $this->city;
  }

  public function getState () 
  {
    return $this->state;
  }
}