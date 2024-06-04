<?php
// *	@copyright	OPENCART.PRO 2011 - 2016.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ModelStepStep3 extends Model {

    public function addStep($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "step3 SET image = '" . $data['image'] . "', step2_id = '" . (int)$data['step2_id'] . "'");

        $step_id = $this->db->getLastId();

        foreach ($data['step_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "step3_description SET step3_id = '" . (int)$step_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', url = '" . $this->db->escape($value['url']) . "'");
        }

        //$this->cache->delete('step');

        return $step_id;
    }

    public function editStep($step_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "step3 SET image = '" . $data['image'] . "', step2_id = '" . (int)$data['step2_id'] . "' WHERE step3_id = '" . (int)$step_id . "'");

        $this->db->query("DELETE FROM " . DB_PREFIX . "step3_description WHERE step3_id = '" . (int)$step_id . "'");

        foreach ($data['step_description'] as $language_id => $value) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "step3_description SET step3_id = '" . (int)$step_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', url = '" . $this->db->escape($value['url']) . "'");
        }


    }

    public function deleteStep($step_id) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "step3 WHERE step3_id = '" . (int)$step_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "step3_description WHERE step3_id = '" . (int)$step_id . "'");


    }

    public function getSteps($data = array()) {
            $sql = "SELECT * FROM " . DB_PREFIX . "step3 s LEFT JOIN " . DB_PREFIX . "step3_description sd ON (s.step3_id = sd.step3_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

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
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step3 s LEFT JOIN " . DB_PREFIX . "step3_description sd ON (s.step3_id = sd.step3_id) WHERE s.step3_id = '" . (int)$step_id . "' AND sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }


    public function getStepDescriptions($step_id) {
        $step_data = array();

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step3_description WHERE step3_id = '" . (int)$step_id . "'");

        foreach ($query->rows as $result) {
            $step_data[$result['language_id']] = array(
                'title' => $result['title'],
                'url' => $result['url'],
            );
        }

        return $step_data;
    }

    public function getTotalStep() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "step3");

        return $query->row['total'];
    }

    public function getStep2() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "step2 s LEFT JOIN " . DB_PREFIX . "step2_description sd ON (s.step2_id = sd.step2_id) WHERE sd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->rows;
    }

}
