<x-Admin.Shared.model-layout id="blog-category-model" title="Add New Category">
    <form action="{{ route('admin.blog-categories.store') }}" method="POST" id="blog-category-form">
        @csrf
        <div class="modal-body">
            <x-Admin.Shared.input-form-group label="Name" name="name" value="{{ old('name') }}" errorKey="name" />
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Short Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3"></textarea>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control mb-3">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" id="blog-category-submit-btn">Add Category</button>
        </div>
    </form>
</x-Admin.Shared.model-layout>
