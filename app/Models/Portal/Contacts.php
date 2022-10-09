<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Contacts extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'contacts';
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

    /*
        ContactController->loadContact()
    */
    public function loadContacts()
    {
        $columns = [
            'a.id',
            'a.salutation',
            'a.first_name',
            'a.last_name',
            'a.position',
            'a.organization_id',
            '(SELECT organization_name FROM organizations WHERE id = a.organization_id) as organization_name',
            'a.primary_email',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('contacts a')
                            ->select($columns)
                            ->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();

        // $this->db->select($columns);
        // $this->db->from('contacts a');
        // $this->db->order_by('a.id','desc');
        // $data = $this->db->get()->result();
        // return $data;
    }



    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadUnlinkContacts()
    ///// DocumentController->loadUnlinkContacts()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkContacts($arrContactIds)
    {
        $columns = [
            'a.id',
            'a.salutation',
            'a.first_name',
            'a.last_name',
            'a.position',
            'a.organization_id',
            '(SELECT organization_name FROM organizations WHERE id = a.organization_id) as organization_name',
            'a.primary_email',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name'
        ];

        $builder = $this->db->table('contacts a')->select($columns);
        if(count($arrContactIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrContactIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// ContactController->addSelectedContactCampaigns()
    ////////////////////////////////////////////////////////////
    public function addSelectedContactCampaigns($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('contact_campaigns');
                $builder->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }
}
