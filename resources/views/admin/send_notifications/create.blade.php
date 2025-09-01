@extends('admin.layout.app')


@section('main-content')
    <x-Admin.Shared.form-page-container title="Send Notification">
        <form id="email-template-form" action="{{ route('admin.send-notifications.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Send To</label>
                        <select id="send_to" name="send_to" class="form-control mb-3">
                            <option value="">-- Select ---</option>
                            <option value="all" @selected(old('send_to') == 'all')>All Users</option>
                            <option value="specific" @selected(old('send_to') == 'specific')>Specific User</option>
                            <option value="subscribers" @selected(old('send_to') == 'subscribed')>Subscribers</option>
                        </select>
                    </div>
                    @error('send_to')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-3" id="subscription_status_div"
                    style="display: {{ old('send_to') == 'subscribers' ? 'block' : 'none' }};">
                    <div class="form-group">
                        <label>Subscription Status</label>
                        <select id="status" name="status" class="form-control mb-3" id="">
                            <option value="">-- Select ---</option>
                            <option value="all">All</option>
                            <option value="1">Active</option>
                            <option value="0">Exprie</option>
                        </select>
                    </div>
                    @error('subscribers')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                </div>
                <div class="col-3" id="specific_user_div"
                    style="display: {{ old('send_to') == 'specific' ? 'block' : 'none' }};">
                    <x-Admin.Shared.input-form-group label="Email *" name="email" value="{{ old('email') }}"
                        errorKey="email" />
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <x-Admin.Shared.input-form-group label="Subject *" name="subject" value="{{ old('subject') }}"
                        errorKey="subject" />
                </div>

            </div>

            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="message" id="body_editor-content">
                    <label>Body *</label>
                    <div id="body_editor" style="height: 150px;">
                        {!! old('body') !!}
                    </div>
                    <x-Shared.input-error field="body" />

                </div>
            </div>
            <div class="col-3 mt-2">
                <input type="file" name="attachements[]" class="custom-file-input" accept="image/*" id="customFile"
                    multiple>
                <label class="custom-file-label" for="customFile">Attachement</label>
            </div>

            <span class="d-flex justify-content-between w-100">
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </span>
        </form>
    </x-Admin.Shared.form-page-container>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            const quill_body_editor = new Quill('#body_editor', {
                theme: 'snow',
            });

            document.getElementById('email-template-form').addEventListener('submit', function(e) {
                const editorContent = quill_body_editor.root.innerHTML;
                document.getElementById('body_editor-content').value = editorContent;
            });

            $('#send_to').on('change', function() {
                const send_to = $(this).val();
                if (send_to == 'specific') {
                    $('#specific_user_div').show();
                    $('#subscription_status_div').hide();
                } else if (send_to == 'subscribers') {
                    $('#subscription_status_div').show();
                    $('#specific_user_div').hide();
                } else {
                    $('#specific_user_div').hide();
                    $('#subscription_status_div').hide();
                }
            });
        })
    </script>
@endpush
