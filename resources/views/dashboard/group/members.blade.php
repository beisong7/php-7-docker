<table class="table">
    @foreach($members as $member)
        <tr class="remove{{ $member->uuid }}">
            <td>{{ $member->names }}</td>
            <td>{{ $member->email }}</td>
            <td>
                <a href="{{ route('group.remove.member', ['id'=>$group->uuid,'member_id'=>$member->uuid]) }}"
                   uuid="{{ $member->uuid }}"
                   class="btn btn-danger btn-tone remove_member">
                    <i class="fas fa-trash"></i>
                    <span class="m-l-5">Delete</span>
                </a>
            </td>
        </tr>
    @endforeach
</table>
<script>
    $('.remove_member').on('click', function(e){
        e.preventDefault();
        $(this).children().remove();
        let uuid = $(this).attr('uuid');
        $(this).append(`<span>Loading...</span>`)
        let url = $(this).attr('href');
        $.get( url, function() {

        }).done(function(data) {
            //delete row
            console.log(data);
            if(data.successful==='yes'){
                $(`.remove${uuid}`).remove();
            }
        }).fail(function() {
            $(this).append(`<i class="fas fa-trash"></i><span class="m-l-5">Delete</span>`)
        }).always(function() {

        });
    });
</script>
