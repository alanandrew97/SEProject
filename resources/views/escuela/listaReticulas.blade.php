@extends('layouts.app')

@section('title')
  Reticulas
@endsection

@section('cabecera')
  Reticulas
@endsection

@section('head')
  <script src="{{url('/js/escuela/escuela.js')}}"></script>
@endsection

@section('contenedor')
  <div class="row">
    <h1>Reticulas</h1>
  </div>
  <div class="row">
    <div class="col s12">
      @if( count($carreras) != 0 )
        @foreach($carreras as $carrera)
          <h4>{{$carrera->nombre}}</h4>
          @if (count($carrera->reticulas)!=0)
            <ul class="collapsible">
              @foreach($carrera->reticulas as $reticula)
                <li>
                  <div class="collapsible-header" style="position:relative;">
                    <i class="material-icons">dashboard</i>{{$carrera->abreviatura}}-<div class="reticulaNumero">{{$reticula->numero}}</div>&nbsp;&nbsp;Número de semestres:&nbsp;<div class="reticulaSemestres">{{$reticula->numero_semestres}}</div>
                    <a href="#modalEditarReticula" class="modal-trigger"><i style="position:absolute;right:35px;" data-reticula-id="{{$reticula->id}}" class="material-icons right edit-reticula">edit</i></a>
                    <a href="#modalEliminarReticula" class="modal-trigger"><i style="position:absolute;right:0px;" data-reticula-id="{{$reticula->id}}" class="material-icons right delete-reticula">close</i></a>
                  </div>
                  <div class="collapsible-body" style="padding: 20px;">
                    @if (count($reticula->materias)!=0)
                      @foreach ($reticula->materias as $materia)
                        <span style="position:inherit;" class="col s4">
                          <div class="materia" style="text-align:center;padding:10px;width:100%;">
                            {{$materia->nombre}}<br>
                            {{$materia->clave}}<br>
                            {{$materia->horas_teoria}}-{{$materia->horas_practica}}-{{$materia->creditos}}
                          </div>
                        </span>
                      @endforeach
                    @else
                      <div>No hay materias asignadas a esta retícula</div>
                    @endif
                  </div>
                </li>
              @endforeach
            </ul>
          @else
            <div class="error">Aun no hay retículas registradas en esta carrera.</div>
          @endif
        @endforeach
      @else
        <div class="error">Aun no hay carreras registradas en esta escuela.</div>
      @endif

      <div class="fixed-action-btn">
        <a href="#modalNuevaCarrera" class="modal-trigger accent-color modal-close btn-floating btn-large">
          <i class="large material-icons">add</i>
        </a>
      </div>

    </div>
  </div>

@endsection

