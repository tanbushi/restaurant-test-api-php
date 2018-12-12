<?php
use App\Model\OrdenModel;

$app->group('/orden/', function () {

    $this->get('', function ($req, $res, $args) {
        $um = new OrdenModel();

        $res->write(
            json_encode($um->getOrdenes(), JSON_UNESCAPED_UNICODE)
        );

        return $res;
    });

    $this->get('mesas/', function ($req, $res, $args) {
        $um = new OrdenModel();

        $res->write(
            json_encode($um->getMesas(), JSON_UNESCAPED_UNICODE)
        );

        return $res;
    });

    $this->get('ordenes_cocina/', function ($req, $res, $args) {
        $um = new OrdenModel();

        $res->write(
            json_encode($um->getOrdenesCocina(), JSON_UNESCAPED_UNICODE)
        );

        return $res;
    });

    $this->get('productos/', function ($req, $res, $args) {
        $um = new OrdenModel();

        $res->write(
            json_encode($um->getProductos(), JSON_UNESCAPED_UNICODE)
        );

        return $res;
    });

    $this->post('', function ($req, $res) {
        $um = new OrdenModel();

        return $res
            ->getBody()
            ->write(
                json_encode(
                    $um->insert(
                        $req->getParsedBody()
                    )
                    , JSON_UNESCAPED_UNICODE)
            );
    });

    $this->post('producto/', function ($req, $res) {
        $um = new OrdenModel();

        return $res
            ->getBody()
            ->write(
                json_encode(
                    $um->insertProducto(
                        $req->getParsedBody()
                    )
                    , JSON_UNESCAPED_UNICODE)
            );
    });
});
