<div class="form-group @if (isset($postErrors[$input['name']])) has-error @endif">
    <label for="{{ $input['name'] }}">{{ $input['title'] }}</label>
    <input
        type="{{ $input['type'] }}"
        name="{{ $input['name'] }}"
        id="{{ $input['name'] }}"
        class="form-control"
        @if (isset($input['placeholder']))
        placeholder="{{ $input['placeholder'] }}"
        @endif
        @if (isset($postValues[$input['name']]))
        value="{{ $postValues[$input['name']] }}"
        @elseif (isset($input['value']))
        value="{{ $input['value'] }}"
        @endif
    >
    @if (isset($postErrors[$input['name']]))
        <span class="error text-danger">{{ $postErrors[$input['name']] }}</span>
    @endif
</div>
