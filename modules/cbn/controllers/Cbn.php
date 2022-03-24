<?php

// defined('BASEPATH') or exit('No direct script access allowed');

class Cbn extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        // if (!is_admin()) {
        //     access_denied('CBN');
        // }
        // if (!has_permission('bulk_offline_payments', '', 'view')) {
        //         access_denied('bulk_offline_payments');
        // }
    }
    public function states()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['states'] = get_data('states');
        $data['title'] = _l('states');
        $this->load->view('states/states', $data);
    }
    public function systems()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['systems'] = get_system_data();
        $data['title'] = _l('systems');
        $this->load->view('systems/systems', $data);
    }
    public function franchises()
    {
        $data['franchise'] = get_franchise_data();
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('franchises');
        $this->load->view('franchises/franchises', $data);
    }
    public function state_type()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('state_name', 'State Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
            die();
        }
        if (check_value('state_name', $this->input->post('state_name'), 'states') == FALSE) {
            echo json_encode(['success' => 'warning', 'set_value' => 'state_name', 'msg' => 'State Name Must be unique']);
            die;
        }
        $data = [
            'state_name' => $this->input->post('state_name'),
            'state_short_letters' => $this->input->post('state_short_letters')
        ];
        if (insert_states($data)) {
            set_alert('success', _l('added_successfully', _l('state')));
            echo json_encode(['success' => true, 'message' => 'State successfully added']);
            die();
        }
    }
    public function state_update()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('state_name', 'State Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
            die();
        }
        $id = $this->input->post('state_id');
        $data = [
            'state_name' => $this->input->post('state_name'),
            'state_short_letters' => $this->input->post('state_short_letters')
        ];
        if (update_states($id, $data)) {
            set_alert('success', _l('update_successfully', _l('states')));
            echo json_encode(['success' => true, 'message' => 'State successfully updated']);
            die();
        }
    }
    public function state_delete($id)
    {
        if (delete_data($id, 'states')) {
            set_alert('success', _l('delete_successfully', _l('states')));
            return redirect('cbn/states');
        }
    }
    public function system_delete($id)
    {
        if (delete_data($id, 'systems')) {
            set_alert('success', _l('delete_successfully', _l('systems')));
            return redirect('cbn/systems');
        }
    }
    public function franchise_delete($id)
    {
        if (delete_data($id, 'franchise')) {
            set_alert('success', _l('delete_successfully', _l('franchises')));
            return redirect('cbn/franchises');
        }
    }
    public function show_state()
    {
        $select = "";
        $select .= '<label for="select_state"><small class="req text-danger">* </small>' . _l('select_state') . '</label>';
        $select .= '<select id="select_state" class="selectpicker" name="state_id" data-width="100%" data-show-subtext="true">';
        $select .= '<option value="">Nothing Select</option>';
        foreach (get_data('states') as $res) {
            $select .= '<option ';
            if (isset($_GET['id_state']) && $_GET['id_state'] == $res["id"]) {
                $select .= 'selected';
            }
            $select .= ' value="' . $res["id"] . '">' . $res["state_name"] . '</option>';
        }
        $select .= '</select>';
        echo $select;
    }
    public function show_system()
    {
        $select = "";
        $select .= '<label for="select_state"><small class="req text-danger">* </small>' . _l('select_system') . '</label>';
        $select .= '<select id="select_state" class="selectpicker" name="system_id" data-width="100%" data-show-subtext="true">';
        $select .= '<option value="">Nothing Select</option>';
        foreach (get_data('systems') as $res) {
            $select .= '<option ';
            if (isset($_GET['id_system']) && $_GET['id_system'] == $res["id"]) {
                $select .= 'selected';
            }
            $select .= ' value="' . $res["id"] . '">' . $res["system_name"] . '</option>';
        }
        $select .= '</select>';
        echo $select;
    }
    public function system_type()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('state_id', 'State Name', 'required');
        $this->form_validation->set_rules('system_name', 'System Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
            die();
        }
        if (!$this->input->post('system_id')) {
            if (check_value('system_name', $this->input->post('system_name'), 'systems') == FALSE) {
                echo json_encode(['success' => 'warning', 'set_value' => 'system_name', 'msg' => 'System Name Must be unique']);
                die;
            }
        }
        $data = [
            'state_id' => $this->input->post('state_id'),
            'system_name' => $this->input->post('system_name')
        ];
        if ($this->input->post('system_id')) {
            if (update_system($data, $this->input->post('system_id'))) {
                set_alert('success', _l('update_successfully', _l('systems')));
                echo json_encode(['success' => true, 'message' => 'System successfully updated']);
                die();
            }
        }
        if (insert_system($data)) {
            set_alert('success', _l('added_successfully', _l('systems')));
            echo json_encode(['success' => true, 'message' => 'System successfully added']);
            die();
        }
    }
    public function franchies_type()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('system_id', 'System Name', 'required');
        $this->form_validation->set_rules('franchise_number', 'Franchise Number', 'trim|required|min_length[4]|max_length[4]');
        $this->form_validation->set_rules('franchise_name', 'Franchise Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['success' => false, 'errors' => $this->form_validation->error_array()]);
            die();
        }
        if (!$this->input->post('franchise_id')) {
            if (check_franchise($this->input->post('franchise_number')) == FALSE) {
                echo json_encode(['success' => 'warning', 'set_value' => 'franchise_number', 'msg' => 'Franchise Number Must be unique']);
                die;
            }
            if (check_value('franchise_name', $this->input->post('franchise_name'), 'franchise') == FALSE) {
                echo json_encode(['success' => 'warning', 'set_value' => 'franchise_name', 'msg' => 'Franchise Name Must be unique']);
                die;
            }
        }
        $data = [
            'system_id'        => $this->input->post('system_id'),
            'franchise_number' => $this->input->post('franchise_number'),
            'franchise_name'   => $this->input->post('franchise_name')
        ];
        if ($this->input->post('franchise_id')) {
            if (update_franchies($data, $this->input->post('franchise_id'))) {
                set_alert('success', _l('update_successfully', _l('franchises')));
                echo json_encode(['success' => true, 'message' => 'System successfully added']);
                die();
            }
        }
        if (insert_franchies($data)) {
            set_alert('success', _l('added_successfully', _l('franchises')));
            echo json_encode(['success' => true, 'message' => 'System successfully added']);
            die();
        }
    }

    public function bulk_offline_payments()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['bulk_payments'] = get_data('bulk_offline_payments');
        $data['base_currency']   = base_currency_get();
        $data['title'] = _l('bulk_offline_payments');
        $this->load->view('payments/bulk_offline_payments', $data);
    }

    public function auto_billing()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('auto_billing');
        $this->load->view('billing/auto_billing', $data);
    }

    public function invoice_downloader()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('invoice_downloader');
        $this->load->view('invoice/invoice_downloader', $data);
    }

    public function upload_reports()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('upload_reports');
        $this->load->view('reports/upload_reports', $data);
    }

    public function credit_notes()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('credit_notes');
        $this->load->view('notes/credit_notes', $data);
    }

    public function items()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('items');
        $this->load->view('item/items', $data);
    }

    public function subscriptions()
    {
        $this->app_scripts->add('custom-js', 'modules/cbn/assets/js/custom.js');
        $data['title'] = _l('subscriptions');
        $this->load->view('subscription/subscriptions', $data);
    }

    public function file_upload()
    {
        if (isset($_FILES['file_csv']['name']) && $_FILES['file_csv']['name'] != '') {

            $this->load->library('import/import_payments', [], 'import');

            $result = $this->import->setSimulation($this->input->post('simulate'))
                ->setTemporaryFileLocation($_FILES['file_csv']['tmp_name'])
                ->setFilename($_FILES['file_csv']['name'])
                ->perform();

            $total_rows_post = ($this->import->totalRows() - 1);

            $td = "style='border-right: 2px solid #03a9f4;text-align:center;'";
            $thead = "style='border-right: 2px solid #03a9f4;text-align:center;border-bottom: 2px solid #03a9f4;'";
            $th = "style='border-right: 2px solid #03a9f4;width: 122px;text-align:center;border-bottom: 2px solid #03a9f4;'";
            $th_amount = "style='border-right: 2px solid #03a9f4;width: 100px;text-align:center;border-bottom: 2px solid #03a9f4;'";
            $table  = '<table class="table" style="border:2px solid #03a9f4;">';
            $table .= '<thead>';
            $table .= '<th ' . $thead . '><b>' . _l('s_no') . '</b></th>';
            $table .= '<th ' . $th . '><b>' . _l('account_number') . '</b></th>';
            $table .= '<th ' . $thead . '><b>' . _l('date') . '</b></th>';
            $table .= '<th ' . $th_amount . '><b>' . _l('amount') . '</b></th>';
            $table .= '<th ' . $thead . '><b>' . _l('payment_type') . '</b></th>';
            $table .= '<th ' . $th . '><b>' . _l('account_name') . '</b></th>';
            $table .= '<th ' . $th_amount . '><b>' . _l('statement_balance') . '</b></th>';
            $table .= '<th ' . $th_amount . '><b>' . _l('post_upload_balance') . '</b></th>';
            $table .= '<th ' . $thead . '><b>' . _l('data_status') . '</b></th>';
            $table .= '<th ' . $thead . '><b>' . _l('account_status') . '</b></th>';
            $table .= '</thead>';
            $table .= '<tbody>';
            $a = 1;
            $account_error = "0";
            $date_error = "0";
            $duplicate_record = "0";
            $base_currency   = base_currency_get();
            $total_amount = 0;
            $client_amount_details = [];
            foreach ($result as $res) {
                if (!empty($res[2])) {
                    $total_amount = $total_amount + (preg_replace("/[^0-9.]/", "", $res[2]));
                    $statement_balance_total = get_statement_balance_show($res[0]);
                    $statement_record = get_statement_balance_record($res[0]);

                    $data_client  = get_statement_balance($res[0]);
                    $invoicepayment_record_amount = 0;
                    foreach ($data_client as $clientdata) {
                        $invoicepayment_record = check_invoice_paymentrecords($clientdata['id']);
                        $invoicepayment_record_amount = $invoicepayment_record_amount + $invoicepayment_record->amount;
                    }
                    if (array_key_exists($res[0], $client_amount_details)) {
                        $statement_balance['total'] = $client_amount_details[$res[0]];
                        $duplicate_account = "1";
                    } else {
                        $statement_balance['total'] = $statement_balance_total['total'] - $invoicepayment_record_amount;
                        $duplicate_account = "0";
                    }

                    $client_data = get_client_data($res[0]);
                    $payment_type = get_payment_mode($res[3]);
                    $post_upload = ($statement_balance['total'] - (preg_replace("/[^0-9.]/", "", $res[2])));
                    $post_upload_balance = ($post_upload < 0) ? '(' . abs($post_upload) . ')' : abs($post_upload);
                    $client_amount_details[$res[0]] = $post_upload_balance;

                    $check_duplicate_record = check_duplicate_record($res[0], $res[1], $res[2], $res[4]);

                    if (empty($statement_record)) {
                        $check = 'style="color:red;"';
                        $account_error = "1";
                        $account_status = "Error";
                    } elseif ($check_duplicate_record['status'] == "1" || $duplicate_account == "1") {
                        $check = 'style="color:#ff6a00;"';
                        $duplicate_record = "1";
                        $account_status = ($client_data->active == 1) ? "Active" : "Inactive";
                    } else {
                        $check = "";
                        $account_status = ($client_data->active == 1) ? "Active" : "Inactive";
                    }
                    $end_date = date('m/d/Y H:i:s', strtotime(date('m/d/Y') . ' -' . '15' . ' day'));
                    if (strtotime(date('m/d/Y H:i:s')) < strtotime($res[1]) || strtotime($res[1]) < strtotime($end_date)) {
                        $td_date = "style='border-right: 2px solid #03a9f4;color:red;text-align:center;'";
                        $data_status = "Error";
                        $date_error = "1";
                    } else {
                        $td_date = "style='border-right: 2px solid #03a9f4;text-align:center;'";
                        $data_status = "Okay";
                    }

                    $table .= '<tr ' . $check . '>';
                    $table .= '<td ' . $td . '>' . $a . '</td>';
                    $table .= '<td ' . $td . '>' . $res[0] . '</td>';
                    $table .= '<td ' . $td_date . '>' . $res[1] . '</td>';
                    $table .= '<td ' . $td . '>' . $base_currency->symbol . " " .  $res[2] . '</td>';
                    $table .= '<td ' . $td . '>' . $payment_type->name . '</td>';
                    $table .= '<td ' . $td . '>' . $client_data->company . '</td>';
                    $table .= '<td ' . $td . '>' . $base_currency->symbol . " " . number_format((float)$statement_balance['total'], 2, '.', '') . '</td>';
                    $table .= '<td ' . $td . '>' . $base_currency->symbol . " " . $post_upload_balance . '</td>';
                    $table .= '<td ' . $td_date . '>' . $data_status . '</td>';
                    $table .= '<td ' . $td . '>' . $account_status . '</td>';
                    $table .= '</tr>';
                    $a++;
                }
            }
            $table .= '</tbody>';
            $table .= '</table>';

            if ($account_error == "1") {
                $msg = _l('correct_error');
                $btn_name = _l('test_again');
                $confirm_upload = 0;
            } else if ($duplicate_record == "1") {
                $msg = _l('duplicate_error');
                $btn_name = _l('test_again');
                $confirm_upload = 0;
            } else if ($date_error == "1") {
                $msg = _l('date_error');
                $btn_name = _l('test_again');
                $confirm_upload = 0;
            } else {
                $msg = 'Total : ' . $base_currency->symbol . $total_amount;
                $btn_name = _l('confirm_upload');
                $confirm_upload = 1;
            }

            echo json_encode(['status' => 'true', 'payment_table' => $table, 'message' => $msg, 'btn' => $btn_name, 'total_rows' => $total_rows_post, 'confirm_upload' => $confirm_upload, 'total_amount' => number_format((float)$total_amount, 2, '.', '')]);
        } else {
            echo json_encode(['status' => 'false', 'message' => 'file not upload']);
        }
    }

    public function bulk_offline_payments_upload()
    {
        $this->load->library('import/import_payments', [], 'import');

        $result = $this->import->setSimulation($this->input->post('simulate'))
            ->setTemporaryFileLocation($_FILES['file_csv']['tmp_name'])
            ->setFilename($_FILES['file_csv']['name'])
            ->perform();

        $td = "style='border-right: 2px solid #03a9f4;text-align:center;'";
        $thead = "style='border-right: 2px solid #03a9f4;text-align:center;border-bottom: 2px solid #03a9f4;'";
        $th = "style='border-right: 2px solid #03a9f4;width: 122px;text-align:center;border-bottom: 2px solid #03a9f4;'";
        $th_amount = "style='border-right: 2px solid #03a9f4;width: 100px;text-align:center;border-bottom: 2px solid #03a9f4;'";
        $table  = '<table class="table" style="border:2px solid #03a9f4;">';
        $table .= '<thead>';
        $table .= '<th ' . $thead . '><b>' . _l('s_no') . '</b></th>';
        $table .= '<th ' . $th . '><b>' . _l('account_number') . '</b></th>';
        $table .= '<th ' . $thead . '><b>' . _l('date') . '</b></th>';
        $table .= '<th ' . $th_amount . '><b>' . _l('amount') . '</b></th>';
        $table .= '<th ' . $thead . '><b>' . _l('payment_type') . '</b></th>';
        $table .= '<th ' . $thead . '><b>' . _l('transaction_id') . '</b></th>';
        $table .= '<th ' . $th . '><b>' . _l('account_name') . '</b></th>';
        $table .= '<th ' . $th_amount . '><b>' . _l('statement_balance') . '</b></th>';
        $table .= '<th ' . $th_amount . '><b>' . _l('post_upload_balance') . '</b></th>';
        $table .= '<th ' . $thead . '><b>' . _l('data_status') . '</b></th>';
        $table .= '<th ' . $thead . '><b>' . _l('account_status') . '</b></th>';
        $table .= '</thead>';
        $table .= '<tbody>';
        $a = 1;

        $base_currency   = base_currency_get();
        $total_amount = 0;
        $client_amount_details = [];
        foreach ($result as $res) {
            if (!empty($res[2])) {
                $total_amount = $total_amount + (preg_replace("/[^0-9.]/", "", $res[2]));

                $statement_balance_total = get_statement_balance_show($res[0]);
                $statement_record = get_statement_balance_record($res[0]);

                $data_client  = get_statement_balance($res[0]);
                $invoicepayment_record_amount = 0;
                foreach ($data_client as $clientdata) {
                    $invoicepayment_record = check_invoice_paymentrecords($clientdata['id']);
                    $invoicepayment_record_amount = $invoicepayment_record_amount + $invoicepayment_record->amount;
                }
                if (array_key_exists($res[0], $client_amount_details)) {
                    $statement_balance['total'] = $client_amount_details[$res[0]];
                } else {
                    $statement_balance['total'] = $statement_balance_total['total'] - $invoicepayment_record_amount;
                }

                $client_data = get_client_data($res[0]);
                $payment_type = get_payment_mode($res[3]);
                $post_upload = ($statement_balance['total'] - (preg_replace("/[^0-9.]/", "", $res[2])));
                $post_upload_balance = ($post_upload < 0) ? '(' . abs($post_upload) . ')' : abs($post_upload);
                $client_amount_details[$res[0]] = $post_upload_balance;

                if (empty($statement_record)) {
                    $check = 'style="color:red;"';
                    $account_status = "Error";
                } else {
                    $check = "";
                    $account_status = ($client_data->active == 1) ? "Active" : "Inactive";
                }
                $end_date = date('m/d/Y H:i:s', strtotime(date('m/d/Y') . ' -' . '15' . ' day'));
                if (strtotime(date('m/d/Y H:i:s')) < strtotime($res[1]) || strtotime($res[1]) < strtotime($end_date)) {
                    $td_date = "style='border-right: 2px solid #03a9f4;color:red;text-align:center;'";
                    $data_status = "Error";
                } else {
                    $td_date = "style='border-right: 2px solid #03a9f4;text-align:center;'";
                    $data_status = "Okay";
                }
                $table .= '<tr ' . $check . '>';
                $table .= '<td ' . $td . '>' . $a . '</td>';
                $table .= '<td ' . $td . '>' . $res[0] . '</td>';
                $table .= '<td ' . $td_date . '>' . $res[1] . '</td>';
                $table .= '<td ' . $td . '>' . $base_currency->symbol . " " .  $res[2] . '</td>';
                $table .= '<td ' . $td . '>' . $payment_type->name . '</td>';
                $table .= '<td ' . $td . '>' . $res[4] . '</td>';
                $table .= '<td ' . $td . '>' . $client_data->company . '</td>';
                $table .= '<td ' . $td . '>' . $base_currency->symbol . " " . number_format((float)$statement_balance['total'], 2, '.', '') . '</td>';
                $table .= '<td ' . $td . '>' . $base_currency->symbol . " " . $post_upload_balance . '</td>';
                $table .= '<td ' . $td_date . '>' . $data_status . '</td>';
                $table .= '<td ' . $td . '>' . $account_status . '</td>';
                $table .= '</tr>';
                $a++;
            }
        }
        $table .= '</tbody>';
        $table .= '</table>';

        $this->load->library('pdf');
        $html = '<div style="text-align:center;color:#03a9f4;margin-bottom:10px;"><h1>' . _l('bulk_offline_payments_detail') . " " . date('d-m-Y') . '</h1></div>' . $table;
        $html .= '<div style="margin-top:10px;float:right;"><span><b>Total Amount :- </b> ' . $base_currency->symbol . ' ' . $total_amount . '</span></div>';
        $file_name = 'payment_' . strtotime(date("Y-m-d H:i:s")) . '_' . rand(1000, 10000);
        $path = './modules/cbn/uploads/pdf_files/' . $file_name;
        $this->pdf->createPDF($html, $path, false);

        $last_id = bulk_offline_payments_last_id();
        $id = ($last_id['id'] + 1);
        $account_number = "UP" . "-" . substr((1000 + $id), 1);
        $uploaded_staff = get_current_staff_name($this->session->userdata('staff_user_id'));
        $uploaded_by = $uploaded_staff['firstname'] . $uploaded_staff['lastname'];
        if ($file_name != "") {
            $this->load->library('import/import_payments', [], 'import');
            $csv_result = $this->import->setSimulation($this->input->post('simulate'))
                ->setTemporaryFileLocation($_FILES['file_csv']['tmp_name'])
                ->setFilename($_FILES['file_csv']['name'])
                ->perform();
            foreach ($csv_result as $res) {
                $data_client  = get_statement_balance($res[0]);
                $client_data  = get_client_data($res[0]);
                $paid_amount  = $res[2];
                $post_balance = 0;
                $invoice_id   = 0;
                foreach ($data_client as $clientdata) {
                    if ($clientdata['status'] == '2') {
                        $tamount = 0;
                        $post_balance = (preg_replace("/[^0-9.]/", "", $paid_amount));
                        $payment_status = 2;
                    } else {
                        $invoicepayment_record = check_invoice_paymentrecords($clientdata['id']);
                        $invoice_totalamount = ($invoicepayment_record->amount == "") ? 0 : $invoicepayment_record->amount;
                        $post_upload = ($clientdata['total'] - ($invoice_totalamount + preg_replace("/[^0-9.]/", "", $paid_amount)));
                        if ($post_upload <= 0) {
                            $tamount = ($clientdata['total'] - $invoice_totalamount);
                            $post_balance = abs($post_upload);
                            $paid_amount = abs($post_upload);
                            $payment_status = 2;
                        } else {
                            $tamount = (preg_replace("/[^0-9.]/", "", $paid_amount));
                            $post_balance = 0;
                            $paid_amount = 0;
                            $payment_status = 3;
                        }
                    }
                    $invoice_data = [
                        'status' => $payment_status,
                    ];
                    $invoicepayment = [
                        'invoiceid' => $clientdata['id'],
                        'amount' => $tamount,
                        'paymentmode' => $res[3],
                        'date' => date_format(date_create($res[1]), "Y-m-d"),
                        'daterecorded' => date("Y-m-d h:i:s"),
                        'transactionid' => $res[4],
                    ];
                    update_invoice_data($clientdata['id'], $invoice_data);
                    if ($tamount != 0) {
                        $invoice_id = insert_invoicepaymentrecords($invoicepayment);
                    }
                }
                $check_post_upload = check_post_upload_balance($client_data->userid);
                $invoice_post_balance = ($check_post_upload->post_upload_balance == "") ? 0 : $check_post_upload->post_upload_balance;
                if ($invoice_post_balance != 0 && $post_balance != 0) {
                    $invoice_post_upload_balance = [
                        'post_upload_balance' => ($invoice_post_balance + $post_balance),
                    ];
                    update_invoice_postuploadbalance($invoice_post_upload_balance, $client_data->userid);
                } else {
                    if ($post_balance != 0) {
                        $post_upload_data = [
                            'clientid' => $client_data->userid,
                            'post_upload_balance' => $post_balance,
                        ];
                        insert_invoice_postuploadbalance($post_upload_data);
                    }
                }
            }
            $data = [
                'upload' => $account_number,
                'uploaded_by' => $uploaded_by,
                'number_of_accounts' => $this->input->post("no_of_account"),
                'amount' => $this->input->post("total_amount"),
                'status' => "1",
                'date'   => date("m/d/Y"),
                'report' => $file_name,
            ];
            $base_currency   = base_currency_get();
            $btn_name = _l('clear_data');
            $confirm_upload = 2;
            $msg = $this->input->post("no_of_account") . " " . _l('payment_upload') . " " . "for" . " " . $base_currency->symbol . $this->input->post("total_amount");
            if (has_permission('bulk_offline_payments', '', 'view')) { 
            $msg .= '<div style="margin-top:10px;">';
            $msg .= '<a class="btn btn-outline-primary" href="' . base_url() . 'modules/cbn/uploads/pdf_files/' . $file_name . '.pdf" download>' . _l('download_invoice') . '</a>';
            $msg .= '</div>';
            }

            if (insert_bulk_offline_payments($data)) {
                echo json_encode(['status' => 'true', 'message' => $msg, 'btn' => $btn_name, 'confirm_upload' => $confirm_upload]);
            }
        } else {
            echo json_encode(['status' => 'false', 'message' => 'File Not Upload']);
        }
    }

    public function download_sample_csv()
    {
        $this->load->library('import/import_payments', [], 'import');
        $file_path = base_url() . "modules/cbn/" . $this->input->post('download_sample');
        $this->import->downloadSample($file_path);
    }
    public function access_denied(){
        access_denied('bulk_offline_payments');
    }
}
