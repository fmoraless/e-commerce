@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Configuraciones</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin Settings</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Actualizar password</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post" action="{{ url('/admin/update-pwd') }}"
                              name="updatePasswordForm" id="updatePasswordForm">@csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input class="form-control" value="{{ $adminDetails->name }}"
                                    placeholder="Ingresa un nombre de usuario" id="admin_name" name="admin_name">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input readonly class="form-control" value="{{ $adminDetails->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tipo usuario</label>
                                    <input readonly class="form-control" value="{{ $adminDetails->type }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Actual Password</label>
                                    <input type="password" class="form-control" id="current_pwd" name="current_pwd"
                                           placeholder="Ingrese Password actual">
                                    <span id="chkCurrentPassword"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nueva Password</label>
                                    <input type="password" class="form-control" iid="new_pwd" name="new_pwd"
                                           placeholder="Ingrese nuevo Password">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirmar Password</label>
                                    <input type="password" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Confirmar Password">
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endsection
