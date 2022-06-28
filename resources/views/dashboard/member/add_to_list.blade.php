@foreach($lists as $list)
    <div class="row">
        <div class="col">
            {{ $list->title }} <span class="badge badge-info">{{ $list->type }}</span>
        </div>
        <div class="col text-right">
            <a href="{{ route('add.member.to-list', ['list_id'=>$list->uuid, 'member_id'=>$member->uuid]) }}" class="btn btn-primary btn-tone">
                <span class="m-l-5">Add Here</span>
            </a>
        </div>
    </div>
    <hr class="mt-2 mb-2">
@endforeach