<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController{
    protected $modelName = 'App\Models\ConductorModelo';
    protected $format    = 'json';

    public function index(){
        
        return $this->respond($this->model->findAll());
    }

    
    public function registrarConductor(){

        //1.Recibir los datos del conductor desde el cliente
        $idConductor=$this->request->getPost('idConductor');
        $nombre=$this->request->getPost('nombre');
        $telefono=$this->request->getPost('telefono');
        $idContrato=$this->request->getPost('idContrato');

        //2. Armar un arreglos asociativo donde las claves
        //seran los nombres de las columnas o atributos de la tabla con los datos que llegan de la peticion

        $datosEnvio=array(
            "idConductor"=>$idConductor,
            "nombre"=>$nombre,
            "telefono"=>$telefono,
            "idContrato"=>$idContrato
        );

        //3. Ejecutamos validacion y agregamos el registro
        if($this->validate('conductores')){

            return $this->respond($datosEnvio);

        }else{

            return $this->respond("error");

        }


        


    }


}

