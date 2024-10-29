<?php 

class Clientes implements JsonSerializable {
    public $id;
    public $nome;
    public $endereco;
    public $cpf;
    public $telefone;
    public $email;
    public $dataNascimento;

    function __construct($id_informado, $nome_informado, $endereco_informado, $cpf_informado, $telefone_informado, $email_informado, $dataNascimento_informada) {
        $this->id = $id_informado;
        $this->nome = $nome_informado;
        $this->endereco = $endereco_informado;
        $this->cpf = $cpf_informado;
        $this->telefone = $telefone_informado;
        $this->email = $email_informado;
        $this->dataNascimento = $dataNascimento_informada;
    }

    // Método para definir como o objeto deve ser convertido para JSON
    public function jsonSerialize() {
        return [
            'ID' => $this->id,
            'Nome' => $this->nome,
            'Endereco' => $this->endereco,
            'CPF' => $this->cpf,
            'Telefone' => $this->telefone,
            'Email' => $this->email,
            'DataNascimento' => $this->dataNascimento,
        ];
    }
}
?>
