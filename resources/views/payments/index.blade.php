@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <div class="content mt-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">All Patients</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table card-table table-vcenter text-nowrap table-primary">
                                        <thead  class="bg-primary text-white">
                                        <tr >
                                            <th class="text-white">S.No.</th>
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Patient Name</th>
                                            <th class="text-white">Package</th>
                                          	<th class="text-white">Mode</th>
                                            <th class="text-white">Amount</th>
                                            <th class="text-white">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 1; ?>
                                        <?php $sum =0; ?>
                                        @foreach( $payment->collections as $collection )
                                            <tr>
                                                @if($collection)
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                            <?php
                                                            $source = $collection->collectionDate;
                                                            $date = new DateTime($source);
                                                            ?>
                                                        {{ $date->format(" j M y") }}

                                                    </td>
                                                    <td>
                                                        @if($collection->patient)
                                                            {{ ucfirst($collection->patient->name) }}
                                                        @else
                                                            Patient Removed Or N.A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($collection->pakage)
                                                            {{ ucfirst($collection->pakage->name) }}
                                                        @elseif($collection->payment->title)
                                                            {{ $collection->payment->title }}
                                                        @else
                                                            Pakage Deleted Or N.A
                                                        @endif
                                                    </td>
                                              		<td> {{ $collection->mode->name }} </td>
                                                    <td><i class="fa fa-inr"></i> {{ $collection->amount }}</td>
                                                    <td>
                                                        <a href="{{ route('collectionPrint',['id' => $collection->id]) }}" class="btn btn-success btn-sm">
                                                            <i class="fa fa-print"></i>
                                                        </a>
														@can('EditCollection')
          													<a href="{{ route('collection.edit',$collection->id) }}" class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                      	@endcan
                                                      @can('deleteCollection')
                                                            {{ Html()->form('DELETE')->route('collection.destroy', $collection->id)->style('display:inline')->open() }}
                                                            <button type="submit" class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                            {{ html()->form()->close() }}
                                                      @endcan

                                                    </td>
                                                @endif
                                            </tr>
                                                <?php $sum = $sum+$collection->amount ?>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td><b><i class="fa fa-inr"></i> {{ $sum }}</b></td>
                                            <td></td>
                                          <td></td>
                                          <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                        <a href="{{ route('patients.show',$collection->patient_id) }}" class="btn btn-success btn-block">
                                            Go To Patient Profile
                                        </a>
                            </div>
                            <!-- /.card-body -->

                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

