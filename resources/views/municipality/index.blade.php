@extends('layouts.app')

@section('template_title')
    Municipality
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
<style>
    @font-face {
        font-family: Metropolis-Bold;
        src: url('{{ URL::asset("fonts/Metropolis-Bold.ttf") }}'); /* Corregido el formato.ttf */
    }
</style>
<br>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8"style=" justify-content: center;">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Municipality') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('municipality.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success m-4">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body bg-white">
                        <div class="table-responsive">
                            <table id="municipio" class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Name</th>
										<th>Departaments Id</th>
									

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($municipalities as $municipality)
                                        <tr>
                                          <td>{{ $loop->iteration }}</td>

                                            
											<td>{{ $municipality->name }}</td>
											<td>{{ $municipality->departament->name }}</td>
										

                                            <td>
                                             {{--     <form action="{{ route('municipality.destroy',$municipality->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('municipality.show',$municipality->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('municipality.edit',$municipality->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>  --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.21/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#municipio').DataTable({
                // Configuración de DataTables
            });
        });
    
        function toggleSaleStatus(routeId, status) {
            // Función toggleSaleStatus
        }
    </script>


 

@endsection