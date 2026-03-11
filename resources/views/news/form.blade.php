{{-- compartido: usado en create.blade.php y edit.blade.php --}}

@push('styles')
    <style>
        /* ── Form wrapper ─────────────────────────────────────────────────────── */
        .form-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .form-page-title {
            font-family: var(--font-display);
            font-size: 28px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--black);
        }

        .form-back {
            font-size: 13px;
            color: var(--gray-mid);
            font-weight: 600;
            transition: color .2s;
        }
        .form-back:hover { color: var(--black); }

        .form-card {
            background: var(--white);
            padding: 36px 40px;
            max-width: 860px;
        }

        /* ── Errores de validación ────────────────────────────────────────────── */
        .form-errors {
            background: #fdf0f0;
            border-left: 4px solid var(--red);
            padding: 14px 18px;
            margin-bottom: 28px;
        }

        .form-errors p {
            font-size: 13px;
            font-weight: 700;
            color: var(--red-dark);
            margin-bottom: 8px;
        }

        .form-errors ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .form-errors ul li {
            font-size: 13px;
            color: var(--red-dark);
        }
        .form-errors ul li::before { content: '— '; }

        /* ── Grid del formulario ──────────────────────────────────────────────── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group--full { grid-column: 1 / -1; }

        /* ── Labels ───────────────────────────────────────────────────────────── */
        .form-label {
            font-family: var(--font-display);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #555;
        }

        /* ── Inputs, selects, textarea ────────────────────────────────────────── */
        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 10px 14px;
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--text);
            background: var(--white);
            border: 1px solid var(--gray-light);
            outline: none;
            transition: border-color .2s;
            appearance: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--black);
        }

        .form-input.is-invalid,
        .form-select.is-invalid,
        .form-textarea.is-invalid {
            border-color: var(--red);
        }

        .form-textarea { resize: vertical; min-height: 260px; line-height: 1.6; }

        /* Select con flecha custom */
        .form-select-wrap { position: relative; }
        .form-select-wrap::after {
            content: '▾';
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: var(--gray-mid);
            pointer-events: none;
        }

        /* ── Image upload ─────────────────────────────────────────────────────── */
        .form-file-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border: 1px dashed var(--gray-mid);
            cursor: pointer;
            transition: border-color .2s;
            font-size: 13px;
            color: var(--gray-mid);
        }
        .form-file-label:hover { border-color: var(--black); color: var(--black); }
        .form-file-label input[type="file"] { display: none; }

        .form-image-preview {
            margin-top: 10px;
            max-width: 220px;
        }
        .form-image-preview img {
            width: 100%;
            border: 1px solid var(--gray-light);
        }
        .form-image-caption {
            font-size: 11px;
            color: var(--gray-mid);
            margin-top: 4px;
        }

        /* ── Footer del form ──────────────────────────────────────────────────── */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid var(--gray-light);
        }

        .btn--save {
            background: var(--red);
            color: var(--white);
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 11px 28px;
            border: none;
            cursor: pointer;
            transition: background .2s;
        }
        .btn--save:hover { background: var(--red-dark); }

        .btn--cancel {
            font-size: 13px;
            color: var(--gray-mid);
            font-weight: 600;
            transition: color .2s;
        }
        .btn--cancel:hover { color: var(--black); }

        @media (max-width: 640px) {
            .form-card { padding: 24px 20px; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
@endpush

{{-- ── Errores ─────────────────────────────────────────────────────────────── --}}
<div class="form-grid">

    {{-- Título --}}
    <div class="form-group form-group--full">
        <label class="form-label" for="title">Title</label>
        <input
            class="form-input {{ $errors->has('title') ? 'is-invalid' : '' }}"
            type="text"
            id="title"
            name="title"
            value="{{ old('title', $news->title ?? '') }}"
            placeholder="Article title..."
        >
    </div>

    {{-- Sección --}}
    <div class="form-group">
        <label class="form-label" for="section_id">Section</label>
        <div class="form-select-wrap">
            <select
                class="form-select {{ $errors->has('section_id') ? 'is-invalid' : '' }}"
                id="section_id"
                name="section_id"
            >
                <option value="">— Select section —</option>
                @foreach ($sections as $section)
                    <option value="{{ $section->id }}"
                        {{ old('section_id', $news->section_id ?? '') == $section->id ? 'selected' : '' }}>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Status --}}
    <div class="form-group">
        <label class="form-label" for="status_id">Status</label>
        <div class="form-select-wrap">
            <select
                class="form-select {{ $errors->has('status_id') ? 'is-invalid' : '' }}"
                id="status_id"
                name="status_id"
            >
                <option value="">— Select status —</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->id }}"
                        {{ old('status_id', $news->status_id ?? '') == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Contenido --}}
    <div class="form-group form-group--full">
        <label class="form-label" for="content">Content</label>
        <textarea
            class="form-textarea {{ $errors->has('content') ? 'is-invalid' : '' }}"
            id="content"
            name="content"
            placeholder="Write the article content here..."
        >{{ old('content', $news->content ?? '') }}</textarea>
    </div>

    {{-- Imagen --}}
    <div class="form-group form-group--full">
        <label class="form-label">Image</label>
        <label class="form-file-label">
            <input type="file" name="image" accept="image/jpg,image/jpeg,image/png,image/webp">
            <span>Elegir una imagen — JPG, PNG or WEBP, max 2MB</span>
        </label>

        @if (!empty($news->image_url ?? null))
            <div class="form-image-preview">
                <img src="{{ $news->image_url }}" alt="Current image">
                <p class="form-image-caption">Imagen actual — Seleccionar una nueva reemplazará esta.</p>
            </div>
        @endif
    </div>

</div>
