<?php
namespace App\Http\Core\services;

trait Clients {
  private function hasFraudRisk ($birthday, $cpf) {
    list($ano,$mes,$dia) = explode('-', $birthday);
    $firstCpfChar = substr($cpf, 0, 1);

    $cpfRules = [
      'a' => ['rule' => function($year){ return (int)$year <= 1950; }, 'digit' => [0,1,2,3]],
      'b' => ['rule' => function($year){ return (int)$year > 1950 && (int)$year <= 2000; }, 'digit' => [4,5,6]],
      'c' => ['rule' => function($year){ return (int)$year > 2000; }, 'digit' => [7,8,9]]
    ];

    $map = array_map(function($rule) use ($ano, $firstCpfChar) {
      return ($rule['rule']($ano) && in_array((int)$firstCpfChar, $rule['digit']))
        ? true
        : false; 
    },
    $cpfRules);

    $filter = array_filter($map);

    return count($filter) > 0 ? false : true;
  }
}