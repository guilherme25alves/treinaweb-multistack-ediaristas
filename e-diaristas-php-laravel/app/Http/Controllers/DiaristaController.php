<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaristaRequest;
use App\Models\Diarista;
use Illuminate\Http\Request;
use App\Services\ViaCEP;

class DiaristaController extends Controller
{
    // Foma de injetar a partir do PHP 8
    //public function __construct(protected ViaCEP $viaCEP)
    //{}

    // PHP 7
    protected ViaCEP $viaCEP;

    public function __construct(ViaCEP $viaCEP) 
    {
        $this->viaCEP = $viaCEP;
    }

    /**
     *  Lista as Diaristas
     * 
     *  @return void
     */
    public function index()
    {
        $diaristas = Diarista::get();

        return view('index', [
            'diaristas' => $diaristas
        ]);
    }

    /**
     *  Exibe formulário de cadastro
     * 
     *  @return void
     */
    public function create()
    {
        return view('create');
    }

    /**
     *  Insere uma nova Diarista no banco de dados
     * 
     *  @param Request $request
     *  @return void
     */
    public function store(DiaristaRequest $request)
    {
        $dados = $request->except('_token'); // pegar todos os dados, menos o _token
        $dados['foto_usuario'] = $request->foto_usuario->store('public'); // salvando img na pasta public
        
        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', '-', ' '], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCEP->buscar( $dados['cep'])['ibge'];

        Diarista::create($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     *  Exibe o formulário de edição populado
     * 
     *  @param integer $id
     *  @return void
     */
    public function edit(int $id) 
    {
        $diarista = Diarista::findOrFail($id);

        return view('edit', [
            'diarista' => $diarista
        ]);
    }

    /**
     *  Atualiza informações de uma Diarista no banco de dados
     * 
     *  @param integer $id
     *  @param Request $request
     *  @return void
     */
    public function update(int $id, DiaristaRequest $request) 
    {
        $diarista = Diarista::findOrFail($id);

        $dados = $request->except('_token', '_method'); // _method : usado p/ Laravel saber que o form é PUT

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', '-', ' '], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCEP->buscar( $dados['cep'])['ibge'];

         if ($request->hasFile('foto_usuario')) {
              $dados['foto_usuario'] = $request->foto_usuario->store('public');
         }

         $diarista->update($dados);

         return redirect()->route('diaristas.index');
    }

    /**
     *  Deleta uma Diarista do banco de dados
     * 
     *  @param integer $id
     *  @return void
     */
    public function destroy(int $id)
    {
        $diarista = Diarista::findOrFail($id);

        $diarista->delete();

        return redirect()->route('diaristas.index');
    }
}
