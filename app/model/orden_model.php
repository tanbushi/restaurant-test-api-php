<?php
namespace App\Model;

use App\Lib\Database;
use App\Lib\Response;

class OrdenModel
{
    private $db;
    private $table = 'ordenes';
    private $response;

    public function __CONSTRUCT()
    {
        $this->db       = Database::StartUp();
        $this->response = new Response();
    }

    public function getOrdenes()
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT o.fecha, o.total, CONCAT(p.nombre, ' ',p.apellido) empleado, m.nombre mesa FROM ordenes o, personas p, mesas m WHERE o.id_persona = p.id_persona AND o.id_mesa = m.id_mesa ORDER BY o.fecha DESC");
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }

    public function getMesas()
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT * FROM mesas");
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }

    public function getProductos()
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT * FROM productos");
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }

    public function getOrdenesCocina()
    {
        try
        {
            $result = array();

            $stm = $this->db->prepare("SELECT od.id_orden, me.nombre mesa, pr.nombre producto, po.cantidad FROM ordenes od, mesas me, productos_ordenes po, productos pr WHERE od.id_orden = po.id_orden AND od.id_mesa = me.id_mesa AND po.id_producto = pr.id_producto ORDER BY od.id_orden DESC");
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }

    public function insert($data)
    {

        $id_persona = $data['id_persona'];
        $id_mesa    = $data['id_mesa'];
        $fecha      = $data['fecha'];
        $total      = $data['total'];

        $query = "INSERT INTO $this->table (id_persona, id_mesa, fecha, total) VALUES (:id_persona, :id_mesa, :fecha, :total)";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->bindParam("id_persona", $id_persona);
            $stmt->bindParam("id_mesa", $id_mesa);
            $stmt->bindParam("fecha", $fecha);
            $stmt->bindParam("total", $total);
            $stmt->execute();

            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE fecha = ?");
            $stm->execute(array($fecha));

            $this->response->setResponse(true, 'Successfully Insertion');
            $this->response->result = $stm->fetch();
        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }

    public function insertProducto($data)
    {

        $id_orden    = $data['id_orden'];
        $id_producto = $data['id_producto'];
        $cantidad    = $data['cantidad'];

        $query = "INSERT INTO productos_ordenes (id_orden, id_producto, cantidad) VALUES (:id_orden, :id_producto, :cantidad)";

        try {

            $stmt = $this->db->prepare($query);
            $stmt->bindParam("id_orden", $id_orden);
            $stmt->bindParam("id_producto", $id_producto);
            $stmt->bindParam("cantidad", $cantidad);
            $stmt->execute();

            $this->response->setResponse(true, 'Successfully Insertion');
            $this->response->result = "";
        } catch (\Exception $e) {
            $this->response->result = false;
            $this->response->setResponse(false, $e->getMessage());
        }
        return $this->response;
    }
}
