@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="text-center">Edit {{ ucfirst($siteInfo->key) }}</h4>

                {{-- @if(session('success'))
                    <div class="alert alert-success mt-3">{{ session('success') }}</div>
                @endif --}}
                @include('admin.message')

                <form action="{{ route('siteInfos.update', $siteInfo->key) }}" method="POST">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="content">Content</label>
                        <textarea name="content" id="editor" rows="10" class="form-control">{{ old('content', $siteInfo->content) }}</textarea>
                        @error('content')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            toolbar: [
                'undo', 'redo', '|',
                'heading', '|',
                'bold', 'italic', 'underline', 'link', '|',
                'bulletedList', 'numberedList', '|',
                'blockQuote', 'insertTable', 'mediaEmbed'
            ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection