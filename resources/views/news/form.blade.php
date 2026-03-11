{{-- Partial compartido: usado en create.blade.php y edit.blade.php --}}

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<div>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ old('title', $news->title ?? '') }}">
</div>

<div>
    <label for="section_id">Section</label>
    <select id="section_id" name="section_id">
        <option value="">— Select —</option>
        @foreach ($sections as $section)
            <option value="{{ $section->id }}"
                {{ old('section_id', $news->section_id ?? '') == $section->id ? 'selected' : ''}}>
                {{ $section->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label for="status_id">Status</label>
    <select id="status_id" name="status_id">
        <option value="">— Select —</option>
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}"
                {{ old('status_id', $news->status_id ?? '') == $status->id ? 'selected' : (($status->id == 1) ? 'selected' : '' ) }}>
                {{ $status->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label for="content">Content</label>
    <textarea id="content" name="content" rows="10">{{ old('content', $news->content ?? '') }}</textarea>
</div>

<div>
    <label for="image">Image</label>
    <input type="file" id="image" name="image" accept="image/*">

    {{-- Preview de imagen actual al editar --}}
    @if (!empty($news->image_url))
        <img src="{{ $news->image_url }}" alt="Current image">
    @endif
</div>

<button type="submit">Save</button>
