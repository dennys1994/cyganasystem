<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\Margem\MargemController;
use App\Http\Controllers\Modulos\RelatorioFechamentoController;

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
                return view('Modulos.RelatorioFechamento.index');
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
                return view('Modulos.RelatorioFechamento.Users.index');
            })->name('relatorio.users.index');

            Route::get('/usuarios-store', function () {
                return view('Modulos.RelatorioFechamento.Users.store');
            })->name('relatorio.users.store');            

            //funções da geração do relatorio
            Route::get('/relatorio', function () {
                return view('Modulos.RelatorioFechamento.Relatorio.index');
            })->name('relatorio.index'); 

            //listar clientes
            Route::get('/clientes', [RelatorioFechamentoController::class, 'getClientes'])->name('relatorio.clientes');
            //listar ordens de serviço
            Route::get('ordens-servico/{cliente_id}/{cnpj}', [RelatorioFechamentoController::class, 'listarOrdensServico'])->name('ordens-servico');
            //gerar pdf relatorio
            Route::post('/relatorio/pdf', [RelatorioFechamentoController::class, 'gerarRelatorioPdf'])->name('relatorio.pdf');

            Route::post('/limpar-cache', [RelatorioFechamentoController::class, 'limparCache'])->name('limpar.cache');

        });

    
    });

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

    
});



require __DIR__.'/auth.php';
