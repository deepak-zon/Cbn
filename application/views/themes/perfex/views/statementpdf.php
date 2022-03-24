<?php

defined('BASEPATH') or exit('No direct script access allowed');
$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column  = '';

$info_right_column = '<div style="color:#424242;">';
$info_right_column .= format_organization_info();
$info_right_column .= '</div>';

// Add logo
$info_left_column .= pdf_logo_url();
// Write top left logo and right column info/text
pdf_multi_row($info_left_column, $info_right_column, $pdf, ($dimensions['wk'] / 2) - $dimensions['lm']);

$pdf->ln(10);

// Get Y position for the separation
$y = $pdf->getY();

// Bill to
$client_details = '<b>' . _l('statement_bill_to') . '</b>';
$client_details .= '<div style="color:#424242;">';
$client_details .= format_customer_info($statement['client'], 'statement', 'billing');
$client_details .= '</div>';

$pdf->writeHTMLCell(($dimensions['wk'] / 2) - $dimensions['lm'] + 15, '', '', $y, $client_details, 0, 0, false, true, 'J', true);

$summary = '';
$summary .= '<h2>' . _l('account_summary') . '</h2>';
$summary .= '<div style="color:#676767;">' . _l('statement_from_to', [
    _d($statement['from']),
    _d($statement['to']),
]) . '</div>';
$summary .= '<p><b>Account Number : </b>' . $statement['client']->account_number . '</p>';
$summary .= '<hr />';
$summary .= '
<table cellpadding="4" border="0" style="color:#424242;" width="100%">
   <tbody>
      <tr>
          <td align="left"><br /><br />' . _l('statement_beginning_balance') . ':</td>
          <td><br /><br />' . app_format_money($statement['beginning_balance'], $statement['currency']) . '</td>
      </tr>
      <tr>
          <td align="left">' . _l('invoiced_amount') . ':</td>
          <td>' . app_format_money($statement['invoiced_amount'], $statement['currency']) . '</td>
      </tr>
      <tr>
          <td align="left">' . _l('amount_paid') . ':</td>
          <td>' . app_format_money($statement['amount_paid'], $statement['currency']) . '</td>
      </tr>
  </tbody>
  <tfoot>
      <tr>
        <td align="left"><b>' . _l('balance_due') . '</b>:</td>
        <td>' . app_format_money($statement['balance_due'], $statement['currency']) . '</td>
    </tr>
  </tfoot>
</table>';

$pdf->writeHTMLCell(($dimensions['wk'] / 2) - $dimensions['rm'] - 15, '', '', '', $summary, 0, 1, false, true, 'R', true);


$summary_info = '
<div style="text-align: center;">
    ' . _l('customer_statement_info', [
    _d($statement['from']),
    _d($statement['to']),
]) . '
</div>';

$pdf->ln(9);
$pdf->writeHTMLCell($dimensions['wk'] - ($dimensions['rm'] + $dimensions['lm']), '', '', $pdf->getY(), $summary_info, 0, 1, false, true, 'C', false);
$pdf->ln(9);

$tmpBeginningBalance = $statement['beginning_balance'];

$tblhtml = '<table width="100%" cellspacing="0" cellpadding="8" border="0">
<thead>
 <tr height="10" bgcolor="#e8e8e8" style="color:#424242;">
     <th width="13%"><b>' . _l('statement_heading_date') . '</b></th>
     <th width="27%"><b>' . _l('statement_heading_details') . '</b></th>
     <th align="right"><b>' . _l('statement_heading_amount') . '</b></th>
     <th align="right"><b>' . _l('statement_heading_payments') . '</b></th>
     <th align="right"><b>' . _l('statement_heading_balance') . '</b></th>
 </tr>
</thead>
<tbody>
 <tr>
     <td width="13%">' . _d($statement['from']) . '</td>
     <td width="27%">' . _l('statement_beginning_balance') . '</td>
     <td align="right">' . app_format_money($statement['beginning_balance'], $statement['currency'], true) . '</td>
     <td></td>
     <td align="right">' . app_format_money($statement['beginning_balance'], $statement['currency'], true) . '</td>
 </tr>';
