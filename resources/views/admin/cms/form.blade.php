<section class="panel-card">
    <h1>Page CMS</h1>
    <p class="panel-description">Manage hero content for the selected page. Use the Page CMS submenu to switch between pages.</p>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.cms.update', ['page' => $currentPageKey]) }}">
        @csrf

        <div class="page-section">
            <h2>{{ $currentPageLabel }}</h2>
            <div class="field-grid">
                @foreach($fields as $fieldKey => $fieldLabel)
                    <div class="field-card {{ in_array($fieldKey, ['hero_subtitle']) ? 'full-width' : '' }}">
                        <label for="page_{{ $currentPageKey }}_{{ $fieldKey }}">{{ $fieldLabel }}</label>
                        @if($fieldKey === 'hero_subtitle')
                            <textarea id="page_{{ $currentPageKey }}_{{ $fieldKey }}" name="page_{{ $currentPageKey }}_{{ $fieldKey }}">{{ old("page_{$currentPageKey}_{$fieldKey}", $values["page_{$currentPageKey}_{$fieldKey}"] ?? '') }}</textarea>
                        @else
                            <input id="page_{{ $currentPageKey }}_{{ $fieldKey }}" name="page_{{ $currentPageKey }}_{{ $fieldKey }}" type="text" value="{{ old("page_{$currentPageKey}_{$fieldKey}", $values["page_{$currentPageKey}_{$fieldKey}"] ?? '') }}">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Save Page Content</button>
        </div>
    </form>
</section>
