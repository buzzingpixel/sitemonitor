<div class="form-group">
    <label>Servers</label><br>
    <label>
        <input type="checkbox" name="allServers" value="1"> All servers
    </label>
    <br>
    <label>
        <select
                name="servers[]"
                class="form-control"
                multiple
                style="min-height: {{ $serverSelectPadding  }}px;"
        >
            @foreach ($serverGroups as $serverGroup)
                <?php /** @var \App\ServerGroup $serverGroup */ ?>
                @if ($serverGroup->servers->count())
                    <optgroup label="{{ $serverGroup->name }}">
                        @foreach ($serverGroup->servers as $server)
                            <?php /** @var \App\Server $server */ ?>
                            <option value="{{ $server->id }}">
                                {{ $server->name }}
                            </option>
                        @endforeach
                    </optgroup>
                @endif
            @endforeach
            @if ($unGroupedServers->count())
                <optgroup label="Un-grouped">
                    @foreach ($unGroupedServers as $server)
                        <?php /** @var \App\Server $server */ ?>
                        <option value="{{ $server->id }}">
                            {{ $server->name }}
                        </option>
                    @endforeach
                </optgroup>
            @endif
        </select>
    </label>
</div>