@section('modals')
  <div id="modalNuevaCarrera" class="modal" style="padding:20px;overflow-y:scroll;">
    <form id="form-crear" method="post" action="{{url('/escuela/crearCarrera')}}" class="col s12" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="row">
          <h2 style="margin-bottom:25px;">Nueva carrera</h2>
        </div>

        <div class="row" id="imgNuevaCarreraContainer">

          <!-- <img src="" alt="Nueva Carrera" id="imgNuevaCarrera"> -->
        </div>

        <div class="row">
          <div class="file-field input-field col s12">
            <div class="btn">
              <span>Imagen</span>
              <input name="imagenCarrera" type="file" id="imagenCarrera">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s8 ">
            <input  id="nombre" name="nombre" type="text" maxlength="70" required>
            <label for="nombre">Nombre</label>
          </div>
          <div class="input-field col s4">
            <input  id="abreviatura" name="abreviatura" type="text" maxlength="20" required>
            <label for="abreviatura">Abreviatura</label>
          </div>
        </div>

        <div class="row">
          <div class="col s12 m6">
            <div class="input-field">
              <input type="number" id="totalCreditos" name="totalCreditos" required>
              <label for="totalCreditos">Total Créditos</label>
            </div>
          </div>
          <div class="col s12 m6">
            <div class="input-field">
              <input type="number" id="estructuraGenericaCreditos" name="estructuraGenericaCreditos" required>
              <label for="estructuraGenericaCreditos">Estructura Genérica Créditos</label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6">
            <input type="number" id="residenciaProfesionalCreditos" name="residenciaProfesionalCreditos" required>
            <label for="residenciaProfesionalCreditos">Residencia Profecional Créditos</label>
          </div>
          <div class="input-field col s12 m6">
            <input type="number" id="servicioSocialCreditos" name="servicioSocialCreditos" required>
            <label for="servicioSocialCreditos">Servicio Social Créditos</label>
          </div>
        </div>

        <div class="row">
          <div class="input-field col s12 m6">
            <input type="number" id="actividadesComplementariasCreditos" name="actividadesComplementariasCreditos" required>
            <label for="actividadesComplementariasCreditos">Actividades Complementarias Créditos</label>
          </div>
        </div>

        <div class="row">
          <input class="input-field btn right dark-primary-color" style="width:70%; margin:auto;" type="submit" value="Registrar">
        </div>
    </form>
  </div>

  <div id="modalEditarCarrera" class="modal" style="padding:30px;overflow-y:scroll;">
    <form id="formEditar" method="POST" action="{{url('/escuela/editarCarrera/')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="row">
        <h2 style="margin-bottom:25px;">Editar carrera</h2>
        <input type="hidden" name="carreraId" id="carreraId">
      </div>

      <div class="row" id="imgEditarCarreraContainer">
        <img src="" alt="Editar imagen Carrera" id="imgEditarCarrera" style="height:100px;margin:auto;">
      </div>

      <div class="row">
        <div class="file-field input-field col s12">
          <div class="btn">
            <span>Imagen</span>
            <input name="ruta_imagen" type="file" id="ruta_imagen">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s8 ">
          <input  id="nombre" name="nombre" type="text" maxlength="70" required>
          <label for="nombre">Nombre</label>
        </div>
        <div class="input-field col s4">
          <input  id="abreviatura" name="abreviatura" type="text" maxlength="20" required>
          <label for="abreviatura">Abreviatura</label>
        </div>
      </div>

      <div class="row">
        <div class="col s12 m6">
          <div class="input-field">
            <input type="number" id="totalCreditos" name="totalCreditos" required>
            <label for="totalCreditos">Total Créditos</label>
          </div>
        </div>
        <div class="col s12 m6">
          <div class="input-field">
            <input type="number" id="estructuraGenericaCreditos" name="estructuraGenericaCreditos" required>
            <label for="estructuraGenericaCreditos">Estructura Genérica Créditos</label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6">
          <input type="number" id="residenciaProfesionalCreditos" name="residenciaProfesionalCreditos" required>
          <label for="residenciaProfesionalCreditos">Residencia Profecional Créditos</label>
        </div>
        <div class="input-field col s12 m6">
          <input type="number" id="servicioSocialCreditos" name="servicioSocialCreditos" required>
          <label for="servicioSocialCreditos">Servicio Social Créditos</label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6">
          <input type="number" id="actividadesComplementariasCreditos" name="actividadesComplementariasCreditos" required>
          <label for="actividadesComplementariasCreditos">Actividades Complementarias Créditos</label>
        </div>
      </div>

      <div class="row">
          <input class="input-field btn right dark-primary-color" style="width:70%; margin:auto;" type="submit" value="Guardar">
      </div>
    </form>
  </div>

  <div class="modal modal-fixed-footer" id="modalEliminarCarrera" style="padding:30px;max-height:200px;">
    <form id="formEliminar" action="{{url('/escuela/eliminarCarrera')}}" method="POST">
      {{csrf_field()}}
      <input type="hidden" name="carrera_id" id="carrera_id">
      <h2>¿Desea eliminar esta carrera?</h2>
      <div class="modal-footer">
        <button class="waves-effect btn primary-color" type="submit" form="formEliminar" style="width:40%;margin:auto;">Sí</button>
        <a href="" class="modal-action modal-close waves-effect btn accent-color" style="width:35%;margin:auto;">
          Cancelar
        </a>
      </div>
    </form>
  </div>
@endsection