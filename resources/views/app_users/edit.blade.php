@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            App User
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($appUser, ['route' => ['appUsers.update', $appUser->id], 'method' => 'patch']) !!}

                        @include('app_users.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection