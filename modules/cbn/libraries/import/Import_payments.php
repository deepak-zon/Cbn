<?php

defined('BASEPATH') or exit('No direct script access allowed');
require_once('App_import.php');

class Import_payments extends App_import
{
    protected $notImportableFields = [];

    protected $requiredFields = ['firstname', 'lastname', 'email'];

    public function __construct()
    {
        $this->notImportableFields = hooks()->apply_filters('not_importable_clients_fields', ['userid', 'id', 'is_primary', 'password', 'datecreated', 'last_ip', 'last_login', 'last_password_change', 'active', 'new_pass_key', 'new_pass_key_requested', 'leadid', 'default_currency', 'profile_image', 'default_language', 'direction', 'show_primary_contact', 'invoice_emails', 'estimate_emails', 'project_emails', 'task_emails', 'contract_emails', 'credit_note_emails', 'ticket_emails', 'addedfrom', 'registration_confirmed', 'last_active_time', 'email_verified_at', 'email_verification_key', 'email_verification_sent_at']);

        if (get_option('company_is_required') == 1) {
            $this->requiredFields[] = 'company';
        }

        $this->addImportGuidelinesInfo('Duplicate email rows won\'t be imported.', true);

        $this->addImportGuidelinesInfo('Make sure you configure the default contact permission in <a href="' . admin_url('settings?group=clients') . '" target="_blank">Setup->Settings->Customers</a> to get the best results like auto assigning contact permissions and email notification settings based on the permission.');

        parent::__construct();
    }

    public function perform()
    {
        $this->initialize();
        return $this->getRows();
    }

    public function formatFieldNameForHeading($field)
    {
        if (strtolower($field) == 'title') {
            return 'Position';
        }

        return parent::formatFieldNameForHeading($field);
    }

    protected function email_formatSampleData()
    {
        return uniqid() . '@example.com';
    }

    protected function failureRedirectURL()
    {
        return admin_url('clients/import');
    }

    protected function afterSampleTableHeadingText($field)
    {
        $contactFields = [
            'firstname', 'lastname', 'email', 'contact_phonenumber', 'title',
        ];

        if (in_array($field, $contactFields)) {
            return '<br /><span class="text-info">' . _l('import_contact_field') . '</span>';
        }
    }
}
