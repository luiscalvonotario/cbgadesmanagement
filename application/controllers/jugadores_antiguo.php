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

            $this->
        }
        public function index()  
        {
            $this->load->library('table');  
            $data['result'] = $this->jugadores_model->getJugadores();  
            $data['page_title'] = "JUGADORES";  
            
            $header = array('ID', 'Nombre', 'Apellidos', 'Fecha de nacimiento', 'Club desde', 'Ver', 'Modificar', 'Eliminar');
            $this->table->set_heading($header);

            if(is_array($result))
            {
                foreach($result as $row)
                {
                    $this->table->add_row(
                                            $row->id, 
                                            $row->nombre, 
                                            $row->apellidos, 
                                            $row->edad, 
                                            $row->club_desde, 
                                            anchor(
                                                    'jugadores/jugador_view/'.$row->id, 
                                                    img(
                                                        'src'=>'images/ver'
                                                        'alt'=>'Ver'
                                                        ),
                                                    'title' => 'Ver'
                                                  ),
                                            anchor(
                                                    'jugadores/jugador_modificar/'.$row->id, 
                                                    img(
                                                        'src'=>'images/modificar'
                                                        'alt'=>'Modificar'
                                                        ),
                                                    'title' => 'Modificar'
                                                  ),
                                            anchor(
                                                    'jugadores/jugador_eliminar/'.$row->id, 
                                                    img(
                                                        'src'=>'images/eliminar'
                                                        'alt'=>'Eliminar'
                                                        ),
                                                    'title' => 'Eliminar'
                                                  ),
                                         )

                }
            }
        
            $this->load->view('templates/header', $data);   
            $this->load->view('jugadores/jugadores_view',$data);  
            $this->load->view('templates/footer');
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