<div class="">
    <form action="{{ route('member.store') }}" method="post">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="fn">First Name</label>
                <input type="text" name="first_name" class="form-control" id="fn" placeholder="First Name" autocomplete="off" required>
            </div>
            <div class="form-group col-md-6">
                <label for="ln">Last Name</label>
                <input type="text" name="last_name" class="form-control" id="ln" placeholder="Last Name" autocomplete="off">
            </div>

            <div class="form-group col-md-6">
                <label for="em">Email Address</label>
                <input type="email" name="email" class="form-control" id="title" placeholder="Email Address" autocomplete="off" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
