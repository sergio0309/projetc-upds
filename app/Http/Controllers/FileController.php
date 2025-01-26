<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $clientId = Client::where('user_id', $userId)->value('id');
        $files = File::where('client_id', $clientId)->get();
        foreach ($files as $file) {
            // Verifica si el archivo existe antes de acceder a sus propiedades
            if (Storage::disk('public')->exists($file->file)) {
                // Generar la URL pública del archivo
                $file->file_url = asset('storage/' . $file->file);

                // Determinar el tipo MIME
                $file->file_type = mime_content_type(storage_path('app/public/' . $file->file));
            } else {
                // Manejar archivos inexistentes
                $file->file_url = null;
                $file->file_type = 'Archivo no encontrado';
            }
        }

        return view('file.index', compact('files'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|mimes:jpg,jepg,png,pdf,xlsx,doc|max:2048',
        ]);
        $user = Auth::user();
        $client_id = $user->client->id;
        // dd('id', $client_id);
        try {
            DB::beginTransaction();
            foreach ($request->file('files') as $file) {

                $path = $file->store('files', 'public');

                File::create([
                    'data' => today(),
                    'file' => $path,
                    'client_id' => $client_id,
                ]);
            }
            DB::commit();
            return redirect()->route('files.index')->with('success', 'Archivo subido exitosamente.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('files.index')->with('Error', 'Error al subir archivo');

        }
    }

    public function download(File $file)
    {
        if (!Storage::disk('public')->exists($file->file)) {
            return redirect()->route('files.index')->with('error', 'El archivo no existe en el servidor.');
        }

        // Obtén la ruta completa del archivo
        $filePath = storage_path('app/public/' . $file->file);

        // Descarga el archivo
        return response()->download($filePath, basename($file->file));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048', // Ajusta los formatos permitidos según necesidad
        ]);

        try {
            // Eliminar el archivo anterior si existe
            if (Storage::disk('public')->exists($file->file)) {
                Storage::disk('public')->delete($file->file);
            }

            // Guardar el nuevo archivo
            $newFilePath = $request->file('file')->store('files', 'public');

            // Actualizar el registro en la base de datos
            $file->update([
                'file' => $newFilePath,
            ]);

            return redirect()->route('files.index')->with('success', 'Archivo reemplazado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('files.index')->with('error', 'Error al reemplazar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $file = File::findOrFail($id);
            if (Storage::disk('public')->exists($file->file)) {
                Storage::disk('public')->delete($file->file);
            }
            $file->delete();
            return redirect()->route('files.index')->with('success', 'Archivo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('files.index')->with('error', 'Error al eliminar el archivo: ' . $e->getMessage());
        }
    }
}
