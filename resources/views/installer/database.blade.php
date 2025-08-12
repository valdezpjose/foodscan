@extends('installer.layouts.master')

@section('template_title')
    {{ trans('installer.database.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer.database.title') }}
@endsection

@section('container')
    <ul class="installer-track">
        <li onclick="handleLinkForInstaller('{{ route('installer.index') }}')" class="done"><i class="fa-solid fa-house"></i></li>
        <li onclick="handleLinkForInstaller('{{ route('installer.requirement') }}')" class="done"><i class="fa-solid fa-server"></i></li>
        <li onclick="handleLinkForInstaller('{{ route('installer.permission') }}')" class="done"><i class="fa-sharp fa-solid fa-unlock"></i></li>
        <li onclick="handleLinkForInstaller('{{ route('installer.license') }}')" class="done"><i class="fa-solid fa-key"></i></li>
        <li onclick="handleLinkForInstaller('{{ route('installer.site') }}')" class="done"><i class="fa-solid fa-gear"></i></li>
        <li class="active"><i class="fa-solid fa-database"></i></li>
        <li><i class="fa-solid fa-unlock-keyhole"></i></li>
    </ul>

    <span class="my-6 w-full h-[1px] bg-[#EFF0F6]"></span>

    {{-- Error global (ej. problema de conexión) --}}
    @if($errors->has('global'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-5 rounded">
            {{ $errors->first('global') }}
        </div>
    @endif

    <form method="POST" action="{{ route('installer.databaseStore') }}">
        @csrf

        {{-- Host --}}
        <div class="mb-4">
            <label class="block mb-1.5">{{ trans('installer.database.label.database_host') }} *</label>
            <input name="db_host"
                   type="text"
                   value="{{ old('db_host', 'db') }}"
                   class="w-full h-12 rounded-lg px-4 border {{ $errors->has('db_host') ? 'border-red-500' : 'border-[#D9DBE9]' }}">
            @error('db_host')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Port --}}
        <div class="mb-4">
            <label class="block mb-1.5">{{ trans('installer.database.label.database_port') }} *</label>
            <input name="db_port"
                   type="text"
                   value="{{ old('db_port', '3306') }}"
                   class="w-full h-12 rounded-lg px-4 border {{ $errors->has('db_port') ? 'border-red-500' : 'border-[#D9DBE9]' }}">
            @error('db_port')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Name --}}
        <div class="mb-4">
            <label class="block mb-1.5">{{ trans('installer.database.label.database_name') }} *</label>
            <input name="db_name"
                   type="text"
                   value="{{ old('db_name', env('DB_DATABASE', 'foodscan')) }}"
                   class="w-full h-12 rounded-lg px-4 border {{ $errors->has('db_name') ? 'border-red-500' : 'border-[#D9DBE9]' }}">
            @error('db_name')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Username --}}
        <div class="mb-4">
            <label class="block mb-1.5">{{ trans('installer.database.label.database_username') }} *</label>
            <input name="db_username"
                   type="text"
                   value="{{ old('db_username', env('DB_USERNAME', 'foodscan_user')) }}"
                   class="w-full h-12 rounded-lg px-4 border {{ $errors->has('db_username') ? 'border-red-500' : 'border-[#D9DBE9]' }}">
            @error('db_username')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        {{-- Password --}}
        <div class="mb-8">
            <label class="block mb-1.5">{{ trans('installer.database.label.database_password') }} </label>
            <input name="db_password"
                   type="password"
                   value="{{ old('db_password', env('DB_PASSWORD', 'secret')) }}"
                   class="w-full h-12 rounded-lg px-4 border {{ $errors->has('db_password') ? 'border-red-500' : 'border-[#D9DBE9]' }}">
            @error('db_password')
                <small class="text-red-500">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit"
                class="mx-auto block px-6 py-3 bg-primary text-white rounded-lg">
            {{ trans('installer.database.next') }}
        </button>
    </form>
@endsection
