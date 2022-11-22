
@include('crud::fields.inc.wrapper_start')

<div class="row" id="options_row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary p-2">Options</div>
            <div class="card-body p-0  m-2">

                @if(isset($entry))
                    @foreach($entry->questionOptions()->orderBy('created_at')->get() as $op)
                    <div class="col-md-12 pt-2">
                        <input class="form-control" type="text" name="options[{{$op->id}}]" value="{{$op->title}}">
                    </div>
                    @endforeach
                    <div class="form-row" id="options">
                
                        <div class="col-md-12 pt-2">
                            <input class="form-control" type="text" name="options[]">
                        </div>
                        
                    </div> 
                @else

                <div class="form-row" id="options">
                
                    <div class="col-md-12 pt-2">
                        <input class="form-control" type="text" name="options[]">
                    </div>
                    
                </div> 
                @endif
        </div>
        <div class="row ml-1 mb-2">
            <a class="btn btn-sm btn-primary text-white" id="add_new_option_row" role="button"><i class="la la-plus text-white"></i>Add new</a>
        </div>
    </div>
</div>
@include('crud::fields.inc.wrapper_end')

@push('after_scripts')
<script>
    $(document).ready(function(){
        let i = 0;
        //for new row
        $('#add_new_option_row').click(function(){
            i += 1;
            let form = document.getElementById('options');
            let clone = form.cloneNode(true);
            // clone.id = "sub_questions" + i;
            $(clone).find("input").val("");
            form.parentNode.appendChild(clone);
        });
    });
</script>
@endpush
