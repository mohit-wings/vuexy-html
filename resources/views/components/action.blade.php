@if ($list_item)  
    <div class="btn-group">
        <a class="btn btn-sm dropdown-toggle hide-arrow" style="font-size: 20px;" data-toggle="dropdown">
            <i class="fas fa-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            @foreach ($list_item as $item)
                <a class="dropdown-item {{ $item->get('target',null) ? 'call-model' : '' }} {{ $item->get('class',null) }}" 
                    @if($item->get('target' ,null))
                        data-target-modal="{{ $item->get('target') }}" 
                    @endif
                    data-id={{ $item->get('id',null) }}  
                    data-url="{{ $item->get('action' , 'javaqscrip:void(0)') }}"
                    href="{{ $item->get('action' , 'javaqscrip:void(0)') }}" target={{ $item->get('target_blank',null) }} >
                    <i class="{{ $item->get('icon') }} pr-2" ></i>{{ $item->get('text') }}
                </a>
            @endforeach
        </div>
    </div>
@endif
