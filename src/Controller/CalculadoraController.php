<?php

    namespace App\Controller;
    use App\Model\CalculadoraModel;

    class CalculadoraController {

        public $data;
        public $montante_inicial;
        public $aporte_mensal;
        public $juros_anual;
        public $acrescimo_anual;
        public $renda_passiva_desejada;
        public $tempo_para_renda_passiva;
        public $montante_final;
        public $valorAportado;
        public $anos;

        public function __construct() {
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                $this->montante_inicial = (float)$_POST['montante_inicial'];
                $this->aporte_mensal = isset($_POST['aporte_mensal']) ? (float)$_POST['aporte_mensal'] : 0;
                $this->juros_anual = (float)$_POST['juros_anual'] / 100; // Convertendo para decimal
                $this->acrescimo_anual = isset($_POST['acrescimo_anual']) ? (float)$_POST['acrescimo_anual'] / 100 : 0;
                $this->renda_passiva_desejada = (float)$_POST['renda_passiva_desejada'];
                $this->tempo_para_renda_passiva = $this->calcular_tempo_ate_renda_passiva($this->montante_inicial, $this->aporte_mensal, $this->juros_anual, $this->acrescimo_anual, $this->renda_passiva_desejada)[0];
                $this->montante_final = $this->calcular_tempo_ate_renda_passiva($this->montante_inicial, $this->aporte_mensal, $this->juros_anual, $this->acrescimo_anual, $this->renda_passiva_desejada)[1];
                $this->valorAportado = ($this->aporte_mensal*12*$this->tempo_para_renda_passiva)+$this->montante_inicial;
                $this->data = [
                    'title' => "Calculadora",
                    'titleForm' => "Calculadora de Renda Passiva Mensal",
                    'montanteInicial' => $this->montante_inicial,
                    'aporte' => $this->aporte_mensal,
                    'juros' => $this->juros_anual*100,
                    'acrescimo' => $this->acrescimo_anual,
                    'valorAportado' => $this->valorAportado,
                    'rendaMensal' => $this->renda_passiva_desejada,
                    'anos' => $this->tempo_para_renda_passiva,
                    'montanteFinal' => $this->montante_final,
                    
                ];

                

                $this->saveToBd($this->data);die;
            }
        }

        public function calcular_tempo_ate_renda_passiva($montante_inicial, $aporte_mensal, $juros_anual, $acrescimo_anual, $renda_passiva_desejada): array {
            $montante = $montante_inicial;
            $anos = 0;
    
            while (true) {
                $montante += $aporte_mensal * 12; // Aporte anual
                $montante *= (1 + $juros_anual); // Aplicação do juros anual
                $aporte_mensal *= (1 + $acrescimo_anual); // Ajuste do aporte mensal com acréscimo anual
                $anos++;
                $renda_passiva_mensal = $montante * ($juros_anual / 12); // Calcula a renda passiva mensal
                if ($renda_passiva_mensal >= $renda_passiva_desejada) {
                    break;
                }
            }
    
            return array($anos, $montante);
        }

        public function saveToBd(array $results) {
            $model = new CalculadoraModel();
            $model->insertCalculadoraResults($results);
        }


        public function index() {
            return $this->data;
        }



    }

    