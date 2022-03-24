<?php

defined('BASEPATH') or exit('No direct script access allowed');

if (!$CI->db->table_exists(db_prefix() . 'states')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'states` (
    `id` int(11) NOT NULL,
    `state_name` varchar(200) DEFAULT NULL,
    `state_short_letters` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'states`
  ADD PRIMARY KEY (`id`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
}

if (!$CI->db->table_exists(db_prefix() . 'systems')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'systems` (
    `id` int(11) NOT NULL,
    `state_id` int(11) DEFAULT NULL,
    `system_name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'systems`
  ADD PRIMARY KEY (`id`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'systems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
}

if (!$CI->db->table_exists(db_prefix() . 'franchise')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'franchise` (
    `id` int(11) NOT NULL,
    `franchise_name` varchar(200) DEFAULT NULL,
    `franchise_number` int(200) DEFAULT NULL,
    `system_id` int(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'franchise`
  ADD PRIMARY KEY (`id`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'franchise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
}

if ($CI->db->table_exists(db_prefix() . 'clients')) {
  if (!$CI->db->field_exists('account_number', db_prefix() . 'clients')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'clients`
      ADD `account_number` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('franchise', db_prefix() . 'clients')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'clients`
      ADD `franchise` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('system', db_prefix() . 'clients')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'clients`
      ADD `system` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('ssn', db_prefix() . 'clients')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'clients`
      ADD `ssn` int(40) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('subscribed_service', db_prefix() . 'clients')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'clients`
      ADD `subscribed_service` varchar(200) DEFAULT NULL;');
  }
}

if ($CI->db->table_exists(db_prefix() . 'tickets')) {
  if (!$CI->db->field_exists('account_number', db_prefix() . 'tickets')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'tickets`
        ADD `account_number` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('system', db_prefix() . 'tickets')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'tickets`
        ADD `system` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('phonenumber', db_prefix() . 'tickets')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'tickets`
        ADD `phonenumber` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('service_address', db_prefix() . 'tickets')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'tickets`
        ADD `service_address` varchar(200) DEFAULT NULL;');
  }
  if (!$CI->db->field_exists('subscribed_service', db_prefix() . 'tickets')) {
    $CI->db->query('ALTER TABLE `' . db_prefix() . 'tickets`
        ADD `subscribed_service` varchar(200) DEFAULT NULL;');
  }
}

if (!$CI->db->table_exists(db_prefix() . 'bulk_offline_payments')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'bulk_offline_payments` (
    `id` int(11) NOT NULL,
    `upload` varchar(200) DEFAULT NULL,
    `date` varchar(200) DEFAULT NULL,
    `number_of_accounts` int(200) DEFAULT NULL,
    `amount` decimal(15,2) DEFAULT NULL,
    `uploaded_by` varchar(200) DEFAULT NULL,
    `status` int(200) DEFAULT NULL,
    `report` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'bulk_offline_payments`
  ADD PRIMARY KEY (`id`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'bulk_offline_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
}

if (!$CI->db->table_exists(db_prefix() . 'invoice_post_upload_balance')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'invoice_post_upload_balance` (
    `id` int(11) NOT NULL,
    `clientid` int(200) DEFAULT NULL,
    `post_upload_balance` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'invoice_post_upload_balance`
  ADD PRIMARY KEY (`id`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'invoice_post_upload_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
}

if (!$CI->db->table_exists(db_prefix() . 'services')) {
  $CI->db->query('CREATE TABLE `' . db_prefix() . 'services` (
    `serviceid` int(11) NOT NULL,
    `name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'services`
  ADD PRIMARY KEY (`serviceid`);');

  $CI->db->query('ALTER TABLE `' . db_prefix() . 'services`
  MODIFY `serviceid` int(11) NOT NULL AUTO_INCREMENT;');
}

if ($CI->db->table_exists(db_prefix() . 'payment_modes')) {
  $row_exists = $CI->db->query('SELECT * FROM ' . db_prefix() . 'payment_modes WHERE id = "2";')->row();
  if (!$row_exists) {
    $CI->db->query("INSERT INTO `" . db_prefix() . "payment_modes` (`name`) VALUES ('Offline Payment');");
  }
}
