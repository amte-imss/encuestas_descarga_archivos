<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Clase que gestiona el login
 * @version 	: 1.0.0
 * @autor 		: Pablo José
 */
class Operaciones extends MY_Controller {

    const DESCARGA_ANIO_VOLUMETRIA = 0,
            DESCARGA_ANIO_CONCENTRADO_ALUMNOS = 1,
            DESCARGA_IMPLEMENTACION_CONCENTRADO_ALUMNOS = 2

    ;

    /**
     * * Carga de clases para el acceso a base de datos y para la creación de elementos del formulario
     * * @access 		: public
     * * @modified 	:
     */
    public function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('form_validation'); //implemantación de la libreria form validation
        $this->load->library('form_complete'); // form complete
        $this->load->library('csvimport');
        $this->load->model('Operativa_model', 'opmod'); //Carga los reportes model
    }

    public function index() {
        //$modulos_acceso = $this->session->userdata("modulos_acceso");
        $modulos_acceso = $this->get_modulos_habilitados();
//        pr($modulos_acceso);
        $datos['encuestas'] = $this->enc_mod->listado_instrumentos();
        $datos['secciones_acceso'] = $modulos_acceso;

        $main_contet = $this->load->view('encuesta/encuestas', $datos, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    /**
     * 
     * @param type $filtros puede ser los de descarga de archivo de volumetria 
     * o concentrado de certificado de alumnos "volumetria_implementaciones"
     * "concentrado_certificado_alumnos" para estos modulos en especifico
     * @return type
     */
    private function get_filters($filtros = array('volumetria_implementaciones')) {
        $this->load->model('Reporte_model', 'rep_mod'); //Carga los reportes model
        $data_filter = $this->rep_mod->get_filtros_grupo($filtros);
        return $data_filter;
    }

    public function volumetria() {
        $this->template->setMainTitle("Volumetría");
        $data["data_elements"] = $this->get_filters(['volumetria_implementaciones']); //Obtiene los filtros necesarios para este modulo
        $data["config"]['reporte_volumetria_anio'] = Operaciones::DESCARGA_ANIO_VOLUMETRIA; //Obtiene los filtros necesarios para este modulo
//        pr($data);
        $main_contet = $this->load->view('operativa/volumetria.tpl.php', $data, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function concentrado_alumnos() {

        $this->template->setMainTitle("Concentrado de certificado de alumnos");
        $main_contet = $this->load->view('operativa/concentrado_alumnos.tpl.php', null, true);
        $this->template->setMainContent($main_contet);
        $this->template->getTemplate();
    }

    public function get_opciones_descarga($opcion = null) {
        $result = null;
        switch ($opcion) {
            case Operaciones::DESCARGA_ANIO_VOLUMETRIA:
                $result = $this->get_volumetria_anio();
                break;
            case Operaciones::DESCARGA_ANIO_CONCENTRADO_ALUMNOS:
                $result = $this->get_concentrado_anio();
                break;
            case Operaciones::DESCARGA_IMPLEMENTACION_CONCENTRADO_ALUMNOS:
                $result = $this->get_concentrado_implementaciones();
                break;
        }
//        pr($result);
        echo json_encode($result);
    }

    private function get_volumetria_anio() {
        $result['head'] = array(//Mover el orden de las columnas, esto mueve el orden en que apareceran en la descarga 
            'id_curso' => 'id_curso',
            'clave_curso' => 'clave_curso',
            'nombre_corto' => 'nombre_corto',
            'nombre_curso' => 'nombre_curso',
            'implementacion' => 'implementacion',
            'fecha_inicio' => 'fecha_inicio',
            'fecha_fin' => 'fecha_fin',
            'tutorizado' => 'tutorizado',
            'es_curso_cerrado' => 'es_curso_cerrado',
        );
        $post = $this->input->post(null, true); //Obtiene datos del post
        $result['data'] = $this->opmod->get_volumetria($post['anio']);
        return $result;
    }

    private function get_concentrado_anio() {
        return [];
    }

    private function get_concentrado_implementaciones() {
        return [];
    }

    public function cargar_instrumento() {
        if ($this->input->post()) {     // SI EXISTE UN ARCHIVO EN POST
            $this->carga_csv_datos();
        } else {
            $datos = [];
            $main_contet = $this->load->view('encuesta/carga_encuestas', $datos, true);
            $this->template->setMainTitle('Cargar instrumento por archivo CSV');
            $this->template->setMainContent($main_contet);
            $this->template->getTemplate();
        }
    }

    private function carga_csv_datos() {
        $this->load->model('Catalogos_model', 'catalogo');
        $this->load->model('CSV_Encuestas_model', 'csv_model');
        $output = [];
        $config['upload_path'] = './uploads/';      // CONFIGURAMOS LA RUTA DE LA CARGA PARA LA LIBRERIA UPLOAD
        $config['allowed_types'] = 'csv';           // CONFIGURAMOS EL TIPO DE ARCHIVO A CARGAR
        $config['max_size'] = '1000';               // CONFIGURAMOS EL PESO DEL ARCHIVO

        $this->load->library('upload', $config);    // CARGAMOS LA LIBRERIA UPLOAD
        if (!$this->upload->do_upload()) {
            // SI EL PROCESO DE CARGA ENCONTRO UN ERROR
            $output['status']['status'] = false;
            $output['status']['msg'] = 'Ocurrió un error al cargar el instrumento';
            $output['error_upload']['carga_csv'] = $this->upload->display_errors();      // CARGAR EN LA VARIABLE ERROR LOS ERRORES ENCONTRADOS
        } else {                      // SI NO SE ENCONTRARON ERRORES EN EL PROCES
            $file_data = $this->upload->data();     //BUSCAMOS LA INFORMACIÓN DEL ARCHIVO CARGADO
            $file_path = './uploads/' . $file_data['file_name'];         // CARGAMOS LA URL DEL ARCHIVO
            $csv_array = $this->csvimport->get_array($file_path);   //SI EXISTEN DATOS, LOS CARGAMOS EN LA VARIABLE
            $output['status'] = $this->csv_model->guarda_encuesta($csv_array);
            $output['csv'] = $csv_array;
            unlink($file_path);
        }
        // pr($output);
        $output['mensajes'] = $tipo_msg = $this->config->item('alert_msg');
        $main_content = $this->load->view('encuesta_v2/carga_csv.tpl.php', $output, true);
        $this->template->setMainContent($main_content);
        $this->template->getTemplate();
        // $this->output->enable_profiler(true);
    }

    /*
     * Exporta detalles de encuesta, preguntas y opciones de respuesta a archivo XLS. Mismo formato que plantilla utilizada para importación de datos de encuesta
     * @param   $id_instrumento integer Identificador del instrumento a exportar
     * @return  Archivo xls
     */

    public function exportar_xls($id_instrumento = 0) {
        if ($id_instrumento === 0) {
            redirect(site_url('encuestas'));
        }
        $data = $this->enc_mod->exportar_xls_datos($id_instrumento); //Obtener datos
        ////Generación de cabeceras
        $archivo = "Exportar_instrumento_" . date("d-m-Y_H-i-s") . ".xls"; //Nombre de archivo
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8;");
        header("Content-Encoding: UTF-8");
        header("Content-Disposition: attachment; filename=$archivo");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "\xEF\xBB\xBF"; // UTF-8 BOM. Necesaria para que respete acentos
        echo $this->load->view('encuesta/exportar_xls', $data, TRUE);
    }

    /*
     * Exporta detalles de encuesta, preguntas y opciones de respuesta a archivo PDF.
     * @param   $id_instrumento integer Identificador del instrumento a exportar
     * @return  Archivo pdf
     */

    public function exportar_pdf($id_instrumento = 0) {
        if ($id_instrumento === 0) {
            redirect(site_url('encuestas'));
        }
        $this->load->library('my_dompdf');

        $data = $this->enc_mod->exportar_xls_datos($id_instrumento); //Obtener datos

        $vista = $this->load->view('encuesta/exportar_pdf', $data, TRUE); //Obtener vista

        $this->my_dompdf->convert_html_to_pdf('Exportar_instrumento_' . date("d-m-Y_H-i-s"), $vista); //Exportar a PDF
    }

}
