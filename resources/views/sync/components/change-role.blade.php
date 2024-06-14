<div class="card p-3">
    <form action="{{ route('sync.permissions.role') }}">
        <div class="row align-items-center">
            <div class="col-md-2 align-self-center">
                <label for="role" class="form-label">Select role to assign permission:</label>
            </div>
            <div class="col-md-5">
                <select name="role" id="role" class="form-select">
                    <option>Silakan pilih Role</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-5">
                <button class="btn btn-dark">
                    Change role
                </button>
            </div>
        </div>
    </form>
</div>