@extends('layouts.app')

@section('title') Inicio @endsection

@section('css')  @endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-weight-bold text-primary">Bienvenidos</h4>
                </div>
                <div class="card-body">
                    <p>Plantilla pre realizada en base a:</p>
                    <ul>
                        <li>
                            <b>Laravel 7.5.2: </b> Framework PHP
                        </li>
                        <li>
                            <b>Bootstrap 4: </b> Framework CSS Responsive
                        </li>
                        <li>
                            <b>SB Admin 2: </b> Thema Dashboard basado en Bootstrap 4
                        </li>
                    </ul>
                    <p>El sistema cuenta con las siguientes caracteristicas:</p>
                    <ul>
                        <li>
                            <b>Autenticación</b>, sistema multiusuario basado en <b>php artisan make:auth</b> la cual se encuentra implementada con el envio de validación por correo electrónico. Los accesos al panel de gestión son previa validación de correo electrónico. 
                        </li>
                        <li>
                            <b>Roles</b>, gestión de roles personalizados.
                        </li>
                        <li>
                            <b>Módulos</b>, el sistema soporta la creación, edición y eliminación de modulos, submódulos y elementos de submódulos.
                        </li>
                        <li>
                            <b>Permisos</b>, además cuenta con personalización de permisos por rol para los módulos y submódulos del sistema.
                        </li>
                    </ul>
                    <p>Consideraciones el sistema actual:</p>
                    <ul>
                        <li>
                            El sistema elimina y edita los elementos con el ID Encriptado. 
                        </li>
                        <li>
                            Las operaciones de creción, edición y eliminación trabajan con un Token de por medio y en el método POST.
                        </li>
                        <li>
                            El acceso a los submódulos es condicional <b>IF name_route == url_submodulo</b>. Si el <b>name_route</b> no existe en como <b>url_submodulo</b> en la tabla de submódulos, entonces el acceso es concedido.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')  @endsection
