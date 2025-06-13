<?php

namespace App\Http\Controllers\Crud_basic\Users;

use App\Http\Controllers\Controller;
use App\Services\RecepcionistaLogic; // Asegúrate que sea App\Services\RecepcionistaLogic
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\File; // Importa la fachada File

class RecepcionistaController extends Controller
{
    protected $recepcionistaLogic;

    public function __construct(RecepcionistaLogic $recepcionistaLogic)
    {
        $this->recepcionistaLogic = $recepcionistaLogic;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|unique:recepcionista|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|unique:recepcionista|max:255',
                'password' => 'required|string|min:5',
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255',
                'salario' => 'required|numeric',
                'urlImage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Imagen requerida al registrar
            ]);

            $imagePath = null;
            if ($request->hasFile('urlImage')) {
                $image = $request->file('urlImage');
                $cedula = $request->input('cedula');
                $imageName = $cedula . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/recepcionistas');

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }

                $image->move($destinationPath, $imageName);
                $imagePath = 'images/recepcionistas/' . $imageName;
            }

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        return $this->recepcionistaLogic->registrar(
            $request->cedula,
            $request->nombre,
            $request->email,
            $request->password,
            $request->edad,
            $request->sexo,
            $request->salario,
            $imagePath // Pasa la ruta de la imagen
        );
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
        return $this->recepcionistaLogic->login($request->email, $request->password);
    }

    public function logout(Request $request)
    {
        return $this->recepcionistaLogic->logout($request->user('recepcionista_api'));
    }

    public function user(Request $request)
    {
        return $this->recepcionistaLogic->getAutenticado($request->user('recepcionista_api'));
    }

    public function userAuth(Request $request)
    {
        return $this->recepcionistaLogic->getAutenticado($request->user('recepcionista_api'));
    }

    public function getAll()
    {
        return $this->recepcionistaLogic->getAll();
    }

    public function getByCedula(Request $request)
    {
        return $this->recepcionistaLogic->getByCedula($request->cedula);
    }

    public function getByEmail(Request $request)
    {
        return $this->recepcionistaLogic->getByEmail($request->email);
    }

    public function getByNombre(Request $request)
    {
        return $this->recepcionistaLogic->getByNombre($request->nombre);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'cedula' => 'required|string|max:20',
                'nombre' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'edad' => 'nullable|int|max:20',
                'sexo' => 'nullable|string|max:255',
                'salario' => 'nullable|numeric|min:0',
                'urlImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Imagen opcional al actualizar
            ]);

            $imagePath = null;
            $cedula = $request->input('cedula');

            $existingRecepcionista = $this->recepcionistaLogic->getByCedula($cedula);
            if ($existingRecepcionista && property_exists($existingRecepcionista, 'urlImage')) {
                $imagePath = $existingRecepcionista->urlImage;
            }

            if ($request->hasFile('urlImage')) {
                $image = $request->file('urlImage');
                
                if ($existingRecepcionista && $existingRecepcionista->urlImage) {
                    $oldImagePath = public_path($existingRecepcionista->urlImage);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
                
                $imageName = $cedula . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images/recepcionistas');

                if (!File::isDirectory($destinationPath)) {
                    File::makeDirectory($destinationPath, 0777, true, true);
                }

                $image->move($destinationPath, $imageName);
                $imagePath = 'images/recepcionistas/' . $imageName;
            }

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }

        $array = [
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'edad' => $request->edad,
            'sexo' => $request->sexo,
            'salario' => $request->salario,
            'urlImage' => $imagePath // Pasa la ruta de la imagen
        ];
        
        return $this->recepcionistaLogic->update($request->cedula, $array);
    }

    public function delete(Request $request)
    {
        $existingRecepcionista = $this->recepcionistaLogic->getByCedula($request->cedula);
        if ($existingRecepcionista && property_exists($existingRecepcionista, 'urlImage') && $existingRecepcionista->urlImage) {
            $imagePathToDelete = public_path($existingRecepcionista->urlImage);
            if (File::exists($imagePathToDelete)) {
                File::delete($imagePathToDelete);
            }
        }
        return $this->recepcionistaLogic->delete($request->cedula);
    }
}