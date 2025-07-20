<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ResultsModel extends Model{
    protected $table = 'tb_results';
    protected $allowedFields = ['id', 'date', 'region', 'council', 'facility', 'checklistId', 'maxScore', 'results', 'createdBy', 'createdTime', 'updatedBy', 'updatedTime'];



}

