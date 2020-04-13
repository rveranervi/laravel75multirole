@extends('layouts.app')

@section('title') Módulos @endsection

@section('css')  @endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h4 class="font-weight-bold text-primary">Módulos</h4>
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
                      <th>Creación</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($modules as $module)
                    <tr>
                      <td>{{ $module->orden }}</td>
                      <td>{{ $module->name }}</td>
                      <td>{{ $module->created_at }}</td>
                      <td>
                        <a href="/submodules/{{ $module->id() }}" class="btn btn-primary">Submódulos</a> 
                        <a href="javascript:permisos('{{ $module->id() }}');" class="btn btn-info">Permisos</a> 
                        <a href="javascript:editar('{{ $module->id() }}');" class="btn btn-secondary">Editar</a> 
                        <a href="javascript:eliminar('{{ $module->id() }}');" class="btn btn-danger">Eliminar</a> 
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{$modules}}
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
        <h5 class="modal-title">Registrar nuevo módulo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/save_module">
          @csrf
          <div class="form-group">
            <input type="number" class="form-control" name="orden" placeholder="Orden">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre">
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
        <h5 class="modal-title">Permisos del módulo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/edit_module_permissions">
          @csrf
          <input type="hidden" name="id">
          <div id="permisosajax"></div>
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
        <h5 class="modal-title">Editar módulo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/edit_module">
          @csrf
          <input type="hidden" name="id">
          <div class="form-group">
            <input type="number" class="form-control" name="orden" placeholder="Orden">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Nombre">
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
        <h5 class="modal-title">Eliminar módulo</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/delete_module">
          @csrf
          <input type="hidden" name="id">
          <p>¿Esta seguro de eliminar el módulo?</p>
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
      $.getJSON( "/get_module_permissions/"+id, function( data ) {
        $("#permisos").find("*[name='id']").val(id);
        $("#permisos").find("#permisosajax").html('');
        $(data.roles).each(function(index, element) {
          var checked = "";
          if(element.selected){
            checked = "checked=true";
          }
          else{
            checked = "";
          }
          $("#permisos").find("#permisosajax").append('<div class="form-check form-group">'+
          '    <label class="form-check-label">'+
          '      <input class="form-check-input" type="checkbox" name="permission[]" value="'+element.ide+'" '+checked+'> '+
          '    '+element.name+'</label>'+
          '</div>');
        });
        $("#permisos").modal();
      });
    }
    function editar(id){
      $.getJSON( "/get_module/"+id, function( data ) {
        $("#editar").find("*[name='id']").val(id);
        $("#editar").find("*[name='orden']").val(data.orden);
        $("#editar").find("*[name='name']").val(data.name);
        $("#editar").modal();
      });
    }
    function eliminar(id){
      $("#eliminar").find("*[name='id']").val(id);
      $("#eliminar").modal();
    }
  </script>
@endsection
