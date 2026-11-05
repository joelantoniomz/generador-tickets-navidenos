@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div style="display: grid; grid-template-columns: 340px 1fr; gap: 14px;">
        <!-- Card Crear Usuario -->
        <div class="panel-card">
            <div class="panel-header-blue">
                <div class="panel-title-text">
                    <i class="fa-solid fa-user-plus"></i> &nbsp;Nuevo Usuario
                </div>
            </div>
            <div class="panel-body-padded">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <div class="form-group-field">
                        <label class="form-label-small">Nombre Completo</label>
                        <input type="text" name="name" class="form-control-custom" required placeholder="Ej: Juan Pérez">
                    </div>
                    <div class="form-group-field">
                        <label class="form-label-small">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control-custom" required placeholder="usuario@portatilesperu.pe">
                    </div>
                    <div class="form-group-field">
                        <label class="form-label-small">Rol</label>
                        <select name="role" class="form-control-custom">
                            <option value="admin">Administrador (Admin)</option>
                            <option value="operator" selected>Operador / Ventas</option>
                        </select>
                    </div>
                    <div class="form-group-field">
                        <label class="form-label-small">Contraseña</label>
                        <input type="password" name="password" class="form-control-custom" required minlength="6" placeholder="Mínimo 6 caracteres">
                    </div>
                    <button type="submit" class="btn-generate-submit">
                        <i class="fa-solid fa-check"></i> &nbsp;Crear Usuario
                    </button>
                </form>
            </div>
        </div>

        <!-- Card Lista de Usuarios -->
        <div class="panel-card">
            <div class="panel-header-blue flex-between">
                <div class="panel-title-text">
                    <i class="fa-solid fa-users"></i> &nbsp;Lista de Usuarios del Sistema
                </div>
                <a href="{{ route('dashboard') }}" class="btn-header-pill">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
            <div class="panel-table-wrap">
                <table class="data-table-custom">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                            <tr>
                                <td><strong>{{ $u->name }}</strong></td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if($u->role === 'admin')
                                        Admin
                                    @elseif($u->role === 'vendedor')
                                        Vendedor
                                    @elseif($u->role === 'soporte')
                                        Soporte
                                    @else
                                        {{ ucfirst($u->role) }}
                                    @endif
                                </td>
                                <td><span class="status-pill-active">Activo</span></td>
                                <td>{{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <div class="table-actions-row">
                                        <form method="POST" action="{{ route('users.destroy', $u) }}" class="form-inline-delete" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-tbl-action text-red" title="Eliminar">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
