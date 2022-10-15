<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Tasks extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tasks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    ////////////////////////////////////////////////////////////
    ///// CalendarController->loadCalendars()
    ////////////////////////////////////////////////////////////
    public function loadTasks()
    {
        $columns = [
            'a.id',
            'a.subject',
            'a.start_date',
            'a.start_time',
            'a.end_date',
            'a.end_time',
            'a.status',
            'a.created_by',
            'a.created_date',
            'a.updated_by',
            'a.updated_date'
        ];

        $builder = $this->db->table('tasks a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    //
    // TaskController->addTask()
    //
    public function addTask($arrData)
    {
        try {
          $this->db->trans_start();
            $this->db->insert('tasks',$arrData);
          $this->db->trans_complete();
          return ($this->db->trans_status() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
          throw $e;
        }
    }
}
