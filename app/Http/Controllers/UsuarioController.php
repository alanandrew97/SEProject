<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DatosUsuario;
use App\Maestro;
use App\Alumno;
use App\Escuela;    

class UsuarioController extends Controller {

    public function login(Request $request) {
        $correo = $request->input('correo');
        $password = $request->input('password');

        $datos_usuario = DatosUsuario::where('correo', '=', $correo)->first();
        
        if($datos_usuario != null) {
            if(password_verify($password, $datos_usuario->password)) {
            $maestro = Maestro::where('id_datos_usuario', '=', $datos_usuario->id)->first();
            if($maestro != null) {
                return redirect('/escuela');
            } else {
                $alumno = Alumno::where('id_datos_usuario', '=', $datos_usuario->id)->first();
                if($alumno != null) {
                    return redirect('/escuela');
                } else {
                    return redirect('/')->withErrors(['Usuario ha dejado de existir']);
                }
            }
        } else {
            return redirect('/')->withErrors(['Correo o contraseña incorrectos']);
        }
        } else {
            return redirect('/')->withErrors(['Correo o contraseña incorrectos']);
        }
    }

    public function index(Request $request) {
        $escuela = Escuela::all()->first();
        $maestros = Maestro::all();
        $submenuItems = [
            ['nombre'=>'Maestros', 'link'=>url('usuarios/'), 'selected'=>true],
            ['nombre'=>'Alumnos', 'link'=>url('usuarios/alumnos'), 'selected'=>false]
        ];

        return view('usuario.listaMaestros', array(
            'maestros' => $maestros,
            'escuela' => $escuela,
            'submenuItems' => $submenuItems
        ));
    }

    public function listaAlumnos(Request $request) {
        $escuela = Escuela::all()->first();
        $alumnos = Alumno::all();
        $submenuItems = [
            ['nombre'=>'Maestros', 'link'=>url('usuarios/'), 'selected'=>true],
            ['nombre'=>'Alumnos', 'link'=>url('usuarios/alumnos'), 'selected'=>false]
        ];

        return view('usuario.listaAlumnos', array(
            'alumnos' => $alumnos,
            'escuela' => $escuela,
            'submenuItems' => $submenuItems
        ));
    }

    public function nuevo(Request $request) {
        return view('usuarios.nuevo');
    }

    public function registrar(Request $request) {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'correo' => 'required',
            'password' => 'required',
            'rol' => 'required'
        ]);

        $nombre = $request->input('nombre');
        $apellido_paterno = $request->input('apellido_paterno');
        $apellido_materno = $request->input('apellido_materno');
        $correo = $request->input('correo');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $administrador = 0;
        $rol = $request->input('rol');

        if(!is_null($request->input('administrador'))) {
            $administrador = 1;
        }

        $datos_usuario = DatosUsuario::create([
            'nombre' => $nombre,
            'apellido_paterno' => $apellido_materno,
            'apellido_materno' => $apellido_materno,
            'correo' => $correo,
            'password' => $password
        ]);

        if($rol == 1) {
            Maestro::create([
                'id_datos_usuario' => $datos_usuario->id,
                'administrador' => $administrador
            ]);
        } else {
            Alumno::create([

            ]);
        }

        return redirect('usuarios');
    }

    public function registrarPrimerUsuario(Request $request) {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'correo' => 'required',
            'password' => 'required',
            'rol' => 'required'
        ]);

        $nombre = $request->input('nombre');
        $apellido_paterno = $request->input('apellido_paterno');
        $apellido_materno = $request->input('apellido_materno');
        $correo = $request->input('correo');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $administrador = $request->input('administrador');
        $rol = $request->input('rol');

        $datos_usuario = DatosUsuario::create([
            'nombre' => $nombre,
            'apellido_paterno' => $apellido_paterno,
            'apellido_materno' => $apellido_materno,
            'correo' => $correo,
            'password' => $password
        ]);

        if($rol == 1) {
            Maestro::create([
                'id_datos_usuario' => $datos_usuario->id,
                'administrador' => $administrador
            ]);
        } 

        return redirect('/');
    }

    public function editar(Request $request) {
        $this->validate($request, [
            'nombre' => 'required',
            'apellido_paterno' => 'required',
            'apellido_materno' => 'required',
            'correo' => 'required',
            'password' => 'required',
            'rol' => 'required'
        ]);

        $nombre = $request->input('nombre');
        $apellido_paterno = $request->input('apellido_paterno');
        $apellido_materno = $request->input('apellido_materno');
        $correo = $request->input('correo');
        $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $administrador = 0;
        $rol = $request->input('rol');

        if(!is_null($request->input('administrador'))) {
            $administrador = 1;
        }

        $datos_usuario = DatosUsuario::where('correo', '=', $correo)->first();
        $maestro = Maestro::where('id_datos_usuario', '=', $datos_usuario->id)->first();

        if(!is_null($maestro)) {
            $datos_usuario->nombre = $nombre;
            $datos_usuario->apellido_paterno = $apellido_paterno;
            $datos_usuario->apellido_materno = $apellido_materno;
            $datos_usuario->correo = $correo;
            $datos_usuario->password = $password;
            $maestro->administrador = $administrador;

            $datos_usuario->save();
            $maestro->save();
        } else {
            //Editar alumno
        }

        return redirect('usuarios');
    }

    public function eliminar(Request $request) {
        $datos_usuario = DatosUsuario::find($request->input('id_datos_usuario'));
        $maestro = Maestro::where('id_datos_usuario', '=', $datos_usuario->id)->first();

        if(!is_null($maestro)) {
            $maestro->delete();
            $datos_usuario->delete();
        } else {
            //Eliminar alumno
        }

        return redirect('usuarios');
    }
}
