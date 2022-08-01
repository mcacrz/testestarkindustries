<?php
namespace App\Http\Core\domain;

use App\Http\Core\ports\domain\Clients as ClientsPortDomain;
use App\Http\Core\ports\domain\Address as AddressPortDomain;
use \Exception;

class Clients extends ClientsPortDomain {
  public function __construct(){}

  public function setName (string $name)
  {
    if (strlen($name) === 0) throw new Exception ('Informe o nome', 422);
    if (strlen($name) > 150) throw new Exception ('A quantidade de caracteres excede o máximo permitido para o campo nome', 422);

    $this->name = $name;

    return $this;
  }

  public function setBirthday (string $birthday) {
    if (strlen($birthday) === 0) throw new Exception ('Informe a data de nascimento', 422);
    if (strlen($birthday) < 10 || strlen($birthday) > 10) throw new Exception ('Informe uma data de nascimento no formato dd/mm/yyyy', 422);

    $this->birthday = $birthday;

    return $this;
  }

  public function setRg (string $rg) 
  {
    if (strlen($rg) === 0) throw new Exception ('Informe o rg', 422);
    if (strlen($rg) < 8 || strlen($rg) > 10) throw new Exception ('A quantidade de caracteres é diferente da esperada para o campo rg (entre 8 e 10)', 422);

    $this->rg = $rg;

    return $this;
  }

  public function setCpf (string $cpf) 
  {
    if (strlen($cpf) === 0) throw new Exception ('Informe o cpf', 422);    
    if (strlen($cpf) !== 14) throw new Exception ('A quantidade de caracteres é diferente da esperada para o campo cpf (11)', 422);

    $this->cpf = $cpf;

    return $this;
  }

  public function setPhoto (string $photo)
  {
    if(strlen($photo) === 0) throw new Exception ('Envie a foto', 422);

    $this->photo = $photo;

    return $this;
  }
  
  public function setAddress (AddressPortDomain $address) {
    if (!$address instanceof AddressPortDomain) throw new Exception ('Endereço inválido', 422);
    
    $this->address = $address;

    return $this;
  }

  public function getName () 
  {
    return $this->name;
  }

  public function getBirthday () 
  {
    list($day, $month, $year) = explode('/', $this->birthday);
    return $year.'-'.$month.'-'.$day;
  }

  public function getRg () 
  {
    return $this->rg;
  }

  public function getCpf () 
  {
    list($cpf, $dv) = explode('-', $this->cpf);
    list($c1, $c2, $c3) = explode('.', $cpf);
    return $c1.$c2.$c3.$dv;
  }

  public function getPhoto ()
  {
    return $this->photo;
  }

  public function getAddressData ($field)
  {
    $arrayFields = [
      'cep' => $this->address->getCep(),
      'street' => $this->address->getStreet(),
      'number' => $this->address->getNumber(),
      'neighborhood' => $this->address->getNeighborhood(),
      'city' => $this->address->getCity(),
      'state' => $this->address->getState()
    ];

    if (strlen($field) === 0) return false;
    if (!array_key_exists($field, $arrayFields)) return false;

    return $arrayFields[$field];
  }
}