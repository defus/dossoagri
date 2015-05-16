@extends('templates.normal')

{{-- Page title --}}
@section('title') Liste des zones de  cultures @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<!-- DataTables CSS -->
{{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
{{ HTML::style('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/css/dataTables.tableTools.min.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/js/plugins/dataTables/extensions/TableTools-2.2.3/js/dataTables.tableTools.min.js') }}
<script>
$(document).ready(function() {
    $('#dataTables-example').dataTable({
        "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "{{ URL::to('/')}}/assets/js/plugins/dataTables/extensions/TableTools-2.2.3/swf/copy_csv_xls_pdf.swf"
        },
        "language": {
            "url": "{{ URL::to('/')}}/assets/js/plugins/dataTables/French.lang"
        }
    });
    
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
@endsection

{{-- Page content --}}

@section('content')
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Zone de Cultures <a href="{{ URL::to('culturezone/new') }}" class="btn btn-primary pull-right">Ajouter une zone de culture</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des zones de cultures
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <!-- Success-Messages -->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    
                                    <th>Nom</th>
                                    <th>Coordonnees</th>
                                     <th>Periodes de Culture</th>
                                    <th>Description</th>
                                    <th class="no-sort" style="width:17px;min-width:75px;max-width:75px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($culturezones as $key => $value)
                                <tr>
                                     <td>{{$value->name}}</td>
                                     <td>{{$value->longitude}} <br> {{$value->latitude}} <br><a href="#" data-toggle="tooltip" data-html="true" data-placement="right" title="afficher la carte"><i class="fa fa-map-marker fa-2"></i></a></td>
                                    <td class="col-md-6">
                                        <ul>
                                        @foreach($value->CultureZonePeriods as $periodkey => $periodvalue)
                                           <li><strong>{{$periodvalue->Culture->name}}</strong> &nbsp;&nbsp;&nbsp;&nbsp; [ <strong>{{ date("d M Y",strtotime($periodvalue->from))}}</strong> &agrave; <strong>{{ date("d M Y",strtotime($periodvalue->to))}}</strong>] </li>
                                        @endforeach
                                        </ul>
                                        
                                    </td>
                                    <td>{{$value->description}}</td>
                                    <td nowrap="nowrap">
                                        <a href="{{ URL::to('culturezone/' . $value->id .'/modify') }}" class="btn btn-sm btn-success"> <i class="fa fa-edit"></i> </a>&nbsp;
                                        {{ Form::open(array('url' => 'culturezone/' . $value->id, 'class' => 'pull-right')) }}
                                            {{ Form::hidden('_method', 'DELETE') }}
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        {{ Form::close() }}
                                      </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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

@endsection
