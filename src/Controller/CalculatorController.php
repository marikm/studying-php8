<?php
    
    namespace App\Controller;
    use App\Db\Db;
    use App\Model\CalculatorModel;

    class CalculatorController {
        public $db;
        public $model;
        public $calculadoraModel;
        public $data;

        public $nome;
        public $email;
        public $montante_inicial;
        public $aporte_mensal;
        public $juros_anual;
        public $acrescimo_anual;
        public $renda_passiva_desejada;
        public $tempo_para_renda_passiva;
        public $montante_final;
        public $valorAportado;
        public $anos;
        public $title;
        public $titleForm;

        public function __construct() {
            session_start();

            $this->db = new Db();
            if($_SERVER['REQUEST_METHOD'] == "POST") {
                // setar apenas as variaveis baseadas no metodo post na construcao do controller
                if(isset($_POST['nome'])) {
                    $this->nome = (string)$_POST['nome'];   
                    $_SESSION['nome'] = $_POST['nome'];
                }
                $this->email = (string)$_POST['email'];   
                $this->montante_inicial = (float)$_POST['montante_inicial'];
                $this->aporte_mensal = isset($_POST['aporte_mensal']) ? (float)$_POST['aporte_mensal'] : 0;
                $this->juros_anual = (float)$_POST['juros_anual'] / 100; // Convertendo para decimal
                $this->acrescimo_anual = isset($_POST['acrescimo_anual']) ? (float)$_POST['acrescimo_anual'] / 100 : 0;
                $this->renda_passiva_desejada = (float)$_POST['renda_passiva_desejada'];
                //chamar metodos para validar dados
                //try{} catch(Except $erro)

                
                
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

        public function index() {
            $this->title = "Calculadora";//pode ser definido no construtor
            $this->titleForm = "Calculadora de Renda Passiva Mensal";
            $this->tempo_para_renda_passiva = $this->calcular_tempo_ate_renda_passiva($this->montante_inicial, $this->aporte_mensal, $this->juros_anual, $this->acrescimo_anual, $this->renda_passiva_desejada)[0];
            $this->montante_final = $this->calcular_tempo_ate_renda_passiva($this->montante_inicial, $this->aporte_mensal, $this->juros_anual, $this->acrescimo_anual, $this->renda_passiva_desejada)[1];
            $this->valorAportado = ($this->aporte_mensal*12*$this->tempo_para_renda_passiva)+$this->montante_inicial;
            $this->data = [
                            'montanteInicial' => $this->montante_inicial,
                            'aporteMensal' => $this->aporte_mensal,
                            'jurosAnual' => $this->juros_anual*100,
                            'acrescimoAnual' => $this->acrescimo_anual,
                            'rendaPassiva' => $this->renda_passiva_desejada,
                            'tempoParaRenda' => $this->tempo_para_renda_passiva,
                            'montanteFinal' => $this->montante_final,
                            'valorAportado' => $this->valorAportado,
            ];

            //validando se POST está vazio
            if(isset($_POST) and !empty($_POST)) {
                // $this->db = new Db();
                $this->calculadoraModel = (new CalculatorModel())->insertCalculadoraResults($this->data, $this->db);
            }
            
            $this->data['title'] = $this->title;
            $this->data['titleForm'] = $this->titleForm;

            return $this->data;
        }



    }

    