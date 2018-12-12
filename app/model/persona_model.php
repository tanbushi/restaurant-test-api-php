<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class PersonaModel
{
    private $db;
    private $table = 'personas';
    private $response;

    public function __CONSTRUCT()
    {
        $this->db       = Database::StartUp();
        $this->response = new Response();
    }

    public function login($data)
    {
        $correo     = $data['correo'];
        $contrasena = $data['contrasena'];

        try {

            $result = array();

            $stm = $this->db->prepare("SELECT COUNT(id_persona) AS result, nombre, apellido, id_persona FROM $this->table WHERE correo = ? AND contrasena = ?");
            $stm->execute(array($correo, $contrasena));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();

        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }
}
