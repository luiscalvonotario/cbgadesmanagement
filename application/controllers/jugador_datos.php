<?php  
    class Jugador_datos extends CI_Controller
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
            
            //$this->load->model('Jugador_datos_model');

            //$this->load->library('grocery_crud');
        }

        public function index($iden)  
        {
            $this->db->where('id', $iden);
            $query = $this->db->get('jugadores');

            if ($query->num_rows == 1)
            {
                foreach($query->result() as $row)
                {
                    $data['page_title'] = $row->nombre . ' ' . $row->apellidos;
                    $output['nombre'] = $row->nombre;
                    $output['apellidos'] = $row->apellidos;
                    $output['edad'] = $row->edad;
                    $output['club_desde'] = $row->club_desde;
                    $output['completo'] = $row->completo;
                    $output['foto'] = $row->foto;
                    $output['tarjeta_deportiva'] = $row->tarjeta_deportiva;
                    $output['telefono1'] = $row->telefono1;
                    $output['telefono2'] = $row->telefono2;
                    $output['telefono3'] = $row->telefono3;
                    $output['correo_electronico1'] = $row->correo_electronico1;
                    $output['correo_electronico2'] = $row->correo_electronico2;
                    $output['correo_electronico3'] = $row->correo_electronico3;
                    $output['codigo_recibo'] = $row->codigo_recibo;
                    $output['certificado_medico'] = $row->certificado_medico;
                    $output['observaciones'] = $row->observaciones;
                    $output['dorsal'] = $row->dorsal;
                    $output['becado'] = $row->becado;
                    $output['permiso_foto'] = $row->permiso_foto;
                    $output['domicilio'] = $row->domicilio;
                    $output['colegio'] = $row->colegio;
                    $output['dni'] = $row->dni;
                    $output['dni_foto'] = $row->dni_foto;
                    $output['baja'] = $row->baja;

                    if (is_null($row->tutor))
                    {
                        $output['socio'] = "Socio no definido"; 
                    }
                    else
                    {
                        $this->db->where('id', $row->tutor);
                        $query = $this->db->get('socios');
                        if($query->num_rows == 1)
                        {
                            foreach($query->result() as $row2)
                            {
                                $output['socio'] = $row2->completo;
                            }
                        }
                    }

                    $this->db->where('id_jugador', $row->id);
                    $query = $this->db->get('equipo_comparte');
                    if($query->num_rows > 0)
                    {
                        foreach($query->result() as $row3)
                        {
                            $equipoid = $row3->id_equipo;

                            $this->db->where('id', $equipoid);
                            $query = $this->db->get('equipos');
                            if($query->num_rows > 0)
                            {
                                foreach($query->result() as $row4)
                                {
                                    $output['equipo'] = $row4->nombre;
                                }
                            
                            }
                        }
                    }              
                }

                $this->load->view('templates/headerSimple', $data);   
                $this->load->view('Jugador_datos/show', $output);
                $this->load->view('templates/footer');
            }

                       
            /* Mandamos lo que llegue a administración */
            //redirect('Jugador_datos/administracion');
        }

        /*
         *
         **/
        public function view($slug)
        {
            $data['result'] = $this->Jugador_datos_model->getJugadordatos($slug);
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
                $this->load->view('Jugador_datos/create');
                $this->load->view('templates/footer');
                
            }
            else
            {
                $this->Jugador_datos_model->set_Jugador_datos();
                $this->index();
            }
        } 
    }  
?>