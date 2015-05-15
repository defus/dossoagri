<?php
/**
 * login.blade.php 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */
?>
{{-- Page template --}}
@extends('templates.login')

{{-- Page title --}}
@section('title') Authentification @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
    
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')

@stop

{{-- Page content --}}
@section('content')

<div class="container">
    <div class="row" style="margin-top:10%">
        <div class="col-md-8">
            <div class="jumbotron" >
                <h1 class="text-center" style="margin-top: 10%">DOSSO Agriculture</h1>
                <div class="row">
                    <div class="col-md-6">
                        <img src="/assets/images/dossoagri-logo.png" class="img-responsive" alt="Dosso Agriculture" />
                    </div>
                    <div class="col-md-6">
                        <img src="/assets/images/cipmen.png" class="img-responsive" alt="Logo Organisateur du Hackathon" />
                    </div>
                </div>
                <p class="lead text-center">Plateforme d'échange entre les agriculteurs, les acheteurs et les pouvoirs publiques</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Veuillez vous connecter</h3>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('url' => Request::url() , 'id' => 'login',  'role' => 'form' )) }}
                        <fieldset>
                            <div class="form-group">
                                {{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Login', 'autofocus' => '' ) ) }}
                                {{ $errors->first('email') }}
                            </div>
                            <div class="form-group">
                                {{ Form::password('password', array('class' => 'form-control', 'placeholder'=>'Mot de passe') ) }}
                                {{ $errors->first('password') }}
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Se souvenir de moi
                                </label>
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            {{ Form::submit('Connection', array('class'=>'btn btn-lg btn-success btn-block')) }}
                        </fieldset>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@stop