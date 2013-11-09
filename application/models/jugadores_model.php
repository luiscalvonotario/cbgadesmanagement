<?php  
class Jugadores_model extends CI_Model {  
    
    public function __construct()  
    {  
        // Call the Model constructor  
        $this->load->database();
    }
      
    public function getJugadores()  
    {  
        //Query the data table for every record and row
        //$query = $this->db->query("SHOW TABLES LIKE contacts"); 

        $query = $this->db->get('jugadores');  
        if ($query->num_rows() > 0)  
        {  
            return $query->result_array();  
        }
        else
        {  
            show_error('Database is empty!');  
        }  
    }

    public function set_jugadores()
    {
        $this->load->helper('url');
        
        //$slug = url_title($this->input->post('title'), 'dash', TRUE);
        
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'apellidos' => $this->input->post('apellidos'),
            'edad' => $this->input->post('fecha_nacimiento'),
            'club_desde' => $this->input->post('fecha_entrada')
        );
        
        return $this->db->insert('jugadores', $data);
    }  
}  
?>  