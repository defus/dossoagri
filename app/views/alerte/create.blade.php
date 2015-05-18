<?php
/**
 * login.blade.php 
 * {File description}
 * 
 * @author alompo
 * @created May 2015
 * 
 */
?>
{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Ajouter une récolte @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
{{ HTML::style('assets/select2-3.5.2/select2.css') }}
{{ HTML::style('assets/select2-3.5.2/select2-bootstrap.css') }}
{{ HTML::style('assets/jquery-ui-1.11.2/themes/base/all.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/select2-3.5.2/select2.min.js') }}
{{ HTML::script('assets/select2-3.5.2/select2_locale_fr.js') }}
{{ HTML::script('assets/jQuery-Mask-Plugin-1.11.2/dist/jquery.mask.min.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/core.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/widget.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/datepicker.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/demos/datepicker/datepicker-fr.js') }}
<script>
$(document).ready(function() {
    $('#DateCreation').datepicker( $.datepicker.regional["fr"]);
   
    
    function repoEvenementFormatResult(repo) {
      repo.id = repo.EvenementID;
      var markup = '<div class="row">' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Nom : ' + repo.Nom + '</div>' +
           '<div class="col-lg-3"><i class="fa fa-code-fork"></i> Description : ' + repo.Description + '</div>' +
        '</div>';

      return markup;
    }

    function repoEvenementFormatSelection(repo) {
      return 'Nom : ' + repo.Nom + ' - Description : ' + repo.Description;
    }

    $('#EvenementID').select2({
        placeholder: "Rechercher un evenement",
        minimumInputLength: 1,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: "{{ URL::to('evenement/select2/ajax') }}",
            dataType: 'json',
            quietMillis: 250,
            data: function (term, page) {
                return {
                    q: term, // search term
                    page: page
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter the remote JSON data
                var more = (page * 10) < data.recordsFiltered;
                return { results: data.data, more: more };
            },
            cache: true
        },
        formatResult: repoEvenementFormatResult, 
        formatSelection: repoEvenementFormatSelection,  
        dropdownCssClass: "bigdrop", 
        escapeMarkup: function (m) { return m; },
        id : function(obj){
            return obj.EvenementID;
        } 
    });

});
</script>
@stop

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ajouter une alerte </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                     Merci de remplir le formulaire ci-dessous
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ( $errors->count() > 0 )
                                @foreach( $errors->all() as $message )
                                    <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                @endforeach
                            @endif
                            {{ Form::open(array('url' => URL::to('alerte') , 'role' => 'form')) }}
                                
                                <div class="form-group">
                                    <label>Evenement *</label>
                                    <input type="hidden" class="bigdrop form-control" id="EvenementID" name="EvenementID" value="{{Input::old('EvenementID')}}" />
                                </div>
                               
                                <div class="form-group @if($errors->first('Finperiode') != '')) has-error @endif">
                                    <label>Date de creation *</label>
                                    <input type="text" name="DateCreation" id="DateCreation" value="{{Input::old('DateCreation')}}" class="form-control">
                                    {{ $errors->first('DateCreation', '<span class="error">:message</span>' ) }}
                                </div>
                                <div class="form-group @if($errors->first('Message') != '') has-error @endif">
                                    <label>Message *</label>
                                    {{ Form::text('Message', Input::old('Message'), array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('Message', '<span class="error">:message</span>' ) }}
                                </div>
                                
                                {{ Form::submit('Enregistrer', array('class'=>'btn btn-primary')) }}
                                {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                            {{ Form::close() }}
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@stop