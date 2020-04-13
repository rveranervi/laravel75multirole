@extends('layouts.app')

@section('title') Usuarios @endsection

@section('css')  @endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
            <div class="card-header">
              <div class="row">
                  <div class="col-md-8">
                      <h4 class="font-weight-bold text-primary">Usuarios</h4>
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
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Correo</th>
                      <th>Rol</th>
                      <th>Registro</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($users as $user)
                    <tr>
                      <td>{{ $user->firstname }}</td>
                      <td>{{ $user->lastname }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->getrole()->name }}</td>
                      <td>{{ $user->created_at }}</td>
                      <td>
                        <a href="javascript:editar('{{ $user->id() }}');" class="btn btn-secondary">Editar</a> 
                        <a href="javascript:eliminar('{{ $user->id() }}');" class="btn btn-danger">Eliminar</a> 
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{$users}}
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
        <h5 class="modal-title">Registrar nuevo usuario</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/save_user">
          @csrf
          <div class="form-group">
            <input type="text" class="form-control" name="firstname" placeholder="Nombres">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="lastname" placeholder="Apellidos">
          </div>
          <div class="form-group">
            <select class="form-control" name="role">
              <option value="">Rol</option>
              @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Correo Electrónico">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="password" placeholder="Contraseña">
          </div>
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
        <h5 class="modal-title">Editar usuario</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/edit_user">
          @csrf
          <input type="hidden" name="id">
          <div class="form-group">
            <input type="text" class="form-control" name="firstname" placeholder="Nombres">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="lastname" placeholder="Apellidos">
          </div>
          <div class="form-group">
            <select class="form-control" name="role">
              <option value="">Rol</option>
              @foreach($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="email" placeholder="Correo Electrónico">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="password" placeholder="Contraseña">
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
        <h5 class="modal-title">Eliminar usuario</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="/delete_user">
          @csrf
          <p>¿Esta seguro de eliminar el usuario?</p>
          <input type="hidden" name="id">
          <button type="submit" class="btn btn-danger btn-block">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js') 
  <script type="text/javascript">
    function editar(id){
      $.getJSON( "/get_user/"+id, function( data ) {
        $("#editar").find("*[name='id']").val(id);
        $("#editar").find("*[name='firstname']").val(data.firstname);
        $("#editar").find("*[name='lastname']").val(data.lastname);
        $("#editar").find("*[name='role']").val(data.role);
        $("#editar").find("*[name='email']").val(data.email);
        $("#editar").modal();
      });
    }
    function eliminar(id){
      $("#eliminar").find("*[name='id']").val(id);
      $("#eliminar").modal();
    }
  </script>
@endsection
