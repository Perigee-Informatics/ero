@extends(backpack_view('layouts.top_left'))
@section('content')
<style>
.label>label{
    width:180px !important;
    color:black;
    padding-left:20px; 
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
                <input class="form-control" type="text" id="program_id" name="review_profile_id" value="{{$program_name}}" readonly>
            </div>
            <div class="col d-inline-flex label">
                <label for="school_name">School</label>
                <input class="form-control" type="text" id="school_id" name="school" value="{{$school_name}}" readonly>
            </div>
        </div>
        <div class="form-row mt-2">
            <div class="col d-inline-flex label">
                <label for="subject">Subject</label>
                <input class="form-control" type="text" id="subject" name="subject" value="{{$subject_name}}" readonly>
            </div>
            <div class="col d-inline-flex label">
                <label for="class">Class</label>
                <input class="form-control" type="text" id="class_id" name="class" value="{{$class}}" readonly>
            </div>
        </div>
        <hr class="hr-line m-2">

        <div class="form-row mt-4">
            <div class="col-md-5 d-inline-flex label">
                <label for="student_name" class="_required pr-1">Student Name</label>
                <input class="form-control" type="text" id="student_name" name="student_name">
            </div>
            <div class="col d-inline-flex">
                <label for="gender" class="_required pr-2">Gender</label>
                <select class="form-control" name="gender" id="gender" style="width: 100%;">
                    <option class="text-mute" selected disabled value=""> -- Select Gender --</option>
                    @foreach($gender as $g)
                    <option class="form-control" value="{{ $g->id }}">{{ $g->name_lc }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-inline-flex">
                <label for="age" class="_required mr-2">Age</label>
                <input class="form-control text-right" type="number" id="age" name="age" min="0" value="0">
            </div>
            <div class="col d-inline-flex">
                <label for="language" class="_required mr-2">Language</label>
                <input class="form-control" type="text" id="language" name="language">
            </div>
        </div>
        <hr class="hr-line m-2">

    </div>
</div

@endsection