$count = 0;
foreach ($statement['result'] as $data) {
    $tblhtml .= '<tr' . (++$count % 2 ? ' bgcolor="#f6f5f5"' : '') . '>
  <td width="13%">' . _d($data['date']) . '</td>
  <td width="27%">';
    if (isset($data['invoice_id'])) {
        $tblhtml .= _l('statement_invoice_details', [
            format_invoice_number($data['invoice_id']),
            _d($data['duedate']),
        ]);
    } elseif (isset($data['payment_id'])) {
        $tblhtml .= _l('statement_payment_details', [
            '#' . $data['payment_id'],
            format_invoice_number($data['payment_invoice_id']),
        ]);
    } elseif (isset($data['credit_note_id'])) {
        $tblhtml .= _l('statement_credit_note_details', format_credit_note_number($data['credit_note_id']));
    } elseif (isset($data['credit_id'])) {
        $tblhtml .= _l('statement_credits_applied_details', [
            format_credit_note_number($data['credit_applied_credit_note_id']),
            app_format_money($data['credit_amount'], $statement['currency'], true),
            format_invoice_number($data['credit_invoice_id']),
        ]);
    } elseif (isset($data['credit_note_refund_id'])) {
        $tblhtml .= _l('statement_credit_note_refund', format_credit_note_number($data['refund_credit_note_id']));
    }

    $tblhtml .= '</td>
    <td align="right">';
    if (isset($data['invoice_id'])) {
        $tblhtml .= app_format_money($data['invoice_amount'], $statement['currency'], true);
    } elseif (isset($data['credit_note_id'])) {
        $tblhtml .= app_format_money($data['credit_note_amount'], $statement['currency'], true);
    }
    $tblhtml .= '</td>
        <td align="right">';
    if (isset($data['payment_id'])) {
        $tblhtml .= app_format_money($data['payment_total'], $statement['currency'], true);
    } elseif (isset($data['credit_note_refund_id'])) {
        $tblhtml .= app_format_money($data['refund_amount'], $statement['currency'], true);
    }
    $tblhtml .= '</td>
            <td align="right">';
    if (isset($data['invoice_id'])) {
        $tmpBeginningBalance = ($tmpBeginningBalance + $data['invoice_amount']);
    } elseif (isset($data['payment_id'])) {
        $tmpBeginningBalance = ($tmpBeginningBalance - $data['payment_total']);
    } elseif (isset($data['credit_note_id'])) {
        $tmpBeginningBalance = ($tmpBeginningBalance - $data['credit_note_amount']);
    } elseif (isset($data['credit_note_refund_id'])) {
        $tmpBeginningBalance = ($tmpBeginningBalance + $data['refund_amount']);
    }
    if (!isset($data['credit_id'])) {
        $tblhtml .= app_format_money($tmpBeginningBalance, $statement['currency'], true);
    }

    $tblhtml .= '</td>
            </tr>';
}
$tblhtml .= '</tbody>
        <tfoot>
         <tr style="color:#424242;">
             <td></td>
             <td></td>
             <td align="right"><b>' . _l('balance_due') . '</b></td>
             <td></td>
             <td align="right">
                 <b>' . app_format_money($statement['balance_due'], $statement['currency']) . '</b>
             </td>
         </tr>
     </tfoot>
 </table>';

$tblhtml .= '<table border="0" cellspacing="0" cellpadding="5" width="100%">
<tr>
  <td align="center" colspan="3">
     <div style="border-bottom: 2px dashed black;"></div>
     <br>
      <b>(Remit to slip. Please do not staple, paperclip or tape payment to slip.)</b>
  </td>
