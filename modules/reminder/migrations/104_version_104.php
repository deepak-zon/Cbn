<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Version_104 extends App_module_migration
{
	public function up()
	{
		$CI = &get_instance();
		$Table = db_prefix() . 'reminders';

		if (!$CI->db->table_exists(db_prefix() . 'reminder_services')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . 'reminder_services` (
				`id` int(11) NOT NULL,
				`service_name` varchar(200) DEFAULT NULL,
				`service_amount` int(200) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

			$CI->db->query('ALTER TABLE `' . db_prefix() . 'reminder_services`
				ADD PRIMARY KEY (`id`);');

			$CI->db->query('ALTER TABLE `' . db_prefix() . 'reminder_services`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
		}

		if (!$CI->db->table_exists(db_prefix() . 'reminder_service_value')) {
			$CI->db->query('CREATE TABLE `' . db_prefix() . 'reminder_service_value` (
				`id` int(11) NOT NULL,
				`rem_id` int(40) DEFAULT NULL,
				`service_id` int(40) DEFAULT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=' . $CI->db->char_set . ';');

			$CI->db->query('ALTER TABLE `' . db_prefix() . 'reminder_service_value`
				ADD PRIMARY KEY (`id`);');

			$CI->db->query('ALTER TABLE `' . db_prefix() . 'reminder_service_value`
				MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;');
		}

		  $row_exists = $CI->db->query('SELECT * FROM ' . db_prefix() . 'emailtemplates WHERE type = "client" and slug = "reminder-service-send-to-contact" and language = "english";')->row();
		  if (!$row_exists) {
		    $message = '<p>Hi {contact_name}<br /><br /><strong>Description:</strong> {item_description}<br /></p>';
		    $CI->db->query("INSERT INTO `" . db_prefix() . "emailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES ('client', 'reminder-service-send-to-contact', 'english', 'Services', 'New Service','" . $message . "','', NULL, 0, 1, 0);");
		    foreach ($CI->app->get_available_languages() as $avLanguage) {
		      if ($avLanguage != 'english') {
		        $CI->db->query("INSERT INTO `" . db_prefix() . "emailtemplates` (`type`, `slug`, `language`, `name`, `subject`, `message`, `fromname`, `fromemail`, `plaintext`, `active`, `order`) VALUES ('client', 'reminder-service-send-to-contact', '" . $avLanguage . "', 'Services [" . $avLanguage . "]', 'New Service','" . $message . "','', NULL, 0, 1, 0);");
		      }
		    }
		}
	}
}