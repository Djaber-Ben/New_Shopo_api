@extends('admin.layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <h3>إنشاء الأسئلة الشائعة</h3>
                {{-- <div class="container">
                <h1>إنشاء الأسئلة الشائعة</h1> --}}

                <form action="{{ route('faqs.store') }}" method="POST">
                    @csrf

                    <div id="faq-container">
                        <div class="faq-item border p-4 mb-4 rounded-lg bg-gray-50">
                            <div class="mb-3">
                                <label for="question_0" class="form-label">السؤال</label>
                                <input type="text" name="questions[]" id="question_0" class="form-control" placeholder="Enter a question" required>
                            </div>

                            <div class="mb-3">
                                <label for="answer_0" class="form-label">الجواب</label>
                                <textarea name="answers[]" id="answer_0" class="form-control wysiwyg" rows="3" placeholder="Enter the answer"></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="add-faq" class="btn btn-secondary mb-3">+ إضافة سؤال آخر</button>
                    <br>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let index = 1;

    // Initialize the first summernote editor
    $('.wysiwyg').summernote({
        height: 150,
        placeholder: 'Enter the answer here...'
    });

    // Add new FAQ item dynamically
    document.getElementById('add-faq').addEventListener('click', function () {
        const container = document.getElementById('faq-container');

        const newItem = document.createElement('div');
        newItem.classList.add('faq-item', 'border', 'p-4', 'mb-4', 'rounded-lg', 'bg-gray-50');
        newItem.innerHTML = `
            <div class="mb-3">
                <label for="question_${index}" class="form-label">السؤال</label>
                <input type="text" name="questions[]" id="question_${index}" class="form-control" placeholder="Enter a question" required>
            </div>
            <div class="mb-3">
                <label for="answer_${index}" class="form-label">الجواب</label>
                <textarea name="answers[]" id="answer_${index}" class="form-control wysiwyg" rows="3" placeholder="Enter the answer" required></textarea>
            </div>
        `;

        container.appendChild(newItem);

        // Initialize Summernote for the new textarea
        $(`#answer_${index}`).summernote({
            height: 150,
            placeholder: 'Enter the answer here...'
        });

        index++;
    });

    // Optional: ensure Summernote syncs data before form submission
    document.querySelector('form').addEventListener('submit', function () {
        $('.wysiwyg').each(function () {
            const content = $(this).summernote('code');
            $(this).val(content);
        });
    });
});
</script>

{{-- Include CKEditor --}}
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script> --}}

{{-- TinyMCE or CKEditor (you can pick one) --}}
{{-- <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script> --}}

{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        let index = 1;
        let editors = {}; // store CKEditor instances by element ID
        
        // tinymce.init({ selector: '.wysiwyg', height: 150 });
        // Initialize the first editor
        initCKEditor(document.querySelector('.wysiwyg'));

        // Function to initialize CKEditor safely
        function initCKEditor(element) {
            if (!element) return;
            ClassicEditor.create(element)
                .then(editor => {
                    editors[element.id] = editor;
                })
                .catch(error => console.error(error));
        }

        document.getElementById('add-faq').addEventListener('click', function () {
            const container = document.getElementById('faq-container');

            const newItem = document.createElement('div');
            newItem.classList.add('faq-item', 'border', 'p-4', 'mb-4', 'rounded-lg', 'bg-gray-50');
            newItem.innerHTML = `
                <div class="mb-3">
                    <label for="question_${index}" class="form-label">Question</label>
                    <input type="text" name="questions[]" id="question_${index}" class="form-control" placeholder="Enter a question" required>
                </div>
                <div class="mb-3">
                    <label for="answer_${index}" class="form-label">Answer</label>
                    <textarea name="answers[]" id="answer_${index}" class="form-control wysiwyg" rows="3" placeholder="Enter the answer" required></textarea>
                </div>
            `;

            container.appendChild(newItem);

            // Re-initialize TinyMCE for new textarea
            // tinymce.init({ selector: '.wysiwyg', height: 150 });

            // Re-initialize CKEditor only for the newly added textarea
            const newTextarea = newItem.querySelector('.wysiwyg');
            initCKEditor(newTextarea);

            index++;
        });
    });

    document.querySelector('form').addEventListener('submit', function () {
        Object.keys(editors).forEach(id => {
            const editor = editors[id];
            const data = editor.getData();
            document.getElementById(id).value = data; // sync to hidden textarea
        });
    });

</script> --}}

@endsection