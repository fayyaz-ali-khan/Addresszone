<x-Admin.Shared.model-layout id="service-category-model" title="Add New Service Category">
    <form action="{{ route('admin.service_categories.store') }}" method="POST" id="service-category-form">
        @csrf
        <div class="modal-body">
            <x-Admin.Shared.input-form-group label="Name" name="name" value="{{ old('name') }}" errorKey="name" />
            <div class="form-group">
                <label for="exampleFormControlTextarea1"> Description</label>
                <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="status" name="status" class="form-control mb-3">
                    <option value="1">Active</option>
                    <option value="0">De Active</option>
                </select>
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit" id="category-submit-btn">Add Service Category</button>
        </div>
    </form>
</x-Admin.Shared.model-layout>
