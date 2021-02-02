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
            
            $this->model->insert($datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro agregado con exito");
            return $this->respond($mensaje);

        }else{
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


    }

    public function editarConductor($id){

        //1. Recibir los datos que llegan de la peticion
        $datosPeticion=$this->request->getRawInput();
        
        //2. Obtener SOLO los datos que deseo editar
        $nombre=$datosPeticion["nombre"];
        $telefono=$datosPeticion["telefono"];

        //3. Creamos un arreglo asociativo con los datos para enviar al modelo
        $datosEnvio=array(
            "nombre"=>$nombre,
            "telefono"=>$telefono
        );

        //4. Validamos y ejecutamos la operación en BD
        if($this->validate('conductoresPUT')){
            
            $this->model->update($id,$datosEnvio);
            $mensaje=array('estado'=>true,'mensaje'=>"registro editado con exito");
            return $this->respond($mensaje);

        }else{
            $validation =  \Config\Services::validation();
            return $this->respond($validation->getErrors(),400);

        }


        




    }

    public function eliminarConductor($id){

        //1. Ejecutar la operación de delete en BD
        $consulta=$this->model->where('idConductor',$id)->delete();
        $filasAfectadas=$consulta->connID->affected_rows;

        //2. Validar si el registro a eliminar existe o no
        if($filasAfectadas==1){

            $mensaje=array('estado'=>true,'mensaje'=>"registro eliminado con exito");
            return $this->respond($mensaje);

        }else{
            $mensaje=array('estado'=>false,'mensaje'=>"El conductor a eliminar no se encontro en BD");
            return $this->respond($mensaje,400);
        }
        

    }


}

