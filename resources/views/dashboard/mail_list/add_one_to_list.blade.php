<div class="">
    <form action="{{ route('store.one.to.mail-list') }}" method="post">
        @csrf
        <input type="hidden" name="list_id" value="{{ $list->uuid }}">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputPassword4">First Name</label>
                <input type="text" name="first_name" class="form-control" id="title" placeholder="First Name" autocomplete="off" required>
            </div>

            <div class="form-group col-md-6">
                <label for="inputPassword4">Email Address</label>
                <input type="email" name="email" class="form-control" id="title" placeholder="Email Address" autocomplete="off" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Recipient</button>
    </form>
</div>