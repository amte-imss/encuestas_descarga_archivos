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
     * 
     * @param type $year Año de los cursos
     * @return type Volumetria basica de los cirsos e implementaciones
     */
    public function get_volumetria($year = '') {
        $this->db->flush_cache();
        $this->db->reset_query();
        if(empty($year)){
            return [];
        }
        $select = array(
            'mc.id "id_curso"', "TRIM(replace(mc.shortname, substring(mc.shortname from '\-\w\d+\-\d+$'),'')) clave_curso",
            'mc.shortname nombre_corto', 'mc.fullname nombre_curso', "mcc.tutorizado",
            'date(to_timestamp(mc.startdate)) fecha_inicio', 'mcc.lastdate fecha_fin', 
            "substring(mc.shortname from '(\w\d+)') implementacion", 
            "CASE WHEN  mcc.lastdate > date(now()) then 0 else 1 end es_curso_cerrado"
        );
        $this->db->select($select);
        $this->db->join("public.mdl_course_config mcc", "mcc.course = mc.id", "INNER");
        $this->db->order_by('mc.shortname');
        $this->db->where("EXTRACT(year from mcc.lastdate) = " . $year);

        $result = $this->db->get('public.mdl_course mc')->result_array();
        return $result;
    }

}
