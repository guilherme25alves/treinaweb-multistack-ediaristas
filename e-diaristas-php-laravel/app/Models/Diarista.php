<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diarista extends Model
{
    use HasFactory;

    /**
     *  Defini os campos que podem ser persistidos em banco de dados
     *  @var array
     */
    protected $fillable = ['nome_completo', 'cpf', 'email', 'telefone', 'logradouro',
    'numero','complemento','bairro', 'cidade', 'estado', 'cep', 'codigo_ibge', 'foto_usuario'];

    /**
     *  Defini os campos que serão Serializados no json
     *  @var array
     */
    protected $visible = ['nome_completo', 'cidade', 'foto_usuario', 'reputacao'];

    /**
     *  Adiciona campos virtuais na Serialização
     *  @var array
     */
    protected $appends = ['reputacao'];

    /**
     *  Monta a URL completa da imagem
     *  @param string $valor
     *  @return void
     */
    public function getFotoUsuarioAttribute(string $valor)
    {
        return config('app.url') . '/' . $valor;
    }

    /**
     *  Retorna a reputação de forma randômica
     *  @param string $valor
     *  @return void
     */
    public function getReputacaoAttribute($valor)
    {
        return mt_rand(1, 5); // mt_rand : gerando valor aleatório (nativa PHP) 
    }

    /**
     * Busca Diaristas pelo código IBGE
     * 
     * @param integer $codigoIbge
     * @return void
     */
    static public function buscaPorCodigoIbge(int $codigoIbge) 
    {
        return self::where('codigo_ibge', $codigoIbge) // self se refere a classe Diarista, como se fosse o this do Java
            ->limit(6)->get();
    }

    /**
     * Retorna a quantidade de Diaristas pelo código IBGE
     * 
     * @param integer $codigoIbge
     * @return void
     */
    static function quantidadePorCodigoIbge(int $codigoIbge) 
    {
        $quantidade = self::where('codigo_ibge', $codigoIbge)->count();

        return $quantidade > 6 ? $quantidade - 6 : 0;
    }
}
