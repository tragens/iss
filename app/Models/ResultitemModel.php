<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ResultitemModel extends Model{
    protected $table = 'tb_resultitem';
    protected $allowedFields = ['id', 'resultId', 'checklistId', 'maxScore', 'results', 'comment', 'createdBy', 'createdTime', 'updatedBy', 'updatedTime'];



}

