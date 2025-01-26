@extends('admin.layout.app')


@section('main-content')
    <div class="content-page">
        <div class="container-fluid add-form-list">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">General Settings</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    @include('admin.settings.include.basic_info')

                                    @include('admin.settings.include.social_links')
                                </div>
                                <div class="col-sm-12 col-lg-6">
                                    @include('admin.settings.include.logo_info')
                                    @include('admin.settings.include.company_info')
                                    @include('admin.settings.include.bank_info')
                                </div>
                            </div>
                            <x-shared.editor-form-layout type="about" :settings="$settings ?? ''" />
                            <x-shared.editor-form-layout type="privacy" :settings="$settings ?? ''" />
                            <x-shared.editor-form-layout type="terms" :settings="$settings ?? ''" />

                        </div>
                    </div>
                </div>
            </div>
            <!-- Page end  -->
        </div>
    </div>
@endsection

@php
    if ($errors->any()) {
        foreach ($errors->all() as $error) {
            toastr()->error($error);
        }
    }
@endphp
