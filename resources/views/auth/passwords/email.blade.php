@extends('layouts.auth')

@section('title') Recuperar contraseña @endsection

@section('content')

<!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">¿Olvidaste tu contraseña?</h1>
                    <p class="mb-4">Lo entendemos, suele suceder. Simplemente ingrese su dirección de correo electrónico a continuación y le enviaremos un enlace para restablecer su contraseña.</p>
                  </div>
                  <form class="user" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Ingresa tu correo eletrónico..." name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Recuperar contraseña</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    @if (Route::has('register'))
                    <a class="small" href="{{ route('register') }}">{{ __('Crea una cuenta') }}</a>
                    @endif
                  </div>
                  <div class="text-center">
                    @if (Route::has('login'))
                    <a class="small" href="{{ route('login') }}">{{ __('¿Ya tienes una cuenta? Iniciar sesión') }}</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

@endsection

