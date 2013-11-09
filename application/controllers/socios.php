<?php  
    class Socios extends CI_Controller
    {
        public function __construct()
        {
            //create a new library with the code an extend the code
            session_start();
            parent::__construct();

            if ( !isset($_SESSION['usuario']))
            {
                redirect('admin');
            }
            
           // $this->load->model('jugadores_model');
            $this->load->database();

            $this->load->library('grocery_crud');
        }
        public function index()  
        {
            /* Mandamos lo que llegue a administración */
            redirect('socios/administracion');
        }

        /*
         *
         **/

        function administracion()
        {
            try{

                $crud = new grocery_CRUD();

                //$crud->set_theme('datatables');
                $crud->set_theme('datatables');

                $crud->set_table('socios');

                $crud->set_relation_n_n('jugadores','socio_jugadores','jugadores','socio_id','jugador_id','completo');

                $crud->set_subject('Socios');

                $crud->set_language('spanish');

                $crud->required_fields(
                    'id',
                    'ref',
                    'nombre',
                    'apellidos',
                    'dni',
                    'domicilio',
                    'poblacion',
                    'telefono1');

                $crud->columns(
                    'ref',
                    'nombre',
                    'apellidos',
                    'telefono1');

                $crud->fields(
                    'ref',
                    'nombre',
                    'apellidos',
                    'dni',
                    'jugadores',
                    'domicilio',
                    'poblacion',
                    'telefono1',
                    'telefono2'
                    );

                $crud->callback_after_insert(array($this, 'insertar_completo'));

                $crud->callback_after_update(array($this, 'insertar_completo'));

                $output = $crud->render();

                $data['page_title'] = "Socios";
                $data['js_files'] = $output ->js_files; //Necesario para que se incluyan los js de grocery_CRUD en el header
                $data['css_files'] = $output->css_files; //Necesario para que se incluyan los css de grocery_CRUD en el header

                $this->load->view('templates/header', $data);   
                $this->load->view('socios/socios_view', $output);
                $this->load->view('templates/footer');

            }
            catch(Exception $e)
            {
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }
        }
        
        function insertar_completo($post_array, $primary_key)
        {
            $this->db->where('id', $primary_key);
            $query = $this->db->get('socios');
            if ($query->num_rows == 1)
            {
                foreach($query->result() as $row)
                {
                    $completo = $row->apellidos . ', ' . $row->nombre;
                }
                //$query->apellidos + ', ' + $query->nombre;
                $this->db->where('id', $primary_key);
                $this->db->update('socios', array(
                                                'completo' =>
                                                 $completo)
                                 );
            }
        }

        public function view($slug)
        {
            $data['result'] = $this->jugadores_model->getJugadores($slug);
        }

        public function create()
        {
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $data['title'] = 'Create jugador';
            
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('apellidos', 'Apellidos', 'required');
            $this->form_validation->set_rules('fecha_nacimiento', 'Fecha de Nacimiento', 'required');
            

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);   
                $this->load->view('jugadores/create');
                $this->load->view('templates/footer');
                
            }
            else
            {
                $this->jugadores_model->set_jugadores();
                $this->index();
            }
        } 
    }  
?>