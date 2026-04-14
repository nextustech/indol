@extends('layouts.backend')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">

                <h6>Branches</h6>
                <div class="row">

                    @if(count($branches) < 5)
                       <?php  $mdNo = 12 / (count($branches)); ?>
                    @endif
                    @if(count($branches) == 5)
                       <?php  $mdNo = 4 ?>
                    @endif
                    @foreach( $branches as $branch )
                        <div class="col-md-{{$mdNo}}">
                            <a href="{{ route('todayBranchDetails',$branch->id) }}">
                            <div class="callout callout-success">
                                <h5>{{ $branch->branchName }}</h5>
                                <p>{{ $branch->address }}</p>
                            </div>
                            </a>
                        </div>
                    @endforeach
                </div>
          		@can('PatientCollectionView') 
                @foreach( $serviceTypes->chunk(4) as $serviceTypeChunk )
                <div class="row">


                    @foreach( $serviceTypeChunk as $serviceType )
                        <div class="col-md-3">
                            <a href="{{ route('serviceDetail',$serviceType->id) }}">
                            <div class="callout callout-success">
                                <h6>{{ $serviceType->name }}</h6>
                                <p>{{ $serviceType->collections->count() }}</p>
                            </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @endforeach
         		@include('home.paymentsModes')
                @can('showInfoBoxes')
                @include('home.infoBoxes')
                @endcan
                @include('home.newPatients')
          		@endcan
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0">Package Due For Renewal</h5>
                            </div>

                            <div class="card-body">
                                @include('errors.list')
                                @if (Session::has('message'))
                                    <div class="alert alert-success text-center">{{ session('message') }}</div>
                                @endif
                                <div class="table-responsive">
                                    <table class="table card-table table-vcenter text-nowrap">
                                        <thead  class="bg-primary text-white">
                                        <tr >
                                            <th class="text-white">Date</th>
                                            <th class="text-white">Branch</th>
                                            <th class="text-white">Patient Name</th>
                                            <th class="text-white">Package</th>
                                            <th class="text-white">Duration</th>
                                            <th class="text-white">Attended</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php $sum =0; ?>
                                        @foreach( $activePackages as $activePackage )
                                              @if(($activePackage->schedules->count('sittingDate') - $activePackage->schedules->where('attendedAt','!=',Null)->count()) < 11 &&  $activePackage->schedules->where('attendedAt','==',Null)->count() > 0 )

                                                <tr>
                                                    @if($activePackage)
                                                        <td>
                                                                <?php
                                                                $source = $activePackage->schedules->max('sittingDate');
                                                                $date = new DateTime($source);
                                                                ?>
                                                            {{ $date->format(" j M y") }}

                                                        </td>
                                                        <td>{{ $activePackage->branch->branchName }}</td>

                                                        <td>
                                                            @if($activePackage->patient)
                                                                <a href="{{ route('patients.show',$activePackage->patient) }}" data-toggle="tooltip" data-placement="top" title="{{ $activePackage->patient->diagnosis }}">
                                                                    {{ ucfirst($activePackage->patient->name) }} </a>

                                                            @else
                                                                Patient Removed Or N.A
                                                            @endif
                                                        </td>
                                                        <td>

                                                            {{ $activePackage->title }}

                                                        </td>
                                                        <td> {{ $activePackage->schedules->count('sittingDate') }}</td>
                                                        <td>{{ $activePackage->schedules->where('attendedAt','!=',Null)->count() }}</td>
                                                    @endif
                                                </tr>
                                                    <?php $sum = $sum+$activePackage->amount ?>
                                            @endif

                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <!-- /.card-body -->

                        </div>


                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
