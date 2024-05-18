@extends('admin.layouts.app')

@section('content')


<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Invoices</h1>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <div class="input-group input-group" style="width: 250px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                      </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="60">total</th>
                            <th width="80">vat</th>
                            <th  width="80">payable</th>
                            <th width="100">cus_details</th>
                            <th  width="100">ship_details</th>
                            <th>tran_id</th>
                            <th>val_id</th>
                            <th>delivery_status</th>
                            <th>payment_status</th>
                            <th >user_id</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($invs->isNotEmpty())

                           @foreach ($invs as $inv )

                        <tr>
                            <td>{{  $inv->total }}</td>

                            <td><a href="#">{{ $inv->vat}}</a></td>
                            <td>{{  $inv->payable }}</td>
                            <td>{{  $inv->cus_details}}</td>
                            <td>{{$inv->ship_details }}</td>
                            <td>{{ $inv->tran_id }}</td>
                            <td>{{$inv->val_id}}</td>
                            <td>{{ $inv->delivery_status }}</td>
                            <td>{{$inv->payment_status }}</td>
                            <td>{{ $inv->user_id }}</td>



                        </tr>
                           @endforeach

                        @else
                            <tr>
                                <td>Records not found</td>
                            </tr>
                        @endif



                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                {{ $invs->links() }}


            </div>
        </div>
    </div>
    <!-- /.card -->
</section>


@endsection



