<?php
use App\Model\PersonaModel;

$app->group('/persona/', function () {

    $this->post('login/', function ($req, $res) {
        $um = new PersonaModel();

        return $res           
            ->getBody()
            ->write(
                json_encode(
                    $um->login(
                        $req->getParsedBody()
                    )
                    , JSON_UNESCAPED_UNICODE)
            );
    });
});
