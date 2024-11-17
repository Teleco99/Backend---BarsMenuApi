<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
	// Obtener una imagen de un producto dado su id y su id de admin
    public function getUserImage($idAdmin, $model, $idModel)
    {
        // Ruta donde esta guardada la imagen
        $imagePath = "images/user/$idAdmin/$model/$idModel.jpg";
        
        if (Storage::exists($imagePath)) {
            // Obtener el contenido de la imagen
            $file = Storage::get($imagePath);
            
            // Obtener la extensión del archivo para determinar el Content-Type
            $mimeType = Storage::mimeType($imagePath);

            // Devolver la imagen con el encabezado adecuado
            return Response::make($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $idModel . '.jpg"'
            ]);
        } else {
            return response()->json(['error' => 'Imagen no encontrada'], 404);
        }
    }

    // Cargar imagen en carpeta de usuario
    public function uploadImage(Request $request, $model)
    {
        // Validación del archivo de imagen
        $request->validate([
            'idModel' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener el ID del admin autenticado
        $idAdmin = Auth::id();

        // Obtener la imagen cargada
        $image = $request->file('image');

        // Crear un nombre con la id del producto
        $imageName = $request->idModel . '.jpg';

        // Ruta donde guardarás la imagen
        $imagePath = "images/user/$idAdmin/$model";

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
        
        // Actualizar el campo 'hasImage' del producto en la base de datos
        $product = Product::find($request->idModel);
        if ($product) {
            $product->hasImage = true;  
            $product->save();
        }

        return response()->json(['message' => 'Imagen subida y comprimida con éxito', 'imageName' => $imageName], 200);
    }
    
    // Eliminar imagen de un producto del admin autenticado
    public function deleteImage($model, $idModel)
        {
        // Obtener el ID del admin autenticado
        $idAdmin = Auth::id();
    
        // Ruta donde está guardada la imagen
        $imagePath = "images/user/$idAdmin/$model/$idModel.jpg";
    
        // Verificar si la imagen existe
        if (Storage::exists($imagePath)) {
            // Eliminar la imagen
            Storage::delete($imagePath);
            
            // Actualizar el campo 'hasImage' del producto a false
            $product = Product::find($idModel);
            if ($product) {
                $product->hasImage = false;   
                $product->save();
            }
            
            return response()->json(['message' => 'Imagen eliminada con éxito'], 200);
        } else {
            return response()->json(['error' => 'Imagen no encontrada'], 404);
        }
    }
}
