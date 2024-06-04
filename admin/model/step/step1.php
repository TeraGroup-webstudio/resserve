<?php
// *	@copyright	OPENCART.PRO 2011 - 2016.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelStepStep1 extends Model {

    public function addStep($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "step1 SET image = '" . $data['image'] . "'");

        $step_id = $this->db->getLastId();

        foreach ($data['step_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "step1_description SET step1_id = '" . (int)$step_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "'");
        }

        //$this->cache->delete('step');

        return $step_id;
    }

    public function editStep($step_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "step1 SET image = '" . $data['image'] . "' WHERE step1_id = '" . (int)$step_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "step1_description WHERE step1_id = '" . (int)$step_id . "'");

        foreach ($data['step_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "step1_description SET step1_id = '" . (int)$step_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "'");
        }


    }

    public function deleteStep($step_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "step1 WHERE step1_id = '" . (int)$step_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "step1_description WHERE step1_id = '" . (int)$step_id . "'");


    }

    public function getSteps($data = array()) {
            $sql = "SELECT * FROM " . DB_PREFIX . "step1 s LEFT JOIN " . DB_PREFIX . "step1_description sd ON (s.step1_id = sd.step1_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

            $sort_data = array(
                'title',
            );

            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'];
            } else {
                $sql .= " ORDER BY title";
            }

            if (isset($data['order']) && ($data['order'] == 'DESC')) {
                $sql .= " DESC";
            } else {
                $sql .= " ASC";
            }

            if (isset($data['start']) || isset($data['limit'])) {
                if ($data['start'] < 0) {
                    $data['start'] = 0;
                }

                if ($data['limit'] < 1) {
                    $data['limit'] = 20;
                }

                $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            }

            $query = $this->db->query($sql);

            return $query->rows;
    }

    public function getStep($step_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step1 s LEFT JOIN " . DB_PREFIX . "step1_description sd ON (s.step1_id = sd.step1_id) WHERE s.step1_id = '" . (int)$step_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }


    public function getStepDescriptions($step_id) {
        $step_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step1_description WHERE step1_id = '" . (int)$step_id . "'");

        foreach ($query->rows as $result) {
            $step_data[$result['language_id']] = array(
                'title' => $result['title'],
            );
        }

        return $step_data;
    }

    public function getTotalStep() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "step1");

        return $query->row['total'];
    }

}
