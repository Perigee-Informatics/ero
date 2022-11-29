@extends(backpack_view('layouts.top_left'))
@section('content')

<div class="card">
    <div class="card-header p-1 d-inline-block" style="background-color: rgb(43, 208, 223)">
        <span class="font-weight-bold"><i class="la la-table" aria-hidden="true"></i>&nbsp; Assigned Lists</span>
    </div>
    <div class="card-body p-0">

        <div class="col">

            <table id="members_data_table" class="table table-bordered table-sm table-striped mr-2 pr-2 mt-3" style="background-color:#f8f9fa;">
                <thead>
                    <tr>
                        <th class="report-heading">S.N.</th>
                        <th class="report-heading th_large">Program</th>
                        <th class="report-heading th_large">School</th>
                        <th class="report-heading th_large">Subject</th>
                        <th class="report-heading th_large">Class</th>
                        <th class="report-heading th_large">Action</th>
                    </tr>
                </thead>
        
                <tbody>
                    @foreach($question_lists as $key=>$ql)
                        <tr>
                            <td class="report-data text-center">{{$loop->iteration}}</td>
                            <td class="report-data">{{$ql->reviewProfileEntity->program_name_lc}}</td>
                            <td class="report-data">{{isset($ql->school_id) ? $ql->schoolEntity->name_lc: ''}}</td>
                            <td class="report-data">{{\App\Models\MstClass::$subjects[$ql->subject]}}</td>
                            <td class="report-data">{{$ql->classEntity->code}}</td>
                            <td class="report-data text-center">
                                <a class="fancybox btn btn-success p-1 mr-2" data-type="ajax" data-src="{{'/public/member/'.$key.'/view-detailed-info'}} " title='View Detail'>
                                    <i class="la la-eye text-white font-weight-bold"></i>
                                </a>
                            </td>
                        </tr>
                    
                    @endforeach    
                </tbody>
            </table>
        </div>
    </div>
</div

@endsection