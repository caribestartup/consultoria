<div class="form-group">
    <label>{{ trans_choice('common.topic', 2) }}</label>
    <div>
        <select multiple="multiple" name="topic[]" class="topic-i multiselect">
            @isset($parent)
                @php
                    $topic_ids = [];
                    foreach($parent->topics as $topic) {
                        $topic_ids[] = $topic->id;
                    }

                @endphp
            @endisset
            @foreach($topics as $topic)
                <option value="{{ $topic->id }}"
                        @isset($topic_ids)
                        @if( array_search($topic->id, $topic_ids) !== false)
                        selected="selected"
                        @endif
                        @endisset
                >{{ $topic->value }}</option>
            @endforeach
        </select>
    </div>
</div>