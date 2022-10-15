<?php

namespace App\Models\Portal;

use CodeIgniter\Model;

class Organizations extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'organizations';
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
    ///// OrganizationController->loadOrganizations()
    ////////////////////////////////////////////////////////////
    public function loadOrganizations()
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.main_website',
            '(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to',
            'a.created_by',
            'a.created_date'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganization()
    ////////////////////////////////////////////////////////////
    public function addOrganization($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organizations');
                $builder->insert($arrData);
                $insertId = $this->db->insertID();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? $insertId : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganization()
    ////////////////////////////////////////////////////////////
    public function addOrganizationDetails($arrAddressData, $arrDescriptionData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_address_details');
                $builder->insert($arrAddressData);
                $builder = $this->db->table('organization_description_details');
                $builder->insert($arrDescriptionData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->selectOrganization()
    ///// OrganizationController->selectEmailTemplate()
    ///// NavigationController->organizationPreview($organizationId)
    ////////////////////////////////////////////////////////////
    public function selectOrganization($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.secondary_email',
            'a.main_website',
            'a.other_website',
            'a.phone_number',
            'a.fax',
            'a.linkedin_url',
            'a.facebook_url',
            'a.twitter_url',
            'a.instagram_url',
            'a.industry',
            'a.naics_code',
            'a.employee_count',
            'a.annual_revenue',
            'a.type',
            'a.ticket_symbol',
            'a.member_of',
            'a.email_opt_out',
            'a.assigned_to',
            '(SELECT CONCAT(salutation, " ",first_name, " ", last_name) FROM users WHERE id = a.assigned_to) assigned_to_name',
            'a.created_by',
            'a.created_date',
            'b.billing_street',
            'b.billing_city',
            'b.billing_state',
            'b.billing_zip',
            'b.billing_country',
            'b.shipping_street',
            'b.shipping_city',
            'b.shipping_state',
            'b.shipping_zip',
            'b.shipping_country',
            'c.description'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->where('a.id',$organizationId);
        $builder->join('organization_address_details b','a.id = b.organization_id','left');
        $builder->join('organization_description_details c','a.id = c.organization_id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->editOrganization()
    ////////////////////////////////////////////////////////////
    public function editOrganization($arrData, $organizationId)
    {
        try {
            $this->db->transStart();
                $this->db->table('organizations')
                        ->where(['id'=>$organizationId])
                        ->update($arrData['organization_details']);
                $this->db->table('organization_address_details')
                        ->where(['organization_id'=>$organizationId])
                        ->update($arrData['organization_address']);
                $this->db->table('organization_description_details')
                        ->where(['organization_id'=>$organizationId])
                        ->update($arrData['organization_description']);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->removeOrganization()
    ////////////////////////////////////////////////////////////
    public function removeOrganization($organizationId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organizations');
                $builder->where(['id'=>$organizationId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }











    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationSummary()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationSummary($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'b.billing_city',
            'b.billing_country'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->where('a.id',$organizationId);
        $builder->join('organization_address_details b','a.id = b.organization_id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationDetails()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationDetails($organizationId)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.secondary_email',
            'a.main_website',
            'a.other_website',
            'a.phone_number',
            'a.fax',
            'a.linkedin_url',
            'a.facebook_url',
            'a.twitter_url',
            'a.instagram_url',
            'a.industry',
            'a.naics_code',
            'a.employee_count',
            'a.annual_revenue',
            'a.type',
            'a.ticket_symbol',
            'a.member_of',
            'a.email_opt_out',
            'a.assigned_to',
            '(SELECT CONCAT(first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name',
            'b.billing_street',
            'b.billing_city',
            'b.billing_state',
            'b.billing_zip',
            'b.billing_country',
            'b.shipping_street',
            'b.shipping_city',
            'b.shipping_state',
            'b.shipping_zip',
            'b.shipping_country',
            'c.description'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        $builder->where('a.id',$organizationId);
        $builder->join('organization_address_details b','a.id = b.organization_id','left');
        $builder->join('organization_description_details c','a.id = c.organization_id','left');
        $query = $builder->get();
        return  $query->getRowArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationContacts()
    ///// OrganizationController->loadUnlinkOrganizationContacts()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationContacts($organizationId)
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

        $builder = $this->db->table('contacts a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->orderBy('a.id','DESC');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationContact()
    ////////////////////////////////////////////////////////////
    public function unlinkOrganizationContact($contactId)
    {
        try {
          $this->db->transStart();
            $this->db->table('contacts')->where('id',$contactId)->update(['organization_id'=>null]);
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
          throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addSelectedOrganizationContacts()
    ////////////////////////////////////////////////////////////
    public function addSelectedOrganizationContacts($arrData)
    {
        try {
          $this->db->transStart();
            $this->db->table('contacts')->updateBatch($arrData,'id');
          $this->db->transComplete();
          return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
          throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationEmails()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationEmails($organizationId)
    {
        $columns = [
            'a.id',
            'a.email_subject',
            'a.email_content',
            'a.email_status',
            '(SELECT organization_name FROM organizations WHERE id = a.sent_to) as sent_to_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.sent_by) as sent_by_name',
            'DATE_FORMAT(A.created_date, "%Y-%m-%d") as date_sent',
            'DATE_FORMAT(A.created_date, "%H:%i:%s") as time_sent'
        ];

        $builder = $this->db->table('organization_email_histories a')->select($columns);
        $builder->where('a.sent_to',$organizationId);
        $query = $builder->get();
        return  $query->getResultArray();
    }










    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationDocuments()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationDocuments($organizationId)
    {
        $columns = [
            'a.id',
            'a.document_id',
            'b.title',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.document_number',
            'b.type',
            'b.file_name',
            'b.file_url',
            'b.file_type',
            'b.file_size',
            'b.download_count',
            'b.created_date',
            'b.updated_date'
        ];

        $builder = $this->db->table('organization_documents a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->join('documents b','a.document_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationDocument()
    ////////////////////////////////////////////////////////////
    public function unlinkOrganizationDocument($organizationDocumentId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_documents');
                $builder->where(['id'=>$organizationDocumentId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addSelectedOrganizationDocuments()
    ////////////////////////////////////////////////////////////
    public function addSelectedOrganizationDocuments($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_documents')->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addOrganizationDocument()
    ////////////////////////////////////////////////////////////
    public function addOrganizationDocument($arrData)
    {
        try {
            $this->db->transStart();
                $this->db->table('organization_documents')->insert($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }









    ////////////////////////////////////////////////////////////
    ///// OrganizationController->loadOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function loadOrganizationCampaigns($organizationId)
    {
        $columns = [
            'a.id',
            'a.campaign_id',
            'b.campaign_name',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = b.assigned_to) as assigned_to_name',
            'b.campaign_status',
            'b.campaign_type',
            'b.expected_close_date',
            'b.expected_revenue'
        ];

        $builder = $this->db->table('organization_campaigns a')->select($columns);
        $builder->where('a.organization_id',$organizationId);
        $builder->join('campaigns b','a.campaign_id = b.id','left');
        $query = $builder->get();
        return  $query->getResultArray();
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->unlinkOrganizationCampaign()
    ////////////////////////////////////////////////////////////
    public function unlinkOrganizationCampaign($organizationCampaignId)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_campaigns');
                $builder->where(['id'=>$organizationCampaignId]);
                $builder->delete();
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////
    ///// OrganizationController->addSelectedOrganizationCampaigns()
    ////////////////////////////////////////////////////////////
    public function addSelectedOrganizationCampaigns($arrData)
    {
        try {
            $this->db->transStart();
                $builder = $this->db->table('organization_campaigns');
                $builder->insertBatch($arrData);
            $this->db->transComplete();
            return ($this->db->transStatus() === TRUE)? 1 : 0;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    








    ////////////////////////////////////////////////////////////
    ///// CampaignController->loadUnlinkOrganizations()
    ///// DocumentController->loadUnlinkOrganizations()
    ////////////////////////////////////////////////////////////
    public function loadUnlinkOrganizations($arrOrganizationIds)
    {
        $columns = [
            'a.id',
            'a.organization_name',
            'a.primary_email',
            'a.main_website',
            '(SELECT CONCAT(salutation, " ", first_name, " ", last_name) FROM users WHERE id = a.assigned_to) as assigned_to_name'
        ];

        $builder = $this->db->table('organizations a')->select($columns);
        if(count($arrOrganizationIds) > 0)
        {
            $builder->whereNotIn('a.id',$arrOrganizationIds);
        }
        $query = $builder->get();
        return  $query->getResultArray();
    }
}
