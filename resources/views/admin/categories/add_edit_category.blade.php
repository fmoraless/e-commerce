@extends('layouts.admin_layout.admin_layout')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Catálogo</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Category Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form name="categoryForm" id="categoryForm" @if(empty( $categorydata['id'])) action="{{ url('admin/add-edit-category') }}" @else
                action="{{ url('admin/add-edit-category/'.$categorydata['id']) }}" @endif method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- SELECT2 EXAMPLE -->
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">Nombre Categoría</label>
                                        <input type="text" class="form-control" id="category_name" name="category_name"
                                               placeholder="Nombre categoría"
                                            @if(!empty($categorydata['category_name'])) value="{{ $categorydata['category_name'] }}"
                                            @else value="{{ old('category_name') }}"
                                            @endif
                                        >
                                    </div>
                                    <div id="appendCategoriesLevel">
                                        @include('admin.categories.append_categories_level')
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Seleccione sección</label>
                                        <select id="section_id" name="section_id" class="form-control select2" style="width: 100%;">
                                            <option selected="selected">Seleccione</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section->id }}"
                                                    @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id)
                                                        selected
                                                    @endif
                                                >{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputFile">Imágen de categoría</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="category_image" name="category_image">
                                                <label class="custom-file-label" for="category_image">Seleccione archivo</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="category_discount">Descuento Categoría</label>
                                        <input type="text" class="form-control" id="category_discount" name="category_discount" placeholder="Descuento"
                                            @if(!empty($categorydata['category_discount'])) value="{{ $categorydata['category_discount'] }}"
                                               @else value="{{ old('category_discount') }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Enter ..."
                                        >@if(!empty($categorydata['description'])) {{ $categorydata['description'] }}
                                            @else {{ old('description') }}
                                            @endif
                                        </textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="url">URL Categoría</label>
                                        <input type="text" class="form-control" id="url" name="url" placeholder="url categoría"
                                            @if(!empty($categorydata['url'])) value="{{ $categorydata['url'] }}"
                                                @else value="{{ old('url') }}"
                                            @endif
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_title">Meta title</label>
                                        <textarea id="meta_title" name="meta_title" class="form-control" rows="3" placeholder="Enter ..."
                                        >@if(!empty($categorydata['meta_title'])) {{ $categorydata['meta_title'] }}
                                            @else {{ old('meta_title') }}
                                            @endif
                                        </textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea id="meta_description" name="meta_description" class="form-control" rows="3" placeholder="Enter ..."
                                        >@if(!empty($categorydata['meta_description'])) {{ $categorydata['meta_description'] }}
                                            @else {{ old('meta_description') }}
                                            @endif
                                        </textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea id="meta_keywords" name="meta_keywords" class="form-control" rows="3" placeholder="Enter ..."
                                            >@if(!empty($categorydata['meta_keywords'])) {{ $categorydata['meta_keywords'] }}
                                                 @else {{ old('meta_keywords') }}
                                             @endif
                                        </textarea>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
