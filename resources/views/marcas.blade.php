@extends('layout')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h1>Marcas</h1>
    </div>
  </div>
  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 offset-md-4">
                <div class="form-group m-t-20">
                  <button type="button" data-toggle="modal" data-target="#addMarca" class="btn btn-success w-100 btn-aligned">Agregar marca</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div id="marcasRow" class="row d-none">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id ="marcasTable" class="table table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Activa</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<form id="addMarcaForm">
  <div id="addMarca" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Agregar marca</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group m-t-20">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre de la marca" required>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Agregar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</form>
<form id="editMarcaForm">
  <div id="editMarca" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar marca</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editId" name="marca_id" value="">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group m-t-20">
                <label>Nombre</label>
                <input type="text" class="form-control" id="editNombre" name="nombre" placeholder="Nombre de la marca" required>
              </div>
              <div class="form-group m-t-20">
                <label>Activa</label>
                <input type="checkbox" id="editActiva" name="activa" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Actualizar</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
@push('scripts')
<script src="/js/marcas.js"></script>
@endpush
