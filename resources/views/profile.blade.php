@extends('layouts.app')

@section('title') Mi perfil @endsection

@section('css')  @endsection

@section('content')
<div class="container">

	<div class="card o-hidden border-0 shadow-lg my-5">
	  <div class="card-body p-0">
	    <!-- Nested Row within Card Body -->
	    <div class="row">
	      <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
	      <div class="col-lg-7">
	        <div class="p-5">
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
	          <div class="text-center">
	            <h1 class="h4 text-gray-900 mb-4">Datos de Perfil</h1>
	          </div>
	          <form method="POST" action="/edit_profile" class="user">
          		@csrf
	            <div class="form-group row">
	              <div class="col-sm-6 mb-3 mb-sm-0">
	                <input type="text" class="form-control form-control-user" placeholder="Nombres" value="{{ Auth::user()->firstname }}" name="firstname">
	              </div>
	              <div class="col-sm-6">
	                <input type="text" class="form-control form-control-user" placeholder="Apellidos" value="{{ Auth::user()->lastname }}" name="lastname">
	              </div>
	            </div>
	            <div class="form-group">
	              <input required="" type="email" class="form-control form-control-user" placeholder="Correo electrónico" value="{{ Auth::user()->email }}" name="email" autocomplete="email">
	            </div>
	            <div class="form-group row">
	              <div class="col-sm-6 mb-3 mb-sm-0">
	                <input type="password" class="form-control form-control-user" placeholder="Contraseña" name="password" autocomplete="new-password">
	              </div>
	              <div class="col-sm-6">
	                <input type="password" class="form-control form-control-user" placeholder="Repetir contraseña" name="password_confirmation" autocomplete="new-password">
	              </div>
	            </div>
	            <button type="submit" class="btn btn-primary btn-user btn-block">Actualizar información</button>
	              
	            </a>
	            <hr>
	            <a href="index.html" class="btn btn-google btn-user btn-block">
	              <i class="fab fa-google fa-fw"></i> Enlazar con Google
	            </a>
	            <a href="index.html" class="btn btn-facebook btn-user btn-block">
	              <i class="fab fa-facebook-f fa-fw"></i> Enlazar con Facebook
	            </a>
	          </form>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

</div>
@endsection

@section('js')  @endsection
