@extends(backpack_view('layouts.top_left'))
@section('content')
<style>
.label>label{
    width:150px !important;
    color:black;
    padding-left:10px; 
}
.label-1>label{
    width:180px !important;
    color:black;
    padding-left:10px; 
}
.option-label>label{
    padding-left:10px;
    color:black;
}
</style>
<div class="card">
    <div class="card-header p-1 d-inline-block" style="background-color: rgb(43, 208, 223)">
        <span class="font-weight-bold"><i class="la la-plus" aria-hidden="true"></i>&nbsp; Create New Entry</span>
    </div>
    <div class="card-body p-2">
        <div class="form-row">
            <div class="col d-inline-flex label">
                <label for="program_name">Program</label>
                :&ensp;<input class="form-control" type="text" id="program_id" name="review_profile_id" value="{{$program_name}}" readonly>
            </div>
            <div class="col d-inline-flex label">
                <label for="school_name">School</label>
                :&ensp;<input class="form-control" type="text" id="school_id" name="school" value="{{$school_name}}" readonly>
            </div>
        </div>
        <div class="form-row mt-2">
            <div class="col d-inline-flex label">
                <label for="subject">Subject</label>
                :&ensp;<input class="form-control" type="text" id="subject" name="subject" value="{{$subject_name}}" readonly>
            </div>
            <div class="col d-inline-flex label">
                <label for="class">Class</label>
                :&ensp;<input class="form-control" type="text" id="class_id" name="class" value="{{$class}}" readonly>
            </div>
        </div>
        <hr class="hr-line m-2">

        <div class="form-row mt-4">
            <div class="col-md-5 d-inline-flex label-1">
                <label for="student_name" class="_required pr-1">Student Name</label>
                :&nbsp;<input class="form-control" type="text" id="student_name" name="student_name">
            </div>
            <div class="col d-inline-flex">
                <label for="gender" class="_required pr-2">Gender</label>
                :&nbsp;<select class="form-control" name="gender" id="gender" style="width: 100%;">
                    <option class="text-mute" selected disabled value=""> -- Select Gender --</option>
                    @foreach($gender as $g)
                    <option class="form-control" value="{{ $g->id }}">{{ $g->name_lc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-inline-flex">
                <label for="age" class="_required mr-2">Age</label>
                :&nbsp;<input class="form-control text-right" type="number" id="age" name="age" min="0" value="0">
            </div>
            <div class="col d-inline-flex">
                <label for="language" class="_required mr-2">Language</label>
                :&nbsp;<input class="form-control" type="text" id="language" name="language">
            </div>
        </div>
        <hr class="hr-line m-2">

        <div class="row mt-3">
            <div class="col-md-12">
                @foreach($question_groups as $key=>$group)
                    <div class="text-center font-weight-bold text-primary" style="text-decoration: underline;">{{$key}}</div>
                    @foreach($group as $item)
                        <div class="row ml-5">
                            <div class="col-md-12">
                                <div class="form-row py-2">
                                    <div class="col text-black font-weight-bold"><span>Q.</span>{{$item->question_no}}</div>
                                    @foreach($item->questionOptions as $option)
                                        <div class="col option-label">
                                            <input type="checkbox" id="option-{{$option->id}}" name="option[{{$option->id}}]">
                                            <label for="option-{{$option->id}}">{{$option->title}}</label><br>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                @endforeach
            </div>
        
        </div>
    </div>
</div

@endsection