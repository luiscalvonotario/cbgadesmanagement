<?php  
    class Inventario extends CI_Controller
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
            
            //$this->load->model('jugadores_model');

            $this->load->library('grocery_crud');
        }
        public function index()  
        {
            /* Mandamos lo que llegue a administración */
            redirect('inventario/administracion');
        }

        /*
         *
         **/

        function administracion()
        {
            try{

                $crud = new grocery_CRUD();

                $crud->set_theme('datatables');

                $crud->set_table('inventario');

                $crud->set_subject('Inventario');

                $crud->set_language('spanish');

                $crud->required_fields(
                    'item',
                    'cantidad');

                $crud->columns(
                    'item',
                    'talla',
                    'cantidad',
                    'descripcion',
                    'precio');

                //$crud->fields();

                // $crud->change_field_type('completo', 'invisible');

                // $crud->set_relation('tutor','socios','completo');
                // //$crud->unset_add_fields('completo');
                // //$crud->unset_edit_fields('completo');
                // $crud->set_field_upload('foto', 'assets/uploads/fotos');
                
                // $crud->callback_after_upload(array($this, 'resize_and_save'));
                
                // $crud->callback_column('nombre',array($this, 'datos_jugador'));

                // $crud->callback_after_insert(array($this, 'insertar_completo'));

                // $crud->callback_after_update(array($this, 'insertar_completo'));


                $output = $crud->render();

                $data['page_title'] = "Inventario";
                $data['js_files'] = $output ->js_files;
                $data['css_files'] = $output->css_files; 

                $this->load->view('templates/header', $data);   
                $this->load->view('inventario/inventario_view', $output);
                $this->load->view('templates/footer');

            }
            catch(Exception $e)
            {
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }
        }
        
        /*
        ** Función para crear un link desde el nombre del jugador, hacia una página más específica del mismo y ver más datos completos. (fotos y demás)
        */
        function datos_jugador($value, $row)
        {
            return '<a href="'.site_url("jugador_datos/index/".$row->id).'">'.$value.'</a>';
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