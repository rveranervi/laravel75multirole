@extends('layouts.app')

@section('title') Elementos de Submódulo @endsection

@section('css')  @endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h4 class="font-weight-bold text-primary">Elementos de Submódulos</h4>
                  </div>
                  <div class="col-md-4 text-right">
                      <button class="btn btn-primary" data-toggle="modal" data-target="#new">Agregar</button>
                  </div>
              </div>
            </div>
            <div class="card-body">
              @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
              @endif
              <div class="table table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead class="thead-dark">
                    <tr>
                      <th>Orden</th>
                      <th>Nombre</th>
                      <th>Enlace</th>
                      <th>Creación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($elements as $element)
                    <tr>
                      <td>{{ $element->orden }}</td>
                      <td>{{ $element->name }}</td>
                      <td>{{ $element->link }}</td>
                      <td>{{ $element->created_at }}</td>
                      <td>
                        <a href="javascript:editar('{{ $element->id() }}');" class="btn btn-secondary">Editar</a> 
                        <a href="javascript:eliminar('{{ $element->id() }}');" class="btn btn-danger">Eliminar</a> 
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{$elements}}
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

<div class="modal fade hide" id="new" tabindex="-1" module="dialog">
  <div class="modal-dialog" module="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo elemento</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/save_submoduleelements">
          @csrf
          <input type="hidden" name="submodule" value="{{ $submodule }}">
          <div class="form-group">
            <input type="number" class="form-control" name="orden" placeholder="Orden">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="link" placeholder="Enlace">
          </div>
          <button type="submit" class="btn btn-primary btn-block">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade hide" id="permisos" tabindex="-1" module="dialog">
  <div class="modal-dialog" module="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Permisos del elemento</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/">
          @csrf
          <button type="submit" class="btn btn-primary btn-block">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade hide" id="editar" tabindex="-1" module="dialog">
  <div class="modal-dialog" module="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar elemento</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/edit_submoduleelements">
          @csrf
          <input type="hidden" name="id">
          <div class="form-group">
            <input type="number" class="form-control" name="orden" placeholder="Orden">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="link" placeholder="Enlace">
          </div>
          <button type="submit" class="btn btn-primary btn-block">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade hide" id="eliminar" tabindex="-1" module="dialog">
  <div class="modal-dialog" module="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar elemento</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/delete_submoduleelements">
          @csrf
          <input type="hidden" name="id">
          <p>¿Esta seguro de eliminar el elemento?</p>
          <button type="submit" class="btn btn-danger btn-block">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js') 
  <script type="text/javascript">
    function permisos(id){
      $.getJSON( "/get_submoduleelements/"+id, function( data ) {
        
      });
    }
    function editar(id){
      $.getJSON( "/get_submoduleelements/"+id, function( data ) {
        $("#editar").find("*[name='id']").val(id);
        $("#editar").find("*[name='orden']").val(data.orden);
        $("#editar").find("*[name='name']").val(data.name);
        $("#editar").find("*[name='link']").val(data.link);
        $("#editar").modal();
      });
    }
    function eliminar(id){
      $("#eliminar").find("*[name='id']").val(id);
      $("#eliminar").modal();
    }
  </script>
@endsection
