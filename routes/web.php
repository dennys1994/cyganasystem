<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\Margem\MargemController;
use App\Http\Controllers\Modulos\RelatorioFechamentoController;
use App\Http\Controllers\Modulos\BandeiraController;
use App\Http\Controllers\Modulos\AlmoxarifadoController;
use App\Http\Controllers\Modulos\ShoppingListController;

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckModuleAccess;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); 

    // Exibir o formulário de criação de um novo tipo de usuário
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');

    // Processar o envio do formulário para armazenar o novo tipo de usuário
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');

    Route::middleware([AdminMiddleware::class])->group(function () {
        // Rota para exibir o formulário de criação de usuários
        Route::get('create-user', [UserController::class, 'create'])->name('user.create');
    
        // Rota para processar o formulário de criação de usuários
        Route::post('create-user', [UserController::class, 'store'])->name('user.store');

        Route::get('modulos/create', [ModuloController::class, 'create'])->name('modulos.create');
        Route::post('modulos', [ModuloController::class, 'store'])->name('modulos.store');
        Route::get('modulos/assign', [ModuloController::class, 'assign'])->name('modulos.assign');
        Route::post('modulos/assign', [ModuloController::class, 'storeAssignment'])->name('modulos.storeAssignment');

        //Rota Relatorio de fechamento        
        Route::prefix('relatorio-fechamento')->group(function () {
            //Rota com as funcoes principais do relatorio 
            Route::get('/relatorio-fechamento', function () {
                return view('Modulos.Financeiro.RelatorioFechamento.index');
            })->name('relatorio');

            //Cadastro, edicao e listagem das credenciais 
            Route::post('/usuarios', [RelatorioFechamentoController::class, 'storeUser'])->name('relatorio.create.user'); // Criar usuário
            Route::get('/usuarios', [RelatorioFechamentoController::class, 'listUsers'])->name('relatorio.users.list'); // Listar usuários    

             // Rota para exibir o formulário de edição de um usuário
            Route::get('/usuarios/{id}/edit', [RelatorioFechamentoController::class, 'editUser'])->name('relatorio.users.edit');
            
            // Rota para atualizar um usuário no banco de dados
            Route::put('/usuarios/{id}', [RelatorioFechamentoController::class, 'updateUser'])->name('relatorio.users.update');
            
            // Rota para excluir um usuário
            Route::delete('/usuarios/{id}', [RelatorioFechamentoController::class, 'deleteUser'])->name('relatorio.users.destroy');


            Route::get('/usuarios-index', function () {
                return view('Modulos.Financeiro.RelatorioFechamento.Users.index');
            })->name('relatorio.users.index');

            Route::get('/usuarios-store', function () {
                return view('Modulos.Financeiro.RelatorioFechamento.Users.store');
            })->name('relatorio.users.store');            

            //funções da geração do relatorio
            Route::get('/relatorio', function () {
                return view('Modulos.Financeiro.RelatorioFechamento.Relatorio.index');
            })->name('relatorio.index'); 

            //listar clientes
            Route::get('/clientes', [RelatorioFechamentoController::class, 'getClientes'])->name('relatorio.clientes');
            //listar ordens de serviço
            Route::get('ordens-servico/{cliente_id}/{cnpj}', [RelatorioFechamentoController::class, 'listarOrdensServico'])->name('ordens-servico');
            //gerar pdf relatorio
            Route::post('/relatorio/pdf', [RelatorioFechamentoController::class, 'gerarRelatorioPdf'])->name('relatorio.pdf');

            Route::post('/limpar-cache', [RelatorioFechamentoController::class, 'limparCache'])->name('limpar.cache');

            Route::post('/ordem/acao', [RelatorioFechamentoController::class, 'acao'])->name('ordem.acao');
        });
        
    
    });

    Route::get('/financeiro', function () {
        return view('Modulos.Financeiro.index');
    })->name('financeiro.index');

    //Modulos
    Route::middleware([CheckModuleAccess::class . ':Margem'])->group(function () {
        Route::prefix('margem')->name('margem.')->group(function () {

            // Rota para exibir o painel geral de funções dentro do módulo "Margem"
            Route::get('index', [MargemController::class, 'index'])->name('index');

            // Rota para exibir o formulário de criação de categoria
            Route::get('create-categoria', [MargemController::class, 'createCategoria'])->name('create_categoria');
            // Rota para armazenar a categoria criada
            Route::post('store-categoria', [MargemController::class, 'storeCategoria'])->name('store_categoria');
            // Rota para editar categoria
            Route::get('categorias/{id}/editar', [MargemController::class, 'edit'])->name('categorias.editar');
            // Rota para atualizar categoria
            Route::post('categorias/{id}/atualizar', [MargemController::class, 'update'])->name('categorias.atualizar');
            Route::get('/categorias', [MargemController::class, 'index_categorias'])->name('categorias.index');


            // Rota para exibir o formulário de criação de faixas de preço
            Route::get('create-faixa', [MargemController::class, 'createFaixa'])->name('create_faixa');
            // Rota para armazenar a faixa de preço criada
            Route::post('store-faixa', [MargemController::class, 'storeFaixa'])->name('store_faixa');
            Route::get('/faixas', [MargemController::class, 'faixas_index'])->name('faixas.index');
            Route::get('/faixas/{id}/editar', [MargemController::class, 'faixas_edit'])->name('faixas.editar');
            Route::post('/faixas/{id}/atualizar', [MargemController::class, 'faixas_update'])->name('faixas.atualizar');


            // Rota para calcular o preço baseado na faixa e na margem
            Route::post('calcular-preco', [MargemController::class, 'calcularPreco'])->name('calcular_preco');
            // Rota para exibir a view de cálculo de preço
            Route::get('calcular-preco', [MargemController::class, 'showCalcularPreco'])->name('calcular_preco_view');
        });
    });


    //Rota Relatorio de fechamento        
    Route::middleware([CheckModuleAccess::class . ':CalculadoraBandeira'])->group(function () {
        Route::prefix('calculadorabandeiras')->group(function () {
            Route::resource('bandeiras', BandeiraController::class);
            Route::post('taxas', [BandeiraController::class, 'store_taxa'])->name('taxas.store');
            Route::delete('taxas/{id}', [BandeiraController::class, 'destroy_taxa'])->name('taxas.destroy');
            Route::get('/funcoes', function () {
                return view('Modulos.Financeiro.CalculadoraMaquininha.functions');
            })->name('calculadora.funcoes');
            Route::get('taxas/{id}/edit', [BandeiraController::class, 'edit_taxa'])->name('taxas.edit');
            Route::put('taxas/{id}', [BandeiraController::class, 'update_taxa'])->name('taxas.update');
            Route::get('calculadora', [BandeiraController::class, 'showCalculadora'])->name('calculadora.show');
            Route::post('calculadora/calcular', [BandeiraController::class, 'calcularTaxas'])->name('calculadora.calcular');
        });
    });

    //Rota Aplicativo        
    Route::middleware([CheckModuleAccess::class . ':AplicativoLotusSquad'])->group(function () {
        Route::prefix('Aplicativo')->group(function () {
            Route::get('/funcoes', function () {
                return view('Modulos.Aplicativo.index');
            })->name('aplicativo.index');        
        });
    });

    //Rota Almoxarifado        
    Route::middleware([CheckModuleAccess::class . ':Almoxarifado'])->group(function () {
        Route::prefix('Almoxarifado')->group(function () {
            Route::get('/funcoes', function () {
                return view('Modulos.Almoxarifado.functions');
            })->name('almoxarifado.functions');                
        });
        
        //Setor
        Route::get('/setores', [AlmoxarifadoController::class, 'index_setor'])->name('setores.index');
        Route::get('/setores/create', [AlmoxarifadoController::class, 'create_setor'])->name('setores.create');
        Route::post('/setores', [AlmoxarifadoController::class, 'store_setor'])->name('setores.store');
        Route::get('/setores/{setor}/edit', [AlmoxarifadoController::class, 'edit_setor'])->name('setores.edit');
        Route::put('/setores/{setor}', [AlmoxarifadoController::class, 'update_setor'])->name('setores.update');
        Route::delete('/setores/{setor}', [AlmoxarifadoController::class, 'destroy_setor'])->name('setores.destroy');
        //End Setor

        //Função
        Route::get('/funcao', [AlmoxarifadoController::class, 'index_funcao'])->name('funcao.index');
        Route::get('/funcao/create', [AlmoxarifadoController::class, 'create_funcao'])->name('funcao.create');
        Route::post('/funcao', [AlmoxarifadoController::class, 'store_funcao'])->name('funcao.store');
        Route::get('/funcao/{funcao}/edit', [AlmoxarifadoController::class, 'edit_funcao'])->name('funcao.edit');
        Route::put('/funcao/{funcao}', [AlmoxarifadoController::class, 'update_funcao'])->name('funcao.update');
        Route::delete('/funcao/{funcao}', [AlmoxarifadoController::class, 'destroy_funcao'])->name('funcao.destroy');
        //End Função

        //Tamanho
        Route::get('/tamanho', [AlmoxarifadoController::class, 'index_tamanho'])->name('tamanho.index');
        Route::get('/tamanho/create', [AlmoxarifadoController::class, 'create_tamanho'])->name('tamanho.create');
        Route::post('/tamanho', [AlmoxarifadoController::class, 'store_tamanho'])->name('tamanho.store');
        Route::get('/tamanho/{tamanho}/edit', [AlmoxarifadoController::class, 'edit_tamanho'])->name('tamanho.edit');
        Route::put('/tamanho/{tamanho}', [AlmoxarifadoController::class, 'update_tamanho'])->name('tamanho.update');
        Route::delete('/tamanho/{tamanho}', [AlmoxarifadoController::class, 'destroy_tamanho'])->name('tamanho.destroy');
        //End Tamanho

        //Patrimonio
        Route::get('/almoxarifado', [AlmoxarifadoController::class, 'index'])->name('almoxarifado.index');
        Route::get('/almoxarifado/create', [AlmoxarifadoController::class, 'create'])->name('almoxarifado.create');
        Route::post('/almoxarifado', [AlmoxarifadoController::class, 'store'])->name('almoxarifado.store');
        Route::get('/almoxarifado/{id}/edit', [AlmoxarifadoController::class, 'edit'])->name('almoxarifado.edit');
        Route::put('/almoxarifado/{id}', [AlmoxarifadoController::class, 'update'])->name('almoxarifado.update');
        Route::delete('/almoxarifado/{id}', [AlmoxarifadoController::class, 'destroy'])->name('almoxarifado.destroy');
        Route::get('/almoxarifado/{id}/barcode', [AlmoxarifadoController::class, 'generateBarcode'])->name('patrimonio.barcode');
        //End Patrimonio

        //Grupo patrimonios
        Route::get('/grupo-patrimonios/index', [AlmoxarifadoController::class, 'index_grupo'])->name('grupo_patrimonios.index');
        Route::get('/grupo-patrimonios/create', [AlmoxarifadoController::class, 'create_grupo'])->name('grupo_patrimonios.create');
        Route::post('/grupo-patrimonios', [AlmoxarifadoController::class, 'store_grupo'])->name('grupo_patrimonios.store');
        Route::get('grupo_patrimonios/edit/{id}', [AlmoxarifadoController::class, 'edit_grupo'])->name('grupo_patrimonios.edit');
        Route::put('grupo_patrimonios/update/{id}', [AlmoxarifadoController::class, 'update_grupo'])->name('grupo_patrimonios.update');
        Route::delete('grupo_patrimonios/destroy/{id}', [AlmoxarifadoController::class, 'destroy_grupo'])->name('grupo_patrimonios.destroy');
        Route::get('grupo-patrimonios/{grupoPatrimonioId}/adicionar-patrimonio', [AlmoxarifadoController::class, 'adicionarPatrimonioView'])->name('grupo_patrimonios.adicionarPatrimonio');
        Route::post('grupo-patrimonios/{grupoPatrimonioId}/adicionar-patrimonio', [AlmoxarifadoController::class, 'adicionarPatrimonio'])->name('grupo_patrimonios.salvarPatrimonio');
        Route::get('/grupo-patrimonios/{grupoId}/ferramentas', [AlmoxarifadoController::class, 'listarFerramentas'])->name('grupo_patrimonios.ferramentas');
        Route::delete('/grupo_patrimonios/{grupo}/item/{item}', [AlmoxarifadoController::class, 'deleteItem'])->name('grupo_patrimonios.deleteItem');
        Route::get('/retiradas/create', [AlmoxarifadoController::class, 'create_retirada'])->name('retiradas.create');
        Route::post('/retiradas', [AlmoxarifadoController::class, 'store_retirada'])->name('retiradas.store');
        Route::get('/retiradas', [AlmoxarifadoController::class, 'index_retirada'])->name('retiradas.index');
        Route::get('/retirada/pdf/{id}', [AlmoxarifadoController::class, 'generatePdf'])->name('retiradas.show');
        Route::get('/retirada/retorno', [AlmoxarifadoController::class, 'showRetornoForm'])->name('retirada.retorno');
        Route::get('/retiradas/buscar', [AlmoxarifadoController::class, 'buscar'])->name('retiradas.buscar');
        Route::post('/retiradas/{id}/confirmar-volta', [AlmoxarifadoController::class, 'confirmarVolta'])->name('retiradas.confirmar.volta');
        Route::post('/retirada/retorno/confirmar', [AlmoxarifadoController::class, 'confirmarRetorno'])->name('retirada.confirmar');
        Route::get('/patrimonio/list', [AlmoxarifadoController::class, 'listarPatrimonios'])->name('patrimonio.list');
        //end Grupo

    });

     //Rota Almoxarifado        
     Route::middleware([CheckModuleAccess::class . ':Compras'])->group(function () {
        Route::prefix('Compras')->group(function () {
            Route::get('/funcoes', function () {
                return view('Modulos.Compras.functions');
            })->name('compras.functions');                
        });
        Route::resource('shopping_lists', ShoppingListController::class)->except(['show', 'edit', 'update']);
        Route::get('/shopping-lists/pdf', [ShoppingListController::class, 'generatePdf'])->name('shopping_lists.generate_pdf');
    });




    
});



require __DIR__.'/auth.php';
