
@include('crud::fields.inc.wrapper_start')

<div class="row" id="options_row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary p-2">Options</div>
            <div class="card-body p-0  m-2">

                @if(isset($entry))
                    @foreach($entry->questionOptions()->orderBy('display_order')->get() as $op)
                    <div class="form-row">
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Serial</label>
                            <input class="form-control" type="text" name="options[serial][{{$op->id}}]" value="{{$op->serial}}">
                        </div>
                        <div class="col-md-8 pt-2 d-inline-flex">
                            <label class="pr-2">Title</label>
                            <input class="form-control" type="text" name="options[title][{{$op->id}}]" value="{{$op->title}}">
                        </div>
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Order</label>
                            <input class="form-control" type="number" name="options[display_order][{{$op->id}}]" value="{{$op->display_order}}" min="0">
                        </div>
                    </div> 
                    @endforeach
                    <div class="form-row" id="options">
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Serial</label>
                            <input class="form-control" type="text" name="options[serial][]">
                        </div>
                        <div class="col-md-8 pt-2 d-inline-flex">
                            <label class="pr-2">Title</label>
                            <input class="form-control" type="text" name="options[title][]">
                        </div>
                        <div class="col-md-2 pt-2 d-inline-flex">
                            <label class="pr-2">Order</label>
                            <input class="form-control" type="number" name="options[display_order][]" min="0" value="0">
                        </div>
                        
                    </div> 
                @else

                <div class="form-row" id="options">
                    <div class="col-md-2 pt-2 d-inline-flex">
                        <label class="pr-2">Serial</label>
                        <input class="form-control" type="text" name="options[serial][]">
                    </div>
                    <div class="col-md-8 pt-2 d-inline-flex">
                        <label class="pr-2">Title</label>
                        <input class="form-control" type="text" name="options[title][]">
                    </div>
                    <div class="col-md-2 pt-2 d-inline-flex">
                        <label class="pr-2">Order</label>
                        <input class="form-control" type="number" name="options[display_order][]" min="0" value="0">
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
            $(clone).find("input[type=text]").val("");
            form.parentNode.appendChild(clone);
        });
    });
</script>
@endpush
