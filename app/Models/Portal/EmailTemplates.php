<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class EmailTemplates extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'emailtemplates';
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
    ///// EmailTemplateController->loadCategories()
    ////////////////////////////////////////////////////////////
    public function loadCategories()
    {
        $columns = [
            'id',
            'category_name',
            'category_description',
            'created_by',
            'created_date'
        ];

        $builder = $this->db->table('email_template_categories a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->addCategory()
    ////////////////////////////////////////////////////////////
    public function addCategory($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_template_categories')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->loadTemplates()
    ////////////////////////////////////////////////////////////
    public function loadTemplates()
    {
        $columns = [
            'a.id',
            '(SELECT category_name FROM email_template_categories WHERE id = a.category_id) as category_name',
            'a.template_name',
            'a.template_description',
            'a.template_subject',
            'a.template_content',
            'a.template_visibility',
            'a.template_status',
            '(SELECT CONCAT(first_name) FROM users WHERE id = a.created_by) as created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('email_templates a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->addTemplate()
    ////////////////////////////////////////////////////////////
    public function addTemplate($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('email_templates')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// EmailTemplateController->selectTemplate()
    ///// ContactController->selectEmailTemplate()
    ///// OrganizationController->selectEmailTemplate()
    ////////////////////////////////////////////////////////////
    public function selectTemplate($templateId)
    {
        $columns = [
            'a.id',
            '(SELECT category_name FROM email_template_categories WHERE id = a.category_id) as category_name',
            'a.template_name',
            'a.template_description',
            'a.template_subject',
            'a.template_content',
            'a.template_visibility',
            'a.template_status',
            '(SELECT CONCAT(first_name) FROM users WHERE id = a.created_by) as created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('email_templates a')->select($columns);
        $builder->where('a.id',$templateId);
        $query = $builder->get();
        return  $query->getRowArray();
    }
}
