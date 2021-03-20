@extends('layout')
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h1>Productos</h1>
    </div>
  </div>
  <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-2 offset-md-1">
                <div class="form-group m-t-20">
                  <label>Clave</label>
                  <select id="clave" class="select2 form-control custom-select">
                    <option value="0">Todas</option>
                    @foreach ($claves as $clave)
                    <option value="{{$clave->clave}}">{{$clave->clave}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group m-t-20">
                  <label>Nombre</label>
                  <select id="nombre" class="select2 form-control custom-select">
                    <option value="0">Todos</option>
                    @foreach ($nombres as $nombre)
                    <option value="{{$nombre->nombre}}">{{$nombre->nombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group m-t-20">
                  <label>Marca</label>
                  <select id="marca" class="select2 form-control custom-select">
                    <option value="0">Todas</option>
                    @foreach ($marcas as $marca)
                    <option value="{{$marca->nombre}}">{{$marca->nombre}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group m-t-20">
                  <button type="button" id="filtrar" onclick="getProducts('filter')" class="btn btn-info w-100 btn-aligned">Filtrar</button>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group m-t-20">
                  <button type="button" data-toggle="modal" data-target="#addProduct" class="btn btn-success w-100 btn-aligned">Agregar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <div id="productsRow" class="row d-none">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id ="productsTable" class="table table-striped table-bordered w-100">
              <thead>
                <tr>
                  <th>Clave</th>
                  <th>Nombre</th>
                  <th>Marca</th>
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
<form id="addProductForm">
  <div id="addProduct" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Agregar producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group m-t-20">
                <label>Clave</label>
                <input type="text" class="form-control" name="clave" placeholder="Clave del producto" required>
              </div>
              <div class="form-group m-t-20">
                <label>Nombre</label>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre del producto" required>
              </div>
              <div class="form-group m-t-20">
                <label>Marca</label>
                <select class="select2 form-control custom-select" name="marca" required>
                  @foreach ($marcas as $marca)
                  <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                  @endforeach
                </select>
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
<form id="editProductForm">
  <div id="editProduct" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editId" name="product_id" value="">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group m-t-20">
                <label>Clave</label>
                <input type="text" class="form-control" id="editClave" name="clave" placeholder="Clave del producto" required>
              </div>
              <div class="form-group m-t-20">
                <label>Nombre</label>
                <input type="text" class="form-control" id="editNombre" name="nombre" placeholder="Nombre del producto" required>
              </div>
              <div class="form-group m-t-20">
                <label>Marca</label>
                <select class="select2 form-control custom-select" id="editMarca"  name="marca" required>
                  @foreach ($marcas as $marca)
                  <option value="{{$marca->id}}">{{$marca->nombre}}</option>
                  @endforeach
                </select>
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
<script src="/js/productos.js"></script>
@endpush
