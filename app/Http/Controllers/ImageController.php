<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
	// Obtener una imagen de un producto del admin autenticado
    public function getUserImage(Request $request, $idProduct)
    {
        // Obtener el ID del admin autenticado
        //$userId = Auth::id();
        $userId = 2;

        // Ruta donde esta guardada la imagen
        $imagePath = 'images/user/' . $userId . '/' . $idProduct . '.jpg';
        
        if (Storage::exists($imagePath)) {
            // Obtener el contenido de la imagen
            $file = Storage::get($imagePath);
            
            // Obtener la extensión del archivo para determinar el Content-Type
            $mimeType = Storage::mimeType($imagePath);

            // Devolver la imagen con el encabezado adecuado
            return Response::make($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $idProduct . '.jpg"'
            ]);
        } else {
            return response()->json(['error' => 'Imagen no encontrada'], 404);
        }
    }

    // Cargar imagen en carpeta de usuario
    public function uploadImage(Request $request)
    {
        // Validación del archivo de imagen
        $request->validate([
            'idProduct' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener el ID del admin autenticado
        $userId = Auth::id();

        // Obtener la imagen cargada
        $image = $request->file('image');

        // Crear un nombre con la id del producto
        $imageName = $request->idProduct . '.jpg';

        // Ruta donde guardarás la imagen
        $imagePath = 'images/user/' . $userId;

        // Crear la carpeta si no existe
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        // Redimensionar la imagen si es más grande que 800x600 píxeles
        $img = Image::make($image->getRealPath());
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();  // Mantener la relación de aspecto
            $constraint->upsize();       // Evitar que se agrande si es pequeña
        }); 

        // Comprimir la imagen (calidad 75%)
        $compressedImage = (string) $img->encode('jpg', 75);

        // Guardar la imagen en el almacenamiento con Laravel Storage
        $compressedImagePath = $imagePath . '/' . $imageName;
        Storage::put($compressedImagePath, $compressedImage);

        return response()->json(['message' => 'Imagen subida y comprimida con éxito', 'imageName' => $imageName], 200);
    }
}
