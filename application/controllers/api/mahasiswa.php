<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class mahasiswa extends REST_Controller 
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->load->model('Mahasiswa_model','mahasiswa')    ;
    }

    public function index_get() 
    { 
        $id = $this->get('id');
        if($id==null)
        {
            $mahasiswa = $this->mahasiswa->getMahasiswa();
        }
        else
        {
            $mahasiswa = $this->mahasiswa->getMahasiswa($id);
        }
        
        if($mahasiswa)
        {
            $this->response(
                [
                    'status'=>true,
                    'data'=>$mahasiswa
                ], REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response(
            [
                'status' => false,
                'message'=>'id not found'
            ],REST_Controller::HTTP_NOT_FOUND);
        }
        

    }


    public function index_delete()
    {
        $id = $this->delete('id');
        if($id===null)
        {
            $this->response(
                [
                    'status' => false,
                    'message'=>'Provide an ID!'
                ],REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            if($this->mahasiswa->deleteMahasiswa($id)>0)
            {
                $this->response(
                    [
                        'status'=>true,
                        'id' =>$id,
                        'message'=>'data berhasil dihapus'
                    ], REST_Controller::HTTP_NO_CONTENT);
            }
            else
            {
                $this->response(
                    [
                        'status'=>true,
                        'message'=>'id not found'
                    ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {
        $data = 
        [
            'nrp'=> $this->post('nrp'),
            'nama'=> $this->post('nama'),
            'email'=> $this->post('email'),
            'jurusan'=> $this->post('jurusan')

        ];

        if($this->mahasiswa->createMahasiswa($data)>0)
        {
            $this->response(
                [
                    'status' => true,
                    'message' => 'new mahasiswa has been created'
                ],REST_Controller::HTTP_CREATED);
        }
        else
        {
            $this->response(
                [
                    'status' => false,
                    'message' => 'failed create new data'
                ],REST_Controller::HTTP_BAD_REQUEST);   
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = 
        [
            'nrp'=> $this->put('nrp'),
            'nama'=> $this->put('nama'),
            'email'=> $this->put('email'),
            'jurusan'=> $this->put('jurusan')

        ];
        if($this->mahasiswa->updateMahasiswa($data,$id)>0)
        {
            $this->response(
                [
                    'status' => true,
                    'id'=>$id,
                    'message' => 'data has been updated'
                ],REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response(
                [
                    'status' => false,
                    'message' => 'failed update data'
                ],REST_Controller::HTTP_BAD_REQUEST);   
        }
    }
}