</tr>
<tr>
    <td>
      &nbsp;<img width="300" height="80" src="' . get_upload_path_by_type('company') . get_option('company_logo') . '">
    </td>
    <td>
       <table border="0" cellspacing="0" cellpadding="1" width="100%">
         <tr>
             <td>
                  <input type="checkbox" name="agree" value="1" checked="checked" readonly="true" /> <label for="agree" style="font-size: 12px;">Check enclosed </label>
             </td> 
         </tr>
         <tr>
              <td>
                  <input type="checkbox" name="agree" value="1" readonly="true" /> <label for="agree" style="font-size: 12px;">I hereby authorise to charge my card</label>
               </td>
         </tr>
        </table>
    </td>
    <td>
        <table border="0" cellspacing="0" cellpadding="1" width="100%">
            <tr>
                <td>
                    <input type="checkbox" name="agree" value="1" checked="checked" readonly="true" /> <label for="agree" style="font-size: 12px;">VISA</label>
                </td>

                <td>
                    <input type="checkbox" name="agree" value="1"  readonly="true" /> <label for="agree" style="font-size: 12px;">AMEX</label>
                </td>
            </tr>

            <tr>
                <td>
                    <input type="checkbox" name="agree" value="1" readonly="true" /> <label for="agree" style="font-size: 12px;">Mastercard</label>
                </td>
                <td>
                    <input type="checkbox" name="agree" value="1" readonly="true" /> <label for="agree" style="font-size: 12px;">Discover</label>
                </td>
            </tr>

        </table>
    </td>
</tr>

<tr>
    <td align="left" width="35%">
        <b>  Please Remit Payment to:</b>
        <p style="text-align: left;">
            <b style="font-size: 12px;">
               CRYSTAL BROADBAND NETWORK <br> &nbsp; &nbsp; PO BOX 580 CLAY CITY KY  40312-0580
          </b>
        </p>
    </td>
    <td width="25%" valign="bottom">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td>
                <div style="border-bottom: 1px solid black;"></div>
                <span style="font-size: 12px;">Authorized Signature</span>
                </td>
            </tr>
        </table>
    </td>
    <td>
        <table border="0" cellspacing="0" cellpadding="3" width="100%">
            <tr>
                <td width="40%" style="font-size: 12px;">Credit Card No</td>
                <td colspan="4" width="60%" style="border-bottom: 1px solid black;"></td>
            </tr>
            <tr>
                <td width="40%" style="font-size: 12px;">Expiry Date</td>
                <td width="30%" style="border-bottom: 1px solid black;"></td>
                <td align="center">/</td>
                <td width="30%" style="border-bottom: 1px solid black;"></td>
            </tr>
        </table>
    </td>
</tr>

<tr>
    <td colspan="3">
       <table border="0" cellspacing="0" cellpadding="0" width="100%">
         <tr>
             <td width="80%" valign="top">
                  <b style="font-size: 14px; margin: 0">Amount due if payment received in our office by &nbsp; ' . $statement['result'][1]['duedate'] . ' &nbsp; ' . app_format_money($statement['balance_due'], $statement['currency']) . '<br>
                  Payment received after due date are subject to a $8.00 late fee.</b>
             </td>
         </tr>
         <tr>
            <td width="60%" valign="top">
                 
             </td>
             <td width="60%" valign="top">
                 <b style="font-size: 14px; margin: 0">Amount Paid: &nbsp;<span>' . app_format_money($statement['amount_paid'], $statement['currency']) . '</span></b>
             </td>
         </tr>
        </table>
    </td>
</tr>

<tr>
   <td width="10%"></td>
    <td width="40%" valign="top">
      <p style="margin: 0;font-size: 14px;"><b> ABC Corp<br> 100 Main St,<br> Clay City, KY 40312</b></p>
    </td>
     <td width="50%" valign="top">
         <p style="margin: 0; font-size: 14px;"><b> For Services at:<br> 100 Main St, Clay City, KY <br> ' . $statement['client']->account_number . '</b></p>
     </td>   
</tr>

</table>';

$pdf->writeHTML($tblhtml, true, false, false, false, '');
