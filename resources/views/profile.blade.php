@extends('layouts.backend')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content mt-2">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../../dist/img/user4-128x128.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Nina Mcintire</h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card card-primary card-outline">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body" style="padding: .25rem; font-size:12px;">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <table class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Pakage</th>
                            <th>Days</th>
                            <th>Amount</th>
                            <th>Paid(Dis.)</th>
                            <th>Balance</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td>Approved</td>
                            <td>Bacon ipsum dolor</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td>Approved</td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="8">
                              <p>
                                Lorem Ipsum is simply dummy
                              </p>
                            </td>
                          </tr>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td>Approved</td>
                            <td>Bacon ipsum dolor</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td>Approved</td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="8">
                                <div class="row">
                                    <div class="col-md-1">all</div>
                                    <div class="col-md-2">all</div>
                                    <div class="col-md-3">Two</div>
                                    <div class="col-md-3">Three</div>
                                    <div class="col-md-3">four</div>

                                </div>
                            </td>
                          </tr>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td>183</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td>Approved</td>
                            <td>Bacon ipsum dolor</td>
                            <td>John Doe</td>
                            <td>11-7-2014</td>
                            <td>Approved</td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="8">
                              <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                              </p>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    timeline
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    settings
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
