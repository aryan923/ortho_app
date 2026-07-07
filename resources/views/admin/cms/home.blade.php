@extends('layouts.app')

@section('title', $currentPageLabel . ' | Page CMS | OrthoCore Clinic')

@include('admin.cms.styles')

@section('content')
<div class="admin-page">
    <div class="wrap admin-shell">
        @include('partials.admin-sidebar')

        <div class="admin-content">
            @include('admin.cms.form')
        </div>
    </div>
</div>
@endsection
