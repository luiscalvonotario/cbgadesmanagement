<?php  
    class Jugadores extends CI_Controller
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
            
            $this->load->model('jugadores_model');

            $this->load->library('grocery_crud');
        }
        public function index()  
        {
            /* Mandamos lo que llegue a administración */
            redirect('jugadores/administracion');
        }

        /*
         *
         **/

        function administracion()
        {
            try{

                $crud = new grocery_CRUD();

                $crud->set_theme('datatables');

                $crud->set_table('jugadores');

                $crud->set_subject('Jugadores');

                $crud->set_language('spanish');

                $crud->required_fields(
                    'id',
                    'nombre',
                    'apellidos',
                    'edad',
                    'tarjeta_deportiva');

                $crud->columns(
                    'apellidos',
                    'nombre',
                    'dni',
                    'codigo_recibo',
                    'edad',
                    'equipo_comparte',
                    'tarjeta_deportiva',
                    'dorsal',
                    'certificado_medico',
                    'observaciones');

                $crud->fields(
                    'nombre',
                    'apellidos',
                    'edad',
                    'club_desde',
                    'completo',
                    'foto',
                    'tarjeta_deportiva',
                    'tutor',
                    'equipo_comparte',
                    'telefono1',
                    'telefono2',
                    'telefono3',
                    'codigo_recibo',
                    'certificado_medico',
                    'observaciones',
                    'dorsal',
                    'becado',
                    'permiso_foto',
                    'domicilio',
                    'correo_electronico1',
                    'correo_electronico2',
                    'correo_electronico3',
                    'dni',
                    'dni_foto',
                    'baja');

                $crud->change_field_type('completo', 'invisible');

                $crud->set_relation('tutor','socios','completo');
                $crud->set_relation_n_n('equipo_comparte', 'equipo_comparte', 'equipos', 'id_jugador', 'id_equipo', 'nombre');
                //$crud->set_relation_n_n('jugadores','socio_jugadores','jugadores','socio_id','jugador_id','completo');
                //$crud->set_relation('equipo_comparte','equipos','nombre');
                //$crud->unset_add_fields('completo');
                //$crud->unset_edit_fields('completo');
                $crud->set_field_upload('foto', 'assets/uploads/fotos');
                $crud->set_field_upload('dni_foto', 'assets/uploads/dni');

                $crud->callback_after_upload(array($this, 'resize_and_save'));
                
                $crud->callback_column('nombre',array($this, 'datos_jugador'));

                $crud->callback_after_insert(array($this, 'insertar_completo'));

                $crud->callback_after_update(array($this, 'insertar_completo'));


                $output = $crud->render();

                $data['page_title'] = "Jugadores";
                $data['js_files'] = $output ->js_files;
                $data['css_files'] = $output->css_files; 

                $this->load->view('templates/header', $data);   
                $this->load->view('jugadores/jugadores_view', $output);
                $this->load->view('templates/footer');

            }
            catch(Exception $e)
            {
                show_error($e->getMessage().' --- '.$e->getTraceAsString());
            }
        }
        
        /*
         ** Función para reajustar el tamaño de la imagen y de salvar la dirección en la base de datos una vez que se haya subido.
         */
        function resize_and_save($uploader_response, $field_info, $files_to_upload)
        {
            $this->load->library('image_moo');
            
            switch ($field_info->field_name)
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
                default:
                    return false;
                    break;
            }
        }

        /*
        ** Función para crear un link desde el nombre del jugador, hacia una página más específica del mismo y ver más datos completos. (fotos y demás)
        */
        function datos_jugador($value, $row)
        {
            return '<a href="'.site_url("jugador_datos/index/".$row->id).'">'.$value.'</a>';
        }

        /*
        ** Esta función se llama al insertar o actualizar una fila de jugadores.
        ** De forma que se inserta el campo completo en la tabla, para usarla después en otros formularios con el nombre completo del/a jugador/a.
        */
        function insertar_completo($post_array, $primary_key)
        {
            $this->db->where('id', $primary_key);
            $query = $this->db->get('jugadores');
            if ($query->num_rows == 1)
            {
                foreach($query->result() as $row)
                {
                    $completo = $row->apellidos . ', ' . $row->nombre;
                }
                //$query->apellidos + ', ' + $query->nombre;
                $this->db->where('id', $primary_key);
                $this->db->update('jugadores', array(
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