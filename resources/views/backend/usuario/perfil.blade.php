@extends('backend.app')
@php
    $usuario = $data['usuario'];
@endphp

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Mi Perfil</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="profileForm" method="POST" action="{{ route('perfil.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-sm-4 mt-3 mt-sm-0 text-center">
                                    <label for="image" class="form-label">Foto de perfil: </label>
                                    <div class="image-uploader h-0 m-0  d-flex justify-content-center">
                                        <div class="upload-area" id="uploadArea" style="height: 100%; width:50%">
                                            <div class="upload-placeholder" id="placeholder">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <div class="upload-text">
                                                    Arrastra una imagen aquí<br />o haz clic para seleccionar
                                                </div>
                                            </div>
                                            <input type="file" id="fileInput" name="image" accept="image/*"
                                                style="display: none" />
                                            <small id='error-image' class="text-danger"></small>
                                        </div>
                                    </div>
                                    <h5 class="mt-3">{{ $usuario->nombre }} {{ $usuario->paterno }}</h5>
                                    <p class="text-muted text-uppercase">{{ $usuario->rol }}</p>
                                </div>
                                {{-- <div class="col-md-4 text-center">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" name="image"
                                                accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload">
                                                <i class="fas fa-pencil-alt"></i>
                                            </label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                style="background-image: url('{{ $usuario->ruta_archivo ? asset('storage/' . $usuario->ruta_archivo) : asset('assets/img/default-profile.png') }}');">
                                            </div>
                                        </div>
                                        <h5 class="mt-3">{{ $usuario->nombre }} {{ $usuario->paterno }}</h5>
                                        <p class="text-muted">{{ $usuario->rol }}</p>
                                    </div>
                                </div> --}}
                                <div class="col-md-8">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Nombre</label>
                                                <input type="text" class="form-control" name="nombre"
                                                    value="{{ old('nombre', $usuario->nombre) }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Apellido Paterno</label>
                                                <input type="text" class="form-control" name="paterno"
                                                    value="{{ old('paterno', $usuario->paterno) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Apellido Materno</label>
                                                <input type="text" class="form-control" name="materno"
                                                    value="{{ old('materno', $usuario->materno) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Celular</label>
                                                <input type="tel" class="form-control" name="celular"
                                                    value="{{ old('celular', $usuario->celular) }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Email</label>
                                                <input type="email" class="form-control" value="{{ $usuario->email }}"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Usuario</label>
                                                <input type="text" class="form-control" value="{{ $usuario->usuario }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn bg-gradient-primary mt-4">Guardar Cambios</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        const url = @json($usuario->ruta_archivo ? '/storage/' . $usuario->ruta_archivo : null);
        imageUploader.loadImageFromURL(url);
    </script>
@endsection
