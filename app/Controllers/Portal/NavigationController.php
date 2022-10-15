<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class NavigationController extends BaseController
{
    public function __construct()
    {
        $this->campaigns        = model('Portal/Campaigns');
        $this->contacts         = model('Portal/Contacts');
        $this->organizations    = model('Portal/Organizations');
        $this->documents        = model('Portal/Documents');
    }

    public function dashboard()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Dashboard";
                $data['customScripts'] = 'dashboard';
                return $this->slice->view('portal.dashboard', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
        
    }

    public function campaigns()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | campaigns";
                $data['customScripts'] = 'campaign';
                $data['campaignId'] = "";
                return $this->slice->view('portal.marketing.campaign', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function campaignPreview($campaignId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->campaigns->selectCampaign($campaignId);
                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | campaigns";
                    $data['customScripts'] = 'campaign';
                    $data['campaignId'] = $campaignId;
                    return $this->slice->view('portal.marketing.campaign', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function contacts()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Contacts";
                $data['customScripts'] = 'contacts';
                $data['contactId'] = "";
                return $this->slice->view('portal.marketing.contact', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function contactPreview($contactId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->contacts->selectContact($contactId);
                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | Contacts Preview";
                    $data['customScripts'] = 'contacts';
                    $data['contactId'] = $contactId;
                    return $this->slice->view('portal.marketing.contact', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function organizations()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Organizations";
                $data['customScripts'] = 'organization';
                $data['organizationId'] = "";
                return $this->slice->view('portal.marketing.organization', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function organizationPreview($organizationId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->organizations->selectOrganization($organizationId);

                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | Organization Preview";
                    $data['customScripts'] = 'organization';
                    $data['organizationId'] = $organizationId;
                    return $this->slice->view('portal.marketing.organization', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function agenda()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Agenda";
                $data['customScripts'] = 'agenda';
                return $this->slice->view('portal.agenda', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function calendar()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Calendar";
                $data['customScripts'] = 'calendar';
                return $this->slice->view('portal.calendar', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function documents()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Documents";
                $data['customScripts'] = 'documents';
                $data['documentId'] = "";
                return $this->slice->view('portal.documents', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function documentPreview($documentId)
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $result = $this->documents->selectDocument($documentId);

                if($result != null)
                {
                    $data['pageTitle'] = "Arkonor LLC | Document Preview";
                    $data['customScripts'] = 'documents';
                    $data['documentId'] = $documentId;
                    return $this->slice->view('portal.documents', $data);
                }
                else
                {
                    $data['pageTitle'] = "Arkonor LLC | 404 Page";
                    return view('404', $data);
                }
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function emailTemplate()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Arkonor LLC | Email Template";
                $data['customScripts'] = 'email_template';
                return $this->slice->view('portal.tools.email_template', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function users()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Users | Arkonor LLC";
                $data['customScripts'] = 'users';
                return $this->slice->view('portal.users', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }

    public function profile()
    {
        if($this->session->has('arkonorllc_user_loggedIn'))
        {
            if($this->session->get('arkonorllc_user_loggedIn'))
            {
                $data['pageTitle'] = "Profile | Arkonor LLC";
                $data['customScripts'] = 'profile';
                return $this->slice->view('portal.profile', $data);
            }
            else
            {
                return redirect()->to(base_url());
            }
        }
        else
        {
            return redirect()->to(base_url());
        }
    }
}
