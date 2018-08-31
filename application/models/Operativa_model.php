<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Modulo_model
 *
 * @author chrigarc
 */
class Operativa_model extends CI_Model {

    public function __construct() {
        // Call the CI_Model constructor
        parent::__construct();
        $this->config->load('general');
        $this->load->database();
    }

    /**
     * @update 22/11/2017 LEAS
     * @param type $id_aux
     * @param type $target
     * @param type $user
     * @return type Todos los años que registran cursos
     */
    public function get_anios_cursos($order = 'desc') {
        $this->db->flush_cache();
        $this->db->reset_query();
        $select = array(
            "to_char(to_timestamp(startdate),'yyyy')"
        );
        $this->db->select($select);
        $this->db->order_by('1' . $order);
        $this->db->group_by("to_char(to_timestamp(startdate),'yyyy')");

        $result = $this->db->get('public.mdl_course')->result_array();
        return $result;
    }

}
