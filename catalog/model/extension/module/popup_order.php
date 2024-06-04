<?php
class ModelExtensionModulePopupOrder extends Model {
	public function addRequest($data) {
		$this->db->query("INSERT INTO ".DB_PREFIX."popup_order SET info = '".$this->db->escape($data['info'])."', date_added = NOW()");
	}
}
?>