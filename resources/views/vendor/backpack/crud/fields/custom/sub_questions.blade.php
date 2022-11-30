
@include('crud::fields.inc.wrapper_start')

<div class="row" id="sub_questions_row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header text-dark bg-secondary p-2"><i class="fa fa-hospital-o" aria-hidden="true"></i> SUB-QUESTIONS</div>
            <div class="card-body p-0  m-2">

                @if(isset($entry))
                    @foreach($entry->subQuestions()->orderBy('display_order')->get() as $sub)
                    <div class="form-row">
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Serial</label>
                            <input class="form-control" type="text" name="sub_questions[serial][{{$sub->id}}]" value="{{$sub->serial}}">
                        </div>
                        <div class="col-md-8 pt-2 d-inline-flex">
                            <label class="pr-2">Title</label>
                            <input class="form-control" type="text" name="sub_questions[title][{{$sub->id}}]" value="{{$sub->title}}">
                        </div>
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Order</label>
                            <input class="form-control" type="number" name="sub_questions[display_order][{{$sub->id}}]" value="{{$sub->display_order}}" min="0">
                        </div>
                    </div> 
                    @endforeach
                    <div class="form-row" id="sub_questions">
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Serial</label>
                            <input class="form-control" type="text" name="sub_questions[serial][]">
                        </div>
                        <div class="col-md-8 pt-2 d-inline-flex">
                            <label class="pr-2">Title</label>
                            <input class="form-control" type="text" name="sub_questions[title][]">
                        </div>
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Order</label>
                            <input class="form-control" type="number" name="sub_questions[display_order][]" min="0" value="0">
                        </div>
                    </div> 
                @else

                <div class="form-row" id="sub_questions">
                
                    <div class="col-md-2 pt-2 d-inline-flex">
                        <label class="pr-2">Serial</label>
                        <input class="form-control" type="text" name="sub_questions[serial][]">
                    </div>
                    <div class="col-md-8 pt-2 d-inline-flex">
                        <label class="pr-2">Title</label>
                        <input class="form-control" type="text" name="sub_questions[title][]">
                    </div>
                    <div class="col-md-2 pt-2 d-inline-flex">
                        <label class="pr-2">Order</label>
                        <input class="form-control" type="number" name="sub_questions[display_order][]" min="0" value="0">
                    </div>
                    
                </div> 
                @endif
        </div>
        <div class="row ml-1 mb-2">
            <a class="btn btn-sm btn-primary text-white" id="add_new_row" role="button"><i class="la la-plus text-white"></i>Add new</a>
        </div>
    </div>
</div>
@include('crud::fields.inc.wrapper_end')

@push('after_scripts')
<script>
    $(document).ready(function(){
        let i = 0;
        //for new row
        $('#add_new_row').click(function(){
            i += 1;
            let form = document.getElementById('sub_questions');
            let clone = form.cloneNode(true);
            $(clone).find("input[type=text]").val("");
            form.parentNode.appendChild(clone);
        });
    });
</script>
@endpush
