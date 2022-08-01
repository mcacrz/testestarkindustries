<?php
namespace App\Http\Core\ports\domain;

abstract class Address {
  private $cep;
  private $street;
  private $number;
  private $neighborhood;
  private $city;
  private $state;
}