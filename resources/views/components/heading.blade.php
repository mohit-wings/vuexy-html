@if (isset($add_modal))            

    <a class="btn btn-primary btn-sm float-right call-model mr-1" 
            data-target-modal="{{ $add_modal->get('target') }}" 
            data-url="{{ $add_modal->get('action' , 'javaqscrip:void(0)') }}"
            href="{{ $add_modal->get('action' , 'javaqscrip:void(0)') }}">
                <i class="fa fa-plus"></i>&nbsp;
                
                {{ $add_modal->get('btn_name' ,'' ) }}
              
            </a> 
@endif