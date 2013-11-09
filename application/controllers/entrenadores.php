<?php  
    class Entrenadores extends CI_Controller
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
            redirect('entrenadores/administracion');
        }

        /*
         *
         **/

        function administracion()
        {
            try{

                $crud = new grocery_CRUD();

                $crud->set_theme('datatables');

                $crud->set_table('entrenadores');

                $crud->set_subject('Entrenadores');

                $crud->set_language('spanish');

                $crud->required_fields(
                    'id',
                    'nombre',
                    'apellidos',
                    'dni',
                    'curso',
                    'telefono1',
                    'domicilio');

                $crud->columns(
                    'apellidos',
                    'nombre',
                    'dni',
                    'cursos_realizados',
                    'n_tarjeta',
                    'telefono1');

                $crud->display_as('curso', 'Titulación');
                $crud->display_as('cursos_realizados', 'Titulaciones');

                $crud->set_field_upload('foto', 'assets/uploads/fotos');
                $crud->set_field_upload('dni_foto', 'assets/uploads/dni');
                $crud->set_field_upload('titulo_foto', 'assets/uploads/titulos');

                $crud->callback_after_upload(array($this, 'resize_and_save'));

                $output = $crud->render();

                $data['page_title'] = "Entrenadores";
                $data['js_files'] = $output ->js_files; //Necesario para que se incluyan los js de grocery_CRUD en el header
                $data['css_files'] = $output->css_files; //Necesario para que se incluyan los css de grocery_CRUD en el header

                $this->load->view('templates/header', $data);   
                $this->load->view('entrenadores/entrenadores_view', $output);
                $this->load->view('templates/footer');

            }
            catch(Exception $e)
            {
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }
        }
        

        function resize_and_save($uploader_response, $field_info, $files_to_upload)
        {
            $this->load->library('image_moo');
            
            switch ($field_into->field_name)
            {
                case 'foto':
                    $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 
 
                    $this->image_moo->load($file_uploaded)->resize(50,50)->save($file_uploaded,true);
                    return true;
                    break;
                case 'dni_foto':
                    $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 
 
                    $this->image_moo->load($file_uploaded)->resize(300,150)->save($file_uploaded,true);
                    return true;
                    break;
                case 'titulo_foto':
                    $file_uploaded = $field_info->upload_path.'/'.$uploader_response[0]->name; 
 
                    $this->image_moo->load($file_uploaded)->resize(300,150)->save($file_uploaded,true);
                    return true;
                    break;
                default:
                    return false;
                    break;
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