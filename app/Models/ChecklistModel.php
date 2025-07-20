<?php namespace App\Models;
  
use CodeIgniter\Model;
  
class ChecklistModel extends Model{
    protected $table = 'tb_checklist';
    protected $allowedFields = ['id', 'name', 'parent', 'evidence', 'maxScore', 'createdBy', 'createdTime', 'updatedBy', 'updatedTime'];



}

