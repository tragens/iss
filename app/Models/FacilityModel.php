<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class FacilityModel extends Model{
    protected $table = 'tb_facility';
    protected $allowedFields = ['id', 'councilId', 'name'];



}

