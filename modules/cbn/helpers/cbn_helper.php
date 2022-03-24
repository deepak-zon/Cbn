<?php
defined('BASEPATH') or exit('No direct script access allowed');

function insert_states($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->insert(db_prefix() . 'states', $data);
        return true;
    }
}
function insert_system($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->insert(db_prefix() . 'systems', $data);
        return true;
    }
}
function update_system($data, $id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        $CI->db->update(db_prefix() . 'systems', $data);
        return true;
    }
}
function insert_franchies($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->insert(db_prefix() . 'franchise', $data);
        return true;
    }
}
function update_franchies($data, $id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        $CI->db->update(db_prefix() . 'franchise', $data);
        return true;
    }
}
function check_franchise($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->where('franchise_number', $data);
        $res = $CI->db->get(db_prefix() . 'franchise')->result_array();
        if ($res) {
            return false;
        } else {
            return true;
        }
    }
}
function check_value($condition, $data, $table)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->where($condition, $data);
        $res = $CI->db->get(db_prefix() . $table)->row_array();
        if ($res) {
            return false;
        } else {
            return true;
        }
    }
}
function get_data($data)
{
    if ($data) {
        $CI = &get_instance();
        $res = $CI->db->get(db_prefix() . $data)->result_array();
        return $res;
    }
}
function get_system_data()
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'systems.*,' . db_prefix() . 'states.state_name');
    $CI->db->from(db_prefix() . 'systems');
    $CI->db->join(db_prefix() . 'states', db_prefix() . 'systems.state_id = ' . db_prefix() . 'states.id', 'inner');
    $query = $CI->db->get();
    return $query->result_array();
}
function get_franchise_data()
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'franchise.*,' . db_prefix() . 'systems.system_name,' . db_prefix() . 'states.state_name');
    $CI->db->from(db_prefix() . 'franchise');
    $CI->db->join(db_prefix() . 'systems', db_prefix() . 'franchise.system_id = ' . db_prefix() . 'systems.id', 'inner');
    $CI->db->join(db_prefix() . 'states',  db_prefix() . 'systems.state_id = ' . db_prefix() . 'states.id', 'inner');
    $query = $CI->db->get();
    return $query->result_array();
}
function delete_data($id, $table)
{
    if ($table) {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        $CI->db->delete(db_prefix() . $table);
        return true;
    }
}
function update_states($id, $data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        $CI->db->update(db_prefix() . 'states', $data);
        return true;
    }
}
function check_account_no($column, $data, $table)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->where($column, $data);
        $result = $CI->db->get(db_prefix() . $table)->row_array();
        return $result;
    }
}
function get_client_data($account_number)
{
    $CI = &get_instance();
    $CI->db->where('account_number', $account_number);
    return $CI->db->get(db_prefix() . 'clients')->row();
}
function get_statement_balance_show($account_number)
{
    $CI = &get_instance();
    //$CI->db->select(db_prefix() . 'invoices.*');
    $CI->db->select_sum(db_prefix() . 'invoices.total');
    $CI->db->from(db_prefix() . 'clients');
    $CI->db->join(db_prefix() . 'invoices',  db_prefix() . 'clients.userid = ' . db_prefix() . 'invoices.clientid', 'inner');
    $CI->db->where(db_prefix() . 'clients.account_number', $account_number);
    $query = $CI->db->get();
    return $query->row_array();
}
function get_statement_balance_record($account_number)
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'invoices.*');
    $CI->db->from(db_prefix() . 'clients');
    $CI->db->join(db_prefix() . 'invoices',  db_prefix() . 'clients.userid = ' . db_prefix() . 'invoices.clientid', 'inner');
    $CI->db->where(db_prefix() . 'clients.account_number', $account_number);
    $query = $CI->db->get();
    return $query->row_array();
}
function get_statement_balance($account_number)
{
    $CI = &get_instance();
    $CI->db->select(db_prefix() . 'invoices.*');
    $CI->db->from(db_prefix() . 'clients');
    $CI->db->join(db_prefix() . 'invoices',  db_prefix() . 'clients.userid = ' . db_prefix() . 'invoices.clientid', 'inner');
    $CI->db->where(db_prefix() . 'clients.account_number', $account_number);
    $query = $CI->db->get();
    return $query->result_array();
}
function base_currency_get()
{
    $CI = &get_instance();
    $CI->db->where('isdefault', 1);
    return $CI->db->get(db_prefix() . 'currencies')->row();
}
function bulk_offline_payments_last_id()
{
    $CI = &get_instance();
    $CI->db->select_max('id');
    return $CI->db->get(db_prefix() . 'bulk_offline_payments')->row_array();
}
function get_current_staff_name($staffid)
{
    $CI = &get_instance();
    $CI->db->where('staffid', $staffid);
    return $CI->db->get(db_prefix() . 'staff')->row_array();
}
function update_invoice_data($id, $data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        $CI->db->update(db_prefix() . 'invoices', $data);
        return true;
    }
}
function insert_bulk_offline_payments($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->insert(db_prefix() . 'bulk_offline_payments', $data);
        return true;
    }
}
function insert_invoicepaymentrecords($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->insert(db_prefix() . 'invoicepaymentrecords', $data);
        return $CI->db->insert_id();
    }
}
function check_invoice_paymentrecords($id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->select_sum('amount');
        $CI->db->where('invoiceid', $id);
        return $CI->db->get(db_prefix() . 'invoicepaymentrecords')->row();
    }
}
function update_invoicepaymentrecords($data, $id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->where('id', $id);
        $CI->db->update(db_prefix() . 'invoicepaymentrecords', $data);
        return true;
    }
}
function check_state_daelte($id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->where('state_id', $id);
        return $CI->db->get(db_prefix() . 'systems')->row_array();
    }
}
function check_system_daelte($id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->where('system_id', $id);
        return $CI->db->get(db_prefix() . 'franchise')->row_array();
    }
}
function check_franchise_daelte($id)
{
    if ($id) {
        $CI = &get_instance();
        $CI->db->where('franchise', $id);
        return $CI->db->get(db_prefix() . 'clients')->row_array();
    }
}
function insert_invoice_postuploadbalance($data)
{
    if ($data) {
        $CI = &get_instance();
        $CI->db->insert(db_prefix() . 'invoice_post_upload_balance', $data);
        return true;
    }
}
function check_post_upload_balance($client_id)
{
    if ($client_id) {
        $CI = &get_instance();
        $CI->db->select_sum('post_upload_balance');
        $CI->db->where('clientid', $client_id);
        return $CI->db->get(db_prefix() . 'invoice_post_upload_balance')->row();
    }
}
function update_invoice_postuploadbalance($data, $client_id)
{
    if ($client_id) {
        $CI = &get_instance();
        $CI->db->where('clientid', $client_id);
        $CI->db->update(db_prefix() . 'invoice_post_upload_balance', $data);
        return true;
    }
}
function get_payment_mode($payment_type)
{
    if ($payment_type) {
        $CI = &get_instance();
        $CI->db->where('id', $payment_type);
        return $CI->db->get(db_prefix() . 'payment_modes')->row();
    }
}
function check_duplicate_record($account_number, $date, $amount, $tranjection_id)
{
    if ($account_number) {
        $CI = &get_instance();
        $CI->db->select(db_prefix() . 'invoicepaymentrecords.*');
        $CI->db->from(db_prefix() . 'clients');
        $CI->db->join(db_prefix() . 'invoices',  db_prefix() . 'clients.userid = ' . db_prefix() . 'invoices.clientid', 'inner');
        $CI->db->join(db_prefix() . 'invoicepaymentrecords',  db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid', 'inner');
        $CI->db->where(db_prefix() . 'clients.account_number', $account_number);
        $CI->db->where(db_prefix() . 'invoicepaymentrecords.date', date_format(date_create($date), "Y-m-d"));
        $CI->db->where(db_prefix() . 'invoicepaymentrecords.amount', $amount);
        $CI->db->where(db_prefix() . 'invoicepaymentrecords.transactionid', $tranjection_id);
        $query1 = $CI->db->get()->result_array();
    }
    if ($tranjection_id) {
        $CI = &get_instance();
        $CI->db->select(db_prefix() . 'invoicepaymentrecords.*');
        $CI->db->from(db_prefix() . 'clients');
        $CI->db->join(db_prefix() . 'invoices',  db_prefix() . 'clients.userid = ' . db_prefix() . 'invoices.clientid', 'inner');
        $CI->db->join(db_prefix() . 'invoicepaymentrecords',  db_prefix() . 'invoices.id = ' . db_prefix() . 'invoicepaymentrecords.invoiceid', 'inner');
        $CI->db->where(db_prefix() . 'invoicepaymentrecords.transactionid', $tranjection_id);
        $query2 = $CI->db->get()->result_array();
    }
    if (!empty($query1) || !empty($query2)) {
        if (!empty($query1)) {
            $data['status']  = "1";
            $data['message'] = "1";
        } else {
            $data['status']  = "1";
            $data['message'] = "2";
        }
    } else {
        $data['status'] = "0";
        $data['message'] = " ";
    }
    return $data;
}
