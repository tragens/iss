<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class CouncilModel extends Model{
    protected $table = 'tb_council';
    protected $allowedFields = ['id', 'regionId', 'name'];



}

