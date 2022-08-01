<?php
namespace App\Http\Adapters;

use Illuminate\Support\Facades\DB;
use App\Http\Core\ports\repository\DbClient as DbClientPortRepository;
use \Exception;

class IlluminateDbClient implements DbClientPortRepository {
  private static $table = 'clients';
  
  public function insert (array $client) 
  {
    try {
      DB::table(self::$table)->insert($client);
    } catch (Exception $ex) {
      throw new Exception($ex->getMessage(), 500);
    }
  }

  public function findByField (string $field, $value = null) 
  {
    try {
      $result = DB::table(self::$table)
        ->select('*')
        ->where($field, '=', $value)
        ->get()
        ->toArray();

      return $result;
    } catch (Exception $ex) {
      throw new Exception ($ex->getMessage(), 500);
    }
  }
}