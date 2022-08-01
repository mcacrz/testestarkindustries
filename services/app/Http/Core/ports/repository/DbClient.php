<?php
namespace App\Http\Core\ports\repository;

interface DbClient {
  public function insert (array $client);
  public function findByField (string $field, $value = null);
}