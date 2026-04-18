<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('home') }}" class="brand-link">
        <img src="{{ url('backend/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">@if(Auth::check()) {{ Auth::user()->name }}@endif</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel" style="text-align: center!important;">
            <div class="info"  style="display: block">
                @if(Auth::check())
                @if(!empty(Auth::user()->getRoleNames()))
                    @foreach (Auth::user()->getRoleNames() as $roleName)
                        <button type="button" class="btn btn-block btn-warning btn-xs">{{ $roleName }}</button>
                    @endforeach
                @endif
                @endif

            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon  fas fa-th"></i>
                        <p>
                            Dashboard

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            OPD
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('opd') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Register Patient</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('oldOpd') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Old OPD Patient</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Patients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('patients.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Patients List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('searchPatientByReg') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search By Reg. Date</p>
                            </a>
                        </li>
                    </ul>
                </li>
              	@can('list-Expense')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Expenses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('expenses.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('expenses.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Expense</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ecat.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Expense Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ecat.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense Categories</p>
                            </a>
                        </li>

                    </ul>
                </li>
              @endcan
              @can('Hide-Patients')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Hide Patients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('listPatients') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Search Patients</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hiddenPatientsLists') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hidden Patients</p>
                            </a>
                        </li>
                    </ul>
                </li>
              @endcan
                @role('owner|Super-Admin|DIRECTOR')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Roles & Permissions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('roles.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Role</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('permissions.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('permissions.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Permission</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add User</p>
                            </a>
                        </li>

                    </ul>
                </li>
                @endrole
                   <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            invoices
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('invoices.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>invoice</p>
                            </a>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Branches
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('branches.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Branch List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('branches.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Branch</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Payment Modes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('modes.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Payment Modes List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('modes.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Payment Modes</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('discontinued') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Tele Calling
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Service Types
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('servicetypes.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Service Type List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('servicetypes.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Service Type</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('collectionReport') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Collection Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('collectionReportCustom') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Custom Range Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('expenseReport') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('expenseReportsCustom') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense Custom Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('refundReport') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Refund Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dueReport') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Due's Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customDailyReport') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Custom Daily Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('rangeDailyReport') }}" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Custom Range Report

                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Website Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.sliders.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sliders Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.IndexContact') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Contact Messages</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('settings') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Base Settings</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>
                            Log Out
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
