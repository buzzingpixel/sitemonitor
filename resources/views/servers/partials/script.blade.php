<?php

$id = uniqid('script_', false);

$scriptId = $scriptId ?? '';
$scriptName = $scriptName ?? '';
$scriptContent = $scriptContent ?? '';

?>

<div class="panel panel-default js-script">
    <input
        type="hidden"
        name="scripts[{{ $id }}][scriptId]"
        value="{{ $scriptId }}"
    >
    <input
        type="hidden"
        name="scripts[{{ $id }}][scriptDelete]"
        class="js-script-delete"
    >
    <div class="panel-heading">
        <span class="glyphicon glyphicon-move u-cursor-move js-script-sort-handle" aria-hidden="true"></span> Script<span class="js-script-name-holder"></span>
    </div>
    <div class="panel-body js-script-body">
        <div class="form-group ">
            <label for="scripts[{{ $id }}][scriptName]">Script Name</label>
            <input
                type="text" name="scripts[{{ $id }}][scriptName]"
                id="scripts[{{ $id }}][scriptName]"
                class="form-control js-script-name"
                value="{{ $scriptName }}"
            >
        </div>
        <div class="form-group">
            <label for="scripts[{{ $id }}][scriptContent]">Script Content</label>
            <textarea
                name="scripts[{{ $id }}][scriptContent]"
                id="scripts[{{ $id }}][scriptContent]"
                rows="1"
                class="form-control js-code-editor"
            >{{ $scriptContent }}</textarea>
        </div>
        <div class="form-group">
            <a class="btn btn-danger js-remove-script">Remove Script</a>
        </div>
    </div>
</div>
