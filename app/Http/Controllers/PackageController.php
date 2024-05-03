<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PackageUpdateService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Package;

class PackageController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Busca os pacotes paginados (por padrão, 10 pacotes por página)
        $packages = Package::orderBy('created_at', 'desc')->paginate(10);

        // Retorna a view 'packages.index' com os pacotes paginados
        return view('packages.index', compact('packages'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida a solicitação
        $request->validate([
            'codigos' => 'required|string', // Requer pelo menos um código
        ]);

        // Separa os códigos usando vírgula como delimitador e remove os espaços em branco ao redor de cada código
        $codigos = array_map('trim', explode(',', $request->codigos));

        // Validação adicional para cada código
        $validator = Validator::make(['codigos' => $codigos], [
            'codigos.*' => 'required|string|max:13|unique:packages,codigo',
        ]);

        // Se a validação falhar, redireciona de volta com mensagens de erro
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array_map(function ($codigo) {
            return [
                'codigo' => $codigo,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $codigos);

        Package::insert($data);

        // Atualiza os pacotes
        $packageUpdateService = new PackageUpdateService();
        $packageUpdateService->trackAndSyncPackages($codigos);

        // Retorna uma resposta de sucesso adequada com base no tipo de solicitação
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Pacotes criados com sucesso!'], 200);
        } else {
            return redirect()->route('packages.index')->with('success', 'Pacotes criados com sucesso!');
        }
    }

    /**
     * Display the specified resource.
     */

    public function details($id)
    {
        $package = Package::findOrFail($id);
        return view('packages.partials.details', compact('package'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('packages.index')->with('success', 'Pacote excluído com sucesso!');
    }

    public function listPackages(Request $request)
    {
        $packages = Package::orderBy('created_at', 'desc')->with('packageEvent')->get();
        return response()->json($packages);
    }

    public function updatePackage(Request $request, $codigo)
    {
        $package = Package::where('codigo', $codigo)->first();

        if (!$package) {
            return response()->json(['message' => 'Pacote não encontrado!'], 404);
        }



        $packageUpdateService = new PackageUpdateService();
        $packageUpdateService->trackAndSyncPackages([$request->codigo]);

        $package->update([
            'updated_at' => Carbon::now(),
        ]);

        //return the package and its events
        return response()->json($package->load('packageEvent'));
    }

}
