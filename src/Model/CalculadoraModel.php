<?php
    namespace App\Model;

use App\Controller\CalculadoraController;
use App\Db\Db;

    class CalculadoraModel {

        protected $db;
        public function __construct()
        {
            $this->db = new Db();
        
        }

        public function insertCalculadoraResults(array $data) {
            $results = "";
            foreach ($data as $coluna => $valor){
               
                if($coluna != 'title' && $coluna != 'titleForm' && $coluna != 'montanteFinal') {
                    $results .= $valor . ",";
                    
                }
                if($coluna == 'montanteFinal') {
                    $results .= $valor;
                }
                
            }
            var_dump($results);
            
            $teste = $this->db->insert('montanteInicial, aporteMensal, jurosAnual, acrescimoAnual, rendaPassiva, tempoParaRenda, montanteFinal, valorAportado', $results ,"calculadora");
           
        }
    }
