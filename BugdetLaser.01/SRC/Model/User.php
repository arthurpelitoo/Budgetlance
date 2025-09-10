<?php

/**
 * Classe para gerenciar conexões e verificar estabilidade
 */
class User {
    private $conexao = [];
    private $connected = false;
    private $disconnected = false;
    private $tentativasConexao = 0;
    private $maxTentativas = 3;
    private $tempoUltimaConexao;
    private $statusConexao = 'desconectado'; // 'conectado', 'desconectado', 'instavel'

    /**
     * Construtor da classe User
     */
    public function __construct() {
        $this->tempoUltimaConexao = time();
    }

    /**
     * Estabelece uma conexão
     * 
     * @param array $dadosConexao Dados para conexão (host, usuario, senha, etc.)
     * @return bool True se conexão foi estabelecida
     */
    public function conectar($dadosConexao = []) {
        $this->tentativasConexao++;
        
        // Simula verificação de conexão (aqui você colocaria sua lógica real)
        if ($this->verificarConexao($dadosConexao)) {
            $this->connected = true;
            $this->disconnected = false;
            $this->statusConexao = 'conectado';
            $this->tempoUltimaConexao = time();
            $this->tentativasConexao = 0; // Reset contador em caso de sucesso
            
            echo "✅ Conexão estabelecida com sucesso!\n";
            return true;
        } else {
            $this->connected = false;
            $this->disconnected = true;
            $this->statusConexao = 'desconectado';
            
            echo "❌ Falha na conexão (tentativa {$this->tentativasConexao}/{$this->maxTentativas})\n";
            return false;
        }
    }

    /**
     * Verifica se a conexão é estável
     * 
     * @return bool True se conexão está estável
     */
    public function isConexaoEstavel() {
        // Comparador 1: Verifica se está conectado
        if (!$this->connected) {
            return false;
        }

        // Comparador 2: Verifica tempo desde última conexão
        $tempoAtual = time();
        $tempoDecorrido = $tempoAtual - $this->tempoUltimaConexao;
        
        // Se passou mais de 5 minutos, considera instável
        if ($tempoDecorrido > 300) { // 300 segundos = 5 minutos
            $this->statusConexao = 'instavel';
            return false;
        }

        // Comparador 3: Verifica número de tentativas
        if ($this->tentativasConexao >= $this->maxTentativas) {
            $this->statusConexao = 'instavel';
            return false;
        }

        return true;
    }

    /**
     * Comparador de status de conexão
     * 
     * @param string $statusEsperado Status esperado ('conectado', 'desconectado', 'instavel')
     * @return bool True se status atual é igual ao esperado
     */
    public function compararStatus($statusEsperado) {
        return $this->statusConexao === $statusEsperado;
    }

    /**
     * Verifica se conexão é diferente do status especificado
     * 
     * @param string $statusDiferente Status que deve ser diferente
     * @return bool True se status atual é diferente do especificado
     */
    public function isStatusDiferente($statusDiferente) {
        return $this->statusConexao !== $statusDiferente;
    }

    /**
     * Simula verificação de conexão (substitua pela sua lógica real)
     * 
     * @param array $dadosConexao
     * @return bool
     */
    private function verificarConexao($dadosConexao) {
        // Simula diferentes cenários de conexão
        $rand = rand(1, 10);
        
        // 70% de chance de sucesso
        return $rand <= 7;
    }

    /**
     * Desconecta do sistema
     */
    public function desconectar() {
        $this->connected = false;
        $this->disconnected = true;
        $this->statusConexao = 'desconectado';
        echo "🔌 Desconectado com sucesso!\n";
    }

    /**
     * Retorna o status atual da conexão
     * 
     * @return string
     */
    public function getStatusConexao() {
        return $this->statusConexao;
    }

    /**
     * Retorna informações detalhadas da conexão
     * 
     * @return array
     */
    public function getInfoConexao() {
        return [
            'status' => $this->statusConexao,
            'conectado' => $this->connected,
            'desconectado' => $this->disconnected,
            'tentativas' => $this->tentativasConexao,
            'max_tentativas' => $this->maxTentativas,
            'tempo_ultima_conexao' => date('Y-m-d H:i:s', $this->tempoUltimaConexao),
            'estavel' => $this->isConexaoEstavel()
        ];
    }

    /**
     * Testa a estabilidade da conexão
     */
    public function testarEstabilidade() {
        echo "🔍 Testando estabilidade da conexão...\n";
        
        if ($this->isConexaoEstavel()) {
            echo "✅ Conexão ESTÁVEL\n";
        } else {
            echo "⚠️ Conexão INSTÁVEL ou DESCONECTADA\n";
        }
        
        // Comparadores de exemplo
        if ($this->compararStatus('conectado')) {
            echo "✅ Status é igual a 'conectado'\n";
        }
        
        if ($this->isStatusDiferente('desconectado')) {
            echo "✅ Status é diferente de 'desconectado'\n";
        }
    }
}