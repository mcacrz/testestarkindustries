<?php
namespace App\Http\Core\ports\repository;

interface HttpRequest {
  public function post (string $url, array $data, array $options);
  public function get (string $url, array $options);
}