<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{
	// Obtener los nombres de las imágenes del usuario autenticado
    public function getUserImages(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $userId = Auth::id();

        // Ruta donde están guardadas las imágenes
        $imagePath = 'images/user_' . $userId;

        // Obtener los nombres de los archivos en la carpeta
        $images = Storage::files($imagePath);

        // Extraer solo los nombres de los archivos
        $imageNames = array_map(function($image) {
            return basename($image); 
        }, $images);

        return response()->json(['images' => $imageNames], 200);
    }

    // Cargar imagen en carpeta de usuario
    public function upload(Request $request)
    {
        // Validación del archivo de imagen
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userId = Auth::id();

        // Obtener la imagen cargada
        $image = $request->file('image');

        // Crear un nombre único para la imagen
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Ruta donde guardarás la imagen
        $imagePath = public_path('images/user_' . $userId);

        // Crear la carpeta si no existe
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        // Comprimir la imagen (calidad 75%)
        $img = Image::make($image->getRealPath());
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
        }) 

        // Guardar la imagen en la carpeta correspondiente en el almacenamiento
        $img->save($imagePath . '/' . $imageName, 75);

        return response()->json(['message' => 'Imagen subida y comprimida con éxito', 'imageName' => $imageName], 200);
    }

    // Descargar imagen de carpeta de usuario
    public function download(Request $request, $userId, $imageName)
	{
	    $userId = Auth::id()

	    // Comprobar si la imagen existe
	    $filePath = 'images/user_' . $userId . '/' . $imageName;
	    if (!Storage::disk('public')->exists($filePath)) {
	        return response()->json(['error' => 'Imagen no encontrada'], 404);
	    }

	    // Descargar la imagen
	    return Storage::disk('public')->download($filePath);
	}
}
