@props(['id' => 'model-id', 'title' => 'Model Title'])

<div style="" class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="model-{{ $id }}"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="model-{{ $id }}">